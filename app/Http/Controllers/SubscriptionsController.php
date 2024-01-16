<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\AdminSettings;
use App\Models\PaymentGateways;
use App\Models\Plans;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\cinetpay\CinetPayService;


class SubscriptionsController extends Controller
{
    use Traits\Functions;

    public function __construct(Request $request, AdminSettings $settings)
    {
        $this->request = $request;
        $this->settings = $settings::first();
    }

    /**
     * Buy subscription
     *
     * @return Response
     */
    public function buy()
    {
        // Find the User
        $user = User::whereVerifiedId('yes')
            ->whereId($this->request->id)
            ->where('id', '<>', auth()->id())
            ->firstOrFail();

        // Check if Plan exists
        $plan = $user->plans()
            ->whereInterval($this->request->interval)
            ->firstOrFail();

        if (!$plan->status) {
            return response()->json([
                'success' => false,
                'errors' => ['error' => trans('general.subscription_not_available')],
            ]);
        }

        // Check if subscription exists
        $checkSubscription = auth()->user()->mySubscriptions()
            ->whereStripePrice($plan->name)
            ->where('ends_at', '>=', now())->first();

        if ($checkSubscription) {
            return response()->json([
                'success' => false,
                'errors' => ['error' => trans('general.subscription_exists')],
            ]);
        }

        //<---- Validation
        $validator = Validator::make($this->request->all(), [
            'payment_gateway' => 'required',
            'payment_gateway' => 'required',
            'agree_terms' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }

        // Wallet
        if ($this->request->payment_gateway == 'wallet') {
            return $this->sendWallet();
        }else if ($this->request->payment_gateway == '11') {
            return $this->sendCinetPay($plan);
        }

        // Get name of Payment Gateway
        $payment = PaymentGateways::findOrFail($this->request->payment_gateway);

        // Send data to the payment processor
        return redirect()->route(str_slug($payment->name), $this->request->except(['_token']));

    }// End Method Send

    /**
     *  Subscription via Wallet
     *
     * @return Response
     */
    protected function sendWallet()
    {
      // Find user
      $creator = User::whereId($this->request->id)
          ->whereVerifiedId('yes')
            ->firstOrFail();

      // Check if Plan exists
      $plan = $creator->plans()
        ->whereInterval($this->request->interval)
           ->firstOrFail();

      $amount = $plan->price;

      // Verify plan no is empty
      if (! $creator->plan) {
         $creator->plan = 'user_'.$creator->id;
         $creator->save();
      }

      if (auth()->user()->wallet < Helper::amountGross($amount)) {
        return response()->json([
          "success" => false,
          "errors" => ['error' => __('general.not_enough_funds')]
        ]);
      }

      // Insert DB
      $subscription              = new Subscriptions();
      $subscription->user_id     = auth()->id();
      $subscription->stripe_price = $plan->name;
      $subscription->ends_at     = $creator->planInterval($plan->interval);
      $subscription->rebill_wallet = 'on';
      $subscription->interval = $plan->interval;
      $subscription->taxes = auth()->user()->taxesPayable();
      $subscription->save();

      // Admin and user earnings calculation
      $earnings = $this->earningsAdminUser($creator->custom_fee, $amount, null, null);

      // Insert Transaction
      $this->transaction(
         'subw_'.str_random(25),
         auth()->id(),
         $subscription->id,
         $creator->id,
         $amount,
         $earnings['user'],
         $earnings['admin'],
         'Wallet',
         'subscription',
         $earnings['percentageApplied'],
         auth()->user()->taxesPayable()
       );

      // Subtract user funds
      auth()->user()->decrement('wallet', Helper::amountGross($amount));

      // Add Earnings to User
      $creator->increment('balance', $earnings['user']);

      // Send Email to User and Notification
      Subscriptions::sendEmailAndNotify(auth()->user()->name, $creator->id);

      return response()->json([
        'success' => true,
        'url' => url('buy/subscription/success', $creator->username)
      ]);

    } // End sendTipWallet


    /**
     *  Subscription via cinetpay
     *
     * @return Response
     */
    private function sendCinetPay(Plans $plan)
    {
        $data = [];
        $data["customer_name"] = auth()->user()->name;
        $data["customer_surname"] = auth()->user()->username;
        $data["description"] = "Achat sdk";
        $data["amount"] = $plan->price*100;
        $data["type_operation"] = 2;
        $data["id_update"] = null;
        $data["id_product"] = null;
        $data["description_custom_content"] = null;
        $data["delivery_status"] = null;
        $data["id_subscribe"] = $this->request->id;
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
    /**
     * Free subscription
     *
     */
    public function subscriptionFree()
    {
        //dd("subscription ok");
        // Find user
        $creator = User::whereId($this->request->id)
            ->whereFreeSubscription('yes')
            ->whereVerifiedId('yes')
            ->firstOrFail();

        // Verify plan no is empty
        if (!$creator->plan) {
            $creator->plan = 'user_' . $creator->id;
            $creator->save();
        }

        // Check if not plans
        if ($creator->plans()->count() == 0) {

            Plans::updateOrCreate(
                [
                    'user_id' => $creator->id,
                    'name' => 'user_' . $creator->id
                ],
                [
                    'interval' => 'monthly',
                    'status' => '1'
                ]);
        }

        // Verify subscription exists
        $subscription = Subscriptions::whereUserId(auth()->id())
            ->whereStripePrice($creator->plan)
            ->whereFree('yes')
            ->first();

        if ($subscription) {
            return response()->json([
                'success' => false,
                'error' => trans('general.subscription_exists'),
            ]);
        }

        // Insert DB
        $sql = new Subscriptions();
        $sql->user_id = auth()->id();
        $sql->stripe_price = $creator->plan;
        $sql->free = 'yes';
        $sql->save();

        // Send Email to User and Notification
        Subscriptions::sendEmailAndNotify(auth()->user()->name, $creator->id);

        return response()->json([
            'success' => true,
        ]);
    }// End Method cancelFreeSubscription

    public function cancelFreeSubscription($id)
    {
        //dd("cancel subscription ok");
        $checkSubscription = auth()->user()->userSubscriptions()->whereId($id)->firstOrFail();
        $creator = User::wherePlan($checkSubscription->stripe_price)->first();

        // Delete Subscription
        $checkSubscription->delete();

        session()->put('subscription_cancel', trans('general.subscription_cancel'));
        return redirect($creator->username);

    }// End Method cancelWalletSubscription

    public function cancelWalletSubscription($id)
    {
        $subscription = auth()->user()->userSubscriptions()->whereId($id)->firstOrFail();
        $creator = Plans::whereName($subscription->stripe_price)->first();

        // Delete Subscription
        $subscription->cancelled = 'yes';
        $subscription->save();

        session()->put('subscription_cancel', trans('general.subscription_cancel'));
        return redirect($creator->user()->username);

    } // End sendTipWallet

}
