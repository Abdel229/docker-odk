<?php

namespace App\Http\Controllers;

use App\Services\cinetpay\CinetPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CinepayPayment;
use App\Models\User;
use App\Helper;
use App\Notifications\NewSale;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\Messages;
use App\Models\Updates;
use App\Models\Notifications;
use App\Models\PayPerViews;
use App\Models\Subscriptions;


class CinetPayPaymentController extends Controller
{
    use Traits\Functions;
    public function cancel(Request $request)
    {
        // redirect the user where you want
        return redirect('/'); // or redirect()->home();
    }

    public function return(Request $request)
    {

        $id_transaction = $request["transaction_id"];
        $site_id = config("cinetpay.site_id");
        $apiKey = config("cinetpay.api_key");

        try {
            // Verification d'etat de transaction chez CinetPay
            $cinetpay = new CinetPay($site_id, $apiKey);

            $cinetpay->getPayStatus($id_transaction, $site_id);
            $message = $cinetpay->chk_message;
            $code = $cinetpay->chk_code;

            //recuperer les info du clients pour personnaliser les reponses.
            /* $commande->getUserByPayment(); */

            // redirection vers une page en fonction de l'état de la transaction
            $cinet = DB::table('cinepay_payments')
            ->select()
            ->where(['transaction_id'=>$id_transaction])
            ->limit(1)
            ->get();

            if ($code == '00') {
                $user = User::where(['id'=>$cinet[0]->user_id])->first();;
                // $cinet = CinepayPayment::find(['transaction_id'=>$id_transaction]);
                // $user = User::find($cinet->user_id);
                $affected = DB::table('users')
                    ->join('cinepay_payments', 'users.id', '=', 'cinepay_payments.user_id')
                    ->where('transaction_id', $id_transaction)
                    ->update(['wallet' => ($cinetpay->chk_amount+$user->wallet)]);
                // Another way to debug/test is to view all cookies
                // $request->session()->flash('success', 'Task was successful!');
                switch ($cinet[0]->type_operation) {
                    case 1:
                        $data = [
                            "id"=>$cinet[0]->id_update,
                            "amount"=>($cinet[0]->amount),
                            "isMessage"=>false
                        ];
                        $result = $this->sendWallet($data,$user);
                        break;
                    case 2:
                        $result = $this->subscription($user,$cinet[0]);
                        break;
                    case 3:
                        $cinets = CinepayPayment::find(['transaction_id'=>$id_transaction]);
                        $cinets->delivery_status = $cinetpay->chk_message;
                        $cinets->description_custom_content = "Dépôt sur wallet  via cinetpay un montant de "+$cinetpay->chk_amount;

                        
                        break;
                    case 4:
                        $result = $this->payShop($user,$cinet[0]);
                        break;
                        
                    case 5:
                        $result = $this->sendtip($user,$cinet[0]);
                        break;
                    default:
                        # code...
                        break;
                }
                echo 'Felicitation, votre paiement a été effectué avec succès';
                //die();
            } else {
                // header('Location: '.$commande->getCurrentUrl().'/');
                echo 'Echec, votre paiement a échoué ';
                //die();
            }
        } catch (\Exception $e) {
            echo "Erreur :" . $e->getMessage();
        }
        // $userId = Auth::user()->id;

        //echo $affected;
        // print_r($cinetpay);
        // redirect the user where you want
        return redirect($cinet[0]->origin_url); // or redirect()->home();
        //return redirect(''.url()->previous().''); // or redirect()->home();
        // return [ $result,$id_transaction];

    }

