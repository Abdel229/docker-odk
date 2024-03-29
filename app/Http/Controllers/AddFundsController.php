<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\AdminSettings;
use App\Models\Deposits;
use App\Models\PaymentGateways;
use App\Models\User;
use App\Notifications\AdminDepositPending;
use Exception;
use Fahim\PaypalIPN\PaypalIPNListener;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;
use Mollie\Api\MollieApiClient;
use Razorpay\Api\Api;
use Stripe\StripeClient;
use Yabacon\Paystack;
use App\Services\cinetpay\CinetPayService;

class AddFundsController extends Controller
{
    use Traits\Functions;

    public function __construct(Request $request, AdminSettings $settings)
    {
        $this->request = $request;
        $this->settings = $settings::first();
    }

    /**
     *  Wallet View
     *
     * @return Response|Application|Factory|View
     */
    public function wallet()
    {
        if ($this->settings->disable_wallet == 'on') {
            abort(404);
        }
        $data = Deposits::whereUserId(auth()->user()->id)->orderBy('id', 'desc')->paginate(20);

        $equivalent_money = Helper::equivalentMoney($this->settings->wallet_format);

        return view('users.wallet', ['data' => $data, 'equivalent_money' => $equivalent_money]);
    }

    /**
     *  Add Funds Request
     *
     * @return Response|JsonResponse
     */
    public function send()
    {

        // Validate Payment Gateway
        Validator::extend('check_payment_gateway', function ($attribute, $value, $parameters) {
            return PaymentGateways::whereName($value)->first();
        });

        // Currency Position
        if ($this->settings->currency_position == 'right') {
            $currencyPosition = 2;
        } else {
            $currencyPosition = null;
        }

        $messages = array(
            'amount.min' => trans('general.amount_minimum' . $currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
            'amount.max' => trans('general.amount_maximum' . $currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
            'payment_gateway.check_payment_gateway' => trans('general.payments_error'),
            'image.required_if' => trans('general.please_select_image'),
        );

        //<---- Validation
        $validator = Validator::make($this->request->all(), [
            'amount' => 'required|integer|min:' . $this->settings->min_deposits_amount . '|max:' . $this->settings->max_deposits_amount,
            'payment_gateway' => 'required|check_payment_gateway',
            'image' => 'required_if:payment_gateway,==,Bank|mimes:jpg,gif,png,jpe,jpeg|max:' . $this->settings->file_size_allowed_verify_account . '',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }
        try {

            switch ($this->request->payment_gateway) {
                case 'PayPal':
                    return $this->sendPayPal();
                case 'Stripe':
                    return $this->sendStripe();
                case 'Bank':
                    return $this->sendBankTransfer();
                case 'CCBill':
                    return $this->ccbillForm(
                        $this->request->amount,
                        auth()->user()->id,
                        'wallet'
                    );
                case 'Paystack':
                    return $this->sendPaystack();
                case 'Coinpayments':
                    return $this->sendCoinpayments();
                case 'Mercadopago':
                    return $this->sendMercadopago();
                case 'Flutterwave':
                    return $this->sendFlutterwave();
                case 'Mollie':
                    return $this->sendMollie();
                case 'Razorpay':
                    return $this->sendRazorpay();
                case 'Cinetpay':
                    return $this->sendCinetPay();
            }

        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
        return response()->json([
            'success' => true,
            'insertBody' => '<i></i>'
        ]);

    } // End method Send

    /**
     *  Add funds PayPal
     *
     * @return Response|JsonResponse
     */
    protected function sendPayPal()
    {
        // Get Payment Gateway
        $payment = PaymentGateways::whereId(1)->whereName('PayPal')->firstOrFail();

        // Verify environment Sandbox or Live
        if ($payment->sandbox == 'true') {
            $action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        } else {
            $action = "https://www.paypal.com/cgi-bin/webscr";
        }

        $urlSuccess = route('paymentProcess');
        $urlCancel = url('my/wallet');

        $urlPaypalIPN = url('paypal/add/funds/ipn');

        $feePayPal = $payment->fee;
        $centsPayPal = $payment->fee_cents;

        $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;
        $taxesPayable = $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null;

        $amountFixed = number_format($this->request->amount + ($this->request->amount * $feePayPal / 100) + $centsPayPal + $taxes, 2, '.', '');
        return response()->json([
            'success' => true,
            'insertBody' => '<form id="form_pp" name="_xclick" action="' . $action . '" method="post"  style="display:none">
                  <input type="hidden" name="cmd" value="_xclick">
                  <input type="hidden" name="return" value="' . $urlSuccess . '">
                  <input type="hidden" name="cancel_return"   value="' . $urlCancel . '">
                  <input type="hidden" name="notify_url" value="' . $urlPaypalIPN . '">
                  <input type="hidden" name="currency_code" value="' . $this->settings->currency_code . '">
                  <input type="hidden" name="amount" id="amount" value="' . $amountFixed . '">
                  <input type="hidden" name="no_shipping" value="1">
                  <input type="hidden" name="custom" value="id=' . auth()->user()->id . '&amount=' . $this->request->amount . '&taxes=' . $taxesPayable . '">
                  <input type="hidden" name="item_name" value="' . __('general.add_funds') . ' @' . auth()->user()->username . '">
                  <input type="hidden" name="business" value="' . $payment->email . '">
                  <input type="submit">
                  </form> <script type="text/javascript">document._xclick.submit();</script>',
        ]);
    } // sendPayPal

    /**
     *  Add funds Stripe
     *
     * @return Response
     */
    protected function sendStripe()
    {
        // Get Payment Gateway
        $payment = PaymentGateways::whereName('Stripe')->firstOrFail();

        $feeStripe = $payment->fee;
        $centsStripe = $payment->fee_cents;

        $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

        if ($this->settings->currency_code == 'JPY') {
            $amountFixed = round($this->request->amount + ($this->request->amount * $feeStripe / 100) + $centsStripe + $taxes);
        } else {
            $amountFixed = number_format($this->request->amount + ($this->request->amount * $feeStripe / 100) + $centsStripe + $taxes, 2, '.', '');
        }

        $amountGross = ($this->request->amount);
        $amount = $this->settings->currency_code == 'JPY' ? $amountFixed : ($amountFixed * 100);

        $currency_code = $this->settings->currency_code;
        $description = __('general.add_funds') . ' @' . auth()->user()->username;

        $stripe = new StripeClient($payment->key_secret);

        $checkout = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency_code,
                    'product_data' => [
                        'name' => $description,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',

            'metadata' => [
                'user' => auth()->id(),
                'amount' => $this->request->amount,
                'taxes' => $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null,
                'type' => 'deposit'
            ],

            'payment_method_types' => ['card'],
            'customer_email' => auth()->user()->email,

            'success_url' => url('my/wallet'),
            'cancel_url' => url('my/wallet'),
        ]);

        return response()->json([
            'success' => true,
            'url' => $checkout->url,
        ]);

    }//<----- End Method paypalIpn()

    public function sendBankTransfer()
    {
        // PATHS
        $path = config('path.admin');

        if ($this->request->hasFile('image')) {

            $extension = $this->request->file('image')->getClientOriginalExtension();
            $fileImage = 'bt_' . strtolower(auth()->user()->id . time() . str_random(40) . '.' . $extension);

            $this->request->file('image')->storePubliclyAs($path, $fileImage);

        }//<====== End HasFile

        // Insert Deposit
        $deposit = $this->deposit(
            auth()->user()->id,
            'bt_' . str_random(25),
            $this->request->amount,
            'Bank',
            $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null,
            $fileImage
        );

        // Notify Admin via Email
        try {
            Notification::route('mail', $this->settings->email_admin)
                ->notify(new AdminDepositPending($deposit));
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }

        return response()->json([
            "success" => true,
            "status" => 'pending',
            'status_info' => __('general.pending_deposit')
        ]);

    } // End Method sendStripe

    public function sendPaystack()
    {
        $payment = PaymentGateways::whereName('Paystack')->whereEnabled(1)->firstOrFail();
        $paystack = new Paystack($payment->key_secret);

        $fee = $payment->fee;
        $cents = $payment->fee_cents;

        $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

        $amount = number_format($this->request->amount + ($this->request->amount * $fee / 100) + $cents + $taxes, 2, '.', '');

        if (isset($this->request->trxref)) {

            try {
                $tranx = $paystack->transaction->verify([
                    'reference' => $this->request->trxref,
                ]);
            } catch (Exception $e) {
                return response()->json([
                    "success" => false,
                    'errors' => ['error' => $e->getMessage()]
                ]);
            }

            if ('success' === $tranx->data->status) {
                // Verify Deposit
                $verifyTxnId = Deposits::where('txn_id', $tranx->data->reference)->first();

                if (!isset($verifyTxnId)) {

                    // Insert Deposit
                    $this->deposit(
                        auth()->user()->id,
                        $tranx->data->reference,
                        $this->request->amount,
                        'Paystack',
                        $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null
                    );

                    // Add Funds to User
                    User::find(auth()->user()->id)->increment('wallet', $this->request->amount);

                    return response()->json([
                        "success" => true,
                        'instantPayment' => true
                    ]);
                }// verifyTxnId
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => ['error' => $tranx->data->gateway_response],
                ]);
            }
        } else {
            return response()->json([
                'success' => true,
                'insertBody' => "<script type='text/javascript'>var handler = PaystackPop.setup({
          key: '" . $payment->key . "',
          email: '" . auth()->user()->email . "',
          amount: " . ($amount * 100) . ",
          currency: '" . $this->settings->currency_code . "',
          ref: '" . Helper::genTranxRef() . "',
          callback: function(response) {
            var input = $('<input type=hidden name=trxref />').val(response.reference);
            $('#formAddFunds').append(input);
            $('#addFundsBtn').trigger('click');
          },
          onClose: function() {
              alert('Window closed');
          }
        })
        handler.openIframe();</script>"
            ]);
        }
    } // End method sendBankTransfer

    /**
     *  Add funds CoinPaments
     *
     * @return Response
     */
    protected function sendCoinpayments()
    {
        // Get Payment Gateway
        $payment = PaymentGateways::whereName('Coinpayments')->firstOrFail();

        $urlSuccess = route('paymentProcess');
        $urlCancel = url('my/wallet');

        $urlIPN = route('coinpaymentsIPN', [
            'user' => auth()->user()->id,
            'amountOriginal' => $this->request->amount,
            'taxes' => $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null
        ]);

        $fee = $payment->fee;
        $cents = $payment->fee_cents;

        $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

        $amountFixed = number_format($this->request->amount + ($this->request->amount * $fee / 100) + $cents + $taxes, 2, '.', '');

        return response()->json([
            'success' => true,
            'insertBody' => '<form name="_click" action="https://www.coinpayments.net/index.php" method="post"  style="display:none">
                  <input type="hidden" name="cmd" value="_pay">
                  <input type="hidden" name="reset" value="1"/>
                  <input type="hidden" name="merchant" value="' . $payment->key . '">
                  <input type="hidden" name="success_url" value="' . $urlSuccess . '">
                  <input type="hidden" name="cancel_url"   value="' . $urlCancel . '">
                  <input type="hidden" name="ipn_url" value="' . $urlIPN . '">
                  <input type="hidden" name="currency" value="' . $this->settings->currency_code . '">
                  <input type="hidden" name="amountf" value="' . $amountFixed . '">
                  <input type="hidden" name="want_shipping" value="0">
                  <input type="hidden" name="item_name" value="' . __('general.add_funds') . ' @' . auth()->user()->username . '">
                  <input type="hidden" name="email" value="' . auth()->user()->email . '">
                  <input type="hidden" name="first_name" value="' . auth()->user()->firstname . '">
                  <input type="hidden" name="last_name" value="' . auth()->user()->lastname . '">
                  <input type="submit">
                  </form> <script type="text/javascript">document._click.submit();</script>',
        ]);
    }// end method

    public function sendMercadopago()
    {
        try {
            // Get Payment Gateway
            $payment = PaymentGateways::whereName('Mercadopago')->firstOrFail();

            $fee = $payment->fee;

            $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

            $amountFixed = number_format($this->request->amount + ($this->request->amount * $fee / 100) + $taxes, 2, '.', '');

            // Mercadopago secret key
            SDK::setAccessToken($payment->key_secret);

            // Create a preference object
            $preference = new Preference();

            // Preference item
            $item = new Item();
            $item->title = __('general.add_funds') . ' @' . auth()->user()->username;
            $item->quantity = 1;
            $item->unit_price = $amountFixed;
            $item->currency_id = $this->settings->currency_code;

            // Item to preference
            $preference->items = [$item];

            // Auto-return
            $preference->auto_return = 'approved';

            // Return url
            $preference->back_urls = ['success' => route('mercadopadoProcess', [
                'userId' => auth()->user()->id,
                'amountOriginal' => $this->request->amount,
                'userTaxes' => $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null
            ])];

            // External reference
            $preference->external_reference = 'userId=' . auth()->user()->id . ',amountOriginal=' . $this->request->amount . ',userTaxes=' . auth()->user()->taxesPayable() . '';

            $preference->payment_methods = array(
                "excluded_payment_types" => array(
                    array("id" => "cash")
                ),
                "installments" => 1
            );

            $preference->save();

            // binary only
            $preference->binary_mode = true;

            // Redirect to payment
            $redirectUrl = $payment->sandbox == 'true' ? $preference->sandbox_init_point : $preference->init_point;

            return response()->json([
                'success' => true,
                'url' => $redirectUrl
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['error' => $e->getMessage()],
            ]);
        }

    } // sendCoinpayments

    // CoinPaments IPN

    public function sendFlutterwave()
    {
        try {

            // Get Payment Gateway
            $payment = PaymentGateways::whereName('Flutterwave')->firstOrFail();

            $fee = $payment->fee;

            $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

            $amountFixed = number_format($this->request->amount + ($this->request->amount * $fee / 100) + $taxes, 2, '.', '');

            //This generates a payment reference
            $reference = Flutterwave::generateReference();

            // Enter the details of the payment
            $data = [
                'payment_options' => 'card,banktransfer',
                'amount' => $amountFixed,
                'email' => request()->email,
                'tx_ref' => $reference,
                'currency' => $this->settings->currency_code,
                'redirect_url' => route('flutterwaveCallback'),
                'customer' => [
                    'email' => auth()->user()->email,
                    "name" => auth()->user()->name
                ],

                "meta" => [
                    "user" => auth()->id(),
                    "amountFinal" => $this->request->amount,
                    "taxes" => $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null
                ],

                "customizations" => [
                    "title" => __('general.add_funds') . ' @' . auth()->user()->username
                ]
            ];

            $payment = Flutterwave::initializePayment($data);

            if ($payment['status'] !== 'success') {
                return response()->json([
                    'success' => false,
                    'errors' => ['error' => __('general.error')],
                ]);
            }

            return response()->json([
                'success' => true,
                'url' => $payment['data']['link']
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['error' => $e->getMessage()],
            ]);
        }

    } // coinPaymentsIPN

    // Return Success Page Payment in Process

    public function sendMollie()
    {
        // Get Payment Gateway
        $paymentGateway = PaymentGateways::whereName('Mollie')->firstOrFail();

        $mollie = new MollieApiClient();
        $mollie->setApiKey($paymentGateway->key);

        $fee = $paymentGateway->fee;
        $cents = $paymentGateway->fee_cents;

        $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

        $amount = number_format($this->request->amount + ($this->request->amount * $fee / 100) + $cents + $taxes, 2, '.', '');

        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => $this->settings->currency_code,
                'value' => $amount, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => __('general.add_funds') . ' @' . auth()->user()->username,
            'webhookUrl' => url('webhook/mollie'),
            'redirectUrl' => url('my/wallet'),
            "metadata" => array(
                'user_id' => auth()->user()->id,
                'amount' => $this->request->amount,
                'taxes' => $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null
            )
        ]);

        $payment = $mollie->payments->get($payment->id);

        return response()->json([
            'success' => true,
            'url' => $payment->getCheckoutUrl(), // redirect customer to Mollie checkout page
        ]);

    }

    // Sent payment Mercadopago

    public function sendRazorpay()
    {
        // Get Payment Gateway
        $paymentGateway = PaymentGateways::whereName('Razorpay')->firstOrFail();

        $fee = $paymentGateway->fee;
        $cents = $paymentGateway->fee_cents;

        $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

        $amountFixed = number_format($this->request->amount + ($this->request->amount * $fee / 100) + $cents + $taxes, 2, '.', '');
        $amount = ($amountFixed * 100);

        if (isset($this->request->payment_id)) {

            //Input items of form
            $input = $this->request->all();
            //get API Configuration
            $api = new Api($paymentGateway->key, $paymentGateway->key_secret);
            //Fetch payment information by razorpay_payment_id
            $payment = $api->payment->fetch($this->request->payment_id);

            if (count($input)) {
                try {
                    $response = $api->payment->fetch($this->request->payment_id)->capture(array('amount' => $payment['amount']));

                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['error' => $e->getMessage()],
                    ]);
                }

                // Insert DB
                $this->deposit(
                    auth()->user()->id,
                    $response->id,
                    $this->request->amount,
                    'Razorpay',
                    $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null,
                );

                //Add Funds to User
                auth()->user()->increment('wallet', $this->request->amount);
            }

            return response()->json([
                "success" => true,
                "url" => url('my/wallet')
            ]);

        } else {
            return response()->json([
                'success' => true,
                'insertBody' => "<script type='text/javascript'>var options = {
            'key': '" . $paymentGateway->key . "',
            'amount': " . $amount . ", // 2000 paise = INR 20
            'name': '" . $this->settings->title . "',
            'description': '" . __('general.add_funds') . ' @' . auth()->user()->username . "',
            'handler': function (response){

              var input = $('<input type=hidden name=payment_id />').val(response.razorpay_payment_id);
              $('#formAddFunds').append(input);
              $('#addFundsBtn').trigger('click');
            },

            'prefill': {
               'name': '" . auth()->user()->username . "',
               'email':   '" . auth()->user()->email . "',
            },

            'theme': {
                'color': '#00A65A'
            }
            }
            var rzp1 = new Razorpay(options);
            rzp1.open();
            </script>"
            ]);
        }
    }// End Method sendMercadopago

    /**
     * PayPal IPN
     *
     * @return void
     */
    public function paypalIpn()
    {

        $ipn = new PaypalIPNListener();

        $ipn->use_curl = false;

        $payment = PaymentGateways::find(1);

        if ($payment->sandbox == 'true') {
            // SandBox
            $ipn->use_sandbox = true;
        } else {
            // Real environment
            $ipn->use_sandbox = false;
        }

        $verified = $ipn->processIpn();

        $custom = $_POST['custom'];
        parse_str($custom, $data);

        $payment_status = $_POST['payment_status'];
        $txn_id = $_POST['txn_id'];

        // Validate Amount
        if ($_POST['mc_gross'] < $this->settings->min_deposits_amount) {
            exit;
        }

        if ($verified) {
            if ($payment_status == 'Completed') {

                // Check outh POST variable and insert in DB
                $verifiedTxnId = Deposits::where('txn_id', $txn_id)->first();

                if (!isset($verifiedTxnId)) {

                    // Insert Deposit
                    $this->deposit($data['id'], $txn_id, $data['amount'], 'PayPal', $data['taxes']);

                    //Add Funds to User
                    User::find($data['id'])->increment('wallet', $data['amount']);

                }// <--- Verified Txn ID

            } // <-- Payment status
        } else {
            //Some thing went wrong in the payment !
        }

    }// End Method mercadoPagoProcess

    public function coinPaymentsIPN(Request $request)
    {
        // Get Payment Gateway
        $payment = PaymentGateways::whereName('Coinpayments')->firstOrFail();

        $merchantId = $payment->key;
        $ipnSecret = $payment->key_secret;

        $currency = $this->settings->currency_code;

        // Find user
        $user = User::findOrFail($request->user);

        // Validations...
        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            exit;
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            exit;
        }

        $getRequest = file_get_contents('php://input');

        if ($getRequest === FALSE || empty($getRequest)) {
            exit;
        }

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($merchantId)) {
            exit;
        }

        $hmac = hash_hmac("sha512", $getRequest, trim($ipnSecret));
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
            exit;
        }

        // Variables
        $ipn_type = $_POST['ipn_type'];
        $txn_id = $_POST['txn_id'];
        $item_name = $_POST['item_name'];
        $currency1 = $_POST['currency1'];
        $currency2 = $_POST['currency2'];
        $status = intval($_POST['status']);

        // Check Button payment
        if ($ipn_type != 'button') {
            exit;
        }

        // Check currency
        if ($currency1 != $currency) {
            exit;
        }

        if ($status >= 100 || $status == 2) {
            try {

                // Insert Deposit
                $this->deposit($user->id, $txn_id, $request->amountOriginal, 'Coinpayments', $request->taxes);

                // Add Funds to User
                $user->increment('wallet', $request->amountOriginal);

            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        } // status >= 100

    }// End sendFlutterwave

    public function paymentProcess()
    {
        return redirect('my/wallet')->with(['payment_process' => true]);
    }// End flutterwaveCallback

    public function mercadoPagoProcess(Request $request)
    {
        try {

            // if payment not approved
            if ($request->status != 'approved') {
                throw new Exception('Payment failed');
            }

            if ($request->has('external_reference')) {
                $external = $request->external_reference;
                // parse_str($external, $data);
            } else {
                throw new Exception('An error has occurred missing External Reference');
            }

            // Validate Amount
            if ($request->amountOriginal < $this->settings->min_deposits_amount) {
                throw new Exception('An error has occurred amount not invalid');
            }

            // Insert Deposit
            $this->deposit(
                $request->userId,
                'mp_' . str_random(25),
                $request->amountOriginal,
                'Mercadopago',
                $request->userTaxes ?? null
            );

            // Add Funds to User
            User::find($request->userId)->increment('wallet', $request->amountOriginal);

            return redirect('my/wallet');

        } catch (Exception $e) {

            return redirect('my/wallet')->withErrorMessage($e->getMessage());
        }

    }// End sendMollie

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function flutterwaveCallback()
    {
        $status = request()->status;

        //if payment is successful
        if ($status == 'successful') {

            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            $verifyTxnId = Deposits::where('txn_id', $data['data']['tx_ref'])->first();

            if ($data['data']['status'] == "successful"
                && $data['data']['amount'] >= $data['data']['meta']['amountFinal']
                && $data['data']['currency'] == $this->settings->currency_code
                && !$verifyTxnId
            ) {
                // Insert Deposit
                $this->deposit(
                    $data['data']['meta']['user'],
                    $data['data']['tx_ref'],
                    $data['data']['meta']['amountFinal'],
                    'Flutterwave',
                    $data['data']['meta']['taxes'] ?? null
                );

                // Add Funds to User
                User::find($data['data']['meta']['user'])->increment('wallet', $data['data']['meta']['amountFinal']);
            }

        } // end payment is successful

        return redirect('my/wallet');

    }//<----- End Method webhook()

    public function webhookMollie()
    {
        $paymentGateway = PaymentGateways::whereName('Mollie')->firstOrFail();

        $mollie = new MollieApiClient();
        $mollie->setApiKey($paymentGateway->key);

        if (!$this->request->has('id')) {
            return;
        }

        $payment = $mollie->payments->get($this->request->id);

        if ($payment->isPaid()) {

            // Verify Transaction ID and insert in DB
            $verifiedTxnId = Deposits::where('txn_id', $payment->id)->first();

            if (!isset($verifiedTxnId)) {

                // Insert Deposit
                $this->deposit(
                    $payment->metadata->user_id,
                    $payment->id,
                    $payment->metadata->amount,
                    'Mollie',
                    $payment->metadata->taxes ?? null
                );

                //Add Funds to User
                User::find($payment->metadata->user_id)->increment('wallet', $payment->metadata->amount);

            }// Verify Transaction ID

        }// End isPaid()

    }//<----- End Method sendRazorpay()

    /**
     *
     */
    private function sendCinetPay()
    {
        $payment = PaymentGateways::whereName('Cinetpay')->whereEnabled(1)->firstOrFail();
        $fee = $payment->fee;
        $cents = $payment->fee_cents;

        $taxes = $this->settings->tax_on_wallet ? ($this->request->amount * auth()->user()->isTaxable()->sum('percentage') / 100) : 0;

        $amount = number_format($this->request->amount + ($this->request->amount * $fee / 100) + $cents + $taxes, 2, '.', '');
        $data = [];
        $data["customer_name"] = auth()->user()->name;
        $data["customer_surname"] = auth()->user()->username;
        $data["description"] = "Achat sdk";
        $data["amount"] = $this->request->amount;
        $data["type_operation"] = 3;
        $data["id_update"] = null;
        $data["id_product"] = null;
        $data["description_custom_content"] = null;
        $data["delivery_status"] = null;
        $data["id_subscribe"] = null;
        $data["currency"] = "XOF";
        $cinetPay = new CinetPayService();
        $result = $cinetPay->payment($data);

        if ($result["code"] == '201') {
            $url = $result["data"]["payment_url"];

            return response()->json([
                "success" => true,
                "payment" => "CinetPay",
                "data" => $result["data"]
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => $result,
            ]);
        }

    }


}