    public function notify(Request $request)
    {
        try {
            //Création d'un fichier log pour s'assurer que les éléments sont bien exécuté
            $log = "User: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "TransId:" . $_POST['cpm_trans_id'] . PHP_EOL .
                "SiteId: " . $_POST['cpm_site_id'] . PHP_EOL .
                "-------------------------" . PHP_EOL;
            //Save string to log, use FILE_APPEND to append.
            file_put_contents('./log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);

            //La classe commande correspond à votre colonne qui gère les transactions dans votre base de données
            $commande = new Commande();
            // Initialisation de CinetPay et Identification du paiement
            $id_transaction = $request["transaction_id"];
            // apiKey
            $apikey = config("cinetpay.api_key");


            // siteId
            $site_id = config("cinetpay.site_id");


            $cinetpay = new CinetPay($site_id, $apikey);
            //On recupère le statut de la transaction dans la base de donnée
            /* $commande->set_transactionId($id_transaction);
                 //Il faut s'assurer que la transaction existe dans notre base de donnée
             * $commande->getCommandeByTransId();
             */

            // On verifie que la commande n'a pas encore été traité
            $VerifyStatusCmd = "1"; // valeur du statut à recupérer dans votre base de donnée
            if ($VerifyStatusCmd == '00') {
                // La commande a été déjà traité
                // Arret du script
                die();
            }

            // Dans le cas contrait, on verifie l'état de la transaction en cas de tentative de paiement sur CinetPay

            $cinetpay->getPayStatus($id_transaction, $site_id);


            $amount = $cinetpay->chk_amount;
            $currency = $cinetpay->chk_currency;
            $message = $cinetpay->chk_message;
            $code = $cinetpay->chk_code;
            $metadata = $cinetpay->chk_metadata;

            //Something to write to txt log
            $log = "User: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Code:" . $code . PHP_EOL .
                "Message: " . $message . PHP_EOL .
                "Amount: " . $amount . PHP_EOL .
                "currency: " . $currency . PHP_EOL .
                "-------------------------" . PHP_EOL;
            //Save string to log, use FILE_APPEND to append.
            file_put_contents('./log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);

            // On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
            if ($code == '00') {
                // correct, on delivre le service
                echo 'Felicitation, votre paiement a été effectué avec succès';
            } else {
                // transaction n'est pas valide
                echo 'Echec, votre paiement a échoué pour cause : ' . $message;
            }
            die();
            // mise à jour des transactions dans la base de donnée
            /*  $commande->update(); */
        } catch (\Exception $e) {
            echo "Erreur :" . $e->getMessage();
        }
        // redirect the user where you want
//        return redirect('/'); // or redirect()->home();
    }

    /**
     *  Send  Wallet
     *
     * @return JsonResponse|\Illuminate\Http\JsonResponse
     */
    private function sendWallet($data = [],User $user)
    {

        $media = Updates::whereId($data['id'])
        ->wherePrice($data['amount'])
        ->where('user_id', '<>', $user->id)
        ->firstOrFail();

        // Verify that the user has not purchased the content
        if (PayPerViews::whereUserId($user->id)->whereUpdatesId($data['id'])->first()) {
            return response()->json([
                "success" => false,
                "errors" => ['error' => __('general.already_purchased_content')]
            ]);
        }
        $amount = $data['amount'];

        if ($user->wallet < Helper::amountGross($amount,$user)) {
            return response()->json([
                "success" => false,
                "errors" => ['error' => __('general.not_enough_funds')]
            ]);
        }

        // Check if it is a Message or Post
        $media = $data['isMessage'] ? Messages::find($data['id']) : Updates::find($data['id']);

        // Admin and user earnings calculation
        $earnings = $this->earningsAdminUser($media->user()->custom_fee, $amount, null, null);

        // Insert Transaction
        $this->transaction(
            'ppv_' . str_random(25),
            $user->id,
            0,
            $media->user()->id,
            $amount,
            $earnings['user'],
            $earnings['admin'],
            'Wallet', 'ppv',
            $earnings['percentageApplied'],
            $user->taxesPayable()
        );

        $this->deposit(
            $user->id,
            'pay_' . str_random(25),
            $amount,
            'Cinetpay',
            $this->settings->tax_on_wallet ? auth()->user()->taxesPayable() : null,
        );


        // Add Earnings to User
        $media->user()->increment('balance', $earnings['user']);

        // Subtract user funds
        $user->decrement('wallet', Helper::amountGross($amount,$user));

        // Check if is sent by message
        // $user_id, $updates_id, $messages_id
        $this->payPerViews($user->id, $data['id'], 0);
        $url = url($media->user()->username, 'post') . '/' . $data['id'];

        // Send Email Creator
        if ($media->user()->email_new_ppv == 'yes') {
            $this->notifyEmailNewPPV($media->user(), $user->username, $media->description, 'post');
        }

        // Send Notification - destination, author, type, target
        Notifications::send($media->user()->id, $user->id, '7', $data['id']);

        return response()->json([
            "success" => true,
            "url" => $url,
            "data" => $data ?? false,
            "msgId" => $msgId ?? false,
            "wallet" => Helper::userWallet(null,$user)
        ]);

    }

    private function subscription(User $user, $cinet)
    {
        try {
            $creator = User::whereId($cinet->id_subscribe)
                ->whereVerifiedId('yes')
                ->firstOrFail();

            // Check if Plan exists
            $plan = $creator->plans()
                ->whereInterval($cinet->plan_interval)
                ->firstOrFail();

            $amount = $plan->price;

            // Verify plan no is empty
            if (!$creator->plan) {
                $creator->plan = 'user_' . $creator->id;
                $creator->save();
            }

            if ($user->wallet < Helper::amountGross($amount,$user)) {
                return response()->json([
                    "success" => false,
                    "errors" => ['error' => __('general.not_enough_funds')]
                ]);
            }

            // Insert DB
            $subscription = new Subscriptions();
            $subscription->user_id = $user->id;
            $subscription->stripe_price = $plan->name;
            $subscription->ends_at = $creator->planInterval($plan->interval);
            $subscription->rebill_wallet = 'on';
            $subscription->interval = $plan->interval;
            $subscription->taxes = $user->taxesPayable();
            $subscription->save();

            // Admin and user earnings calculation
            $earnings = $this->earningsAdminUser($creator->custom_fee, $amount, null, null);

            // Insert Transaction
            $this->transaction(
                'subw_' . str_random(25),
                $user->id,
                $subscription->id,
                $creator->id,
                $amount,
                $earnings['user'],
                $earnings['admin'],
                'Wallet',
                'subscription',
                $earnings['percentageApplied'],
                $user->taxesPayable()
            );

            // Subtract user funds
            $user->decrement('wallet', Helper::amountGross($amount,$user));

            // Add Earnings to User
            $creator->increment('balance', $earnings['user']);

            // Send Email to User and Notification
            Subscriptions::sendEmailAndNotify($user->name, $creator->id);

        } catch (\Throwable $th) {
            //throw $th;
            print_r($th->getMessage());
        }
    }

    private function payShop(User $user, $cinet){
        $item = Products::findOrFail($cinet->id_product);

        // Verify that the user has not buy
        if (Purchases::whereUserId($user->id)
            ->whereProductsId($cinet->	id_product)
            ->first()
        && $item->type == 'digital')
        {
          return response()->json([
            "success" => true,
            'url' => url('product/download', $item->id)
          ]);
        }

                // Admin and user earnings calculation
        $earnings = $this->earningsAdminUser($item->user()->custom_fee, $item->price, null, null);

        //== Insert Transaction
        $txn = $this->transaction(
          'purchase_'.str_random(25),
          $user->id,
          false,
          $item->user()->id,
          $item->price,
          $earnings['user'],
          $earnings['admin'],
          'Wallet',
          'purchase',
          $earnings['percentageApplied'],
          $user->taxesPayable()
        );

        // Subtract user funds
       $user->decrement('wallet', Helper::amountGross($item->price,$user));

        // Add Earnings to User
        $item->user()->increment('balance', $earnings['user']);

        // Insert Purchase
        $purchase = new Purchases();
        $purchase->transactions_id = $txn->id;
        $purchase->user_id = $user->id;
        $purchase->products_id = $item->id;
        $purchase->delivery_status = $cinet->delivery_status;
        $purchase->description_custom_content = $cinet->description_custom_content;
        $purchase->save();

        // Send Notification to Creator
        Notifications::send($item->user()->id, $user->id, 15, $item->id);

        // Send Email to Creator
        try {
  				$item->user()->notify(new NewSale($purchase));
  			} catch (\Exception $e) {
  				\Log::info('Error send email to creator on sale - '.$e->getMessage());
  			}

    }
    
    private function sendtip(User $payeur, $cinet){
        
     $user = User::find($cinet->id_subscribe);
     $amount = $cinet->amount;
   

     // Admin and user earnings calculation
     $earnings = $this->earningsAdminUser($user->custom_fee, $amount, null, null);

     // Insert Transaction
     $this->transaction(
        'w_'.str_random(25),
        $payeur->id,
        0,
        $user->id,
        $amount,
        $earnings['user'],
        $earnings['admin'],
        'Cinetpay',
        'tip',
        $earnings['percentageApplied'],
        $payeur->taxesPayable()
      );

     // Subtract user funds
    $payeur->decrement('wallet', Helper::amountGross($amount));

     // Add Earnings to User
     $user->increment('balance', $earnings['user']);

    

     // Send Notification
    
       Notifications::send($user->id, $payeur->id, '5', $payeur->id);
     



    
    } 
}
