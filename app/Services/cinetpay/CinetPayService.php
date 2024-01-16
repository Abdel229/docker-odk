<?php

namespace App\Services\cinetpay;

use App\Models\CinepayPayment;
use Illuminate\Support\Facades\Auth;

class CinetPayService
{

    /**
     * @param array $request
     * @return array|mixed|void
     */
    public function payment(array $request)
    {
        $commande = new Commande();

        try {
            $customer_name = $request['customer_name'];
            $customer_surname = $request['customer_surname'];
            $description = $request['description'];
//            $amount = 150;
            $id_product = $request['id_product'];
            $amount = $request['amount'];
            $currency = $request['currency'];
            $id_update = $request['id_update'];
            $type_operation = $request['type_operation'];
            $id_subscribe = $request['id_subscribe'];
            $description_custom_content = $request['description_custom_content'];
            $delivery_status = $request['delivery_status'];

            //transaction id
            $id_transaction = date("YmdHis"); // or $id_transaction = Cinetpay::generateTransId()
//            $id_transaction = "df56d5gf9e8f"; // or $id_transaction = Cinetpay::generateTransId()

            //Veuillez entrer votre apiKey
            $apikey = config("cinetpay.api_key");
            //Veuillez entrer votre siteId
            $site_id = config("cinetpay.site_id");

            //notify url
            $notify_url = $commande->getCurrentUrl() . config("cinetpay.urls.notify");
            //return url
            $return_url = $commande->getCurrentUrl() . config("cinetpay.urls.return");
            $channels = "ALL";

            /*information supplémentaire que vous voulez afficher
    sur la facture de CinetPay(Supporte trois variables
    que vous nommez à votre convenance)*/
            $invoice_data = array(
                "Data 1" => "",
                "Data 2" => "",
                "Data 3" => ""
            );

            //
            $formData = [
                "transaction_id" => $id_transaction,
               "amount" => $amount,
                // "amount" => 150,
                "currency" => $currency,
                "customer_surname" => $customer_name,
                "customer_name" => $customer_surname,
                "description" => $description,
                "notify_url" => $notify_url,
                "return_url" => $return_url,
                "channels" => $channels,
                "invoice_data" => $invoice_data,
                //pour afficher le paiement par carte de credit
                "customer_id" => Auth::user()->id, //id du client
                "customer_email" => "", //l'email du client
                "customer_phone_number" => "", //Le numéro de téléphone du client
                "customer_address" => "", //l'adresse du client
                "customer_city" => "", // ville du client
                "customer_country" => "",//Le pays du client, la valeur à envoyer est le code ISO du pays (code à deux chiffre) ex : CI, BF, US, CA, FR
                "customer_state" => "", //L’état dans de la quel se trouve le client. Cette valeur est obligatoire si le client se trouve au États Unis d’Amérique (US) ou au Canada (CA)
                "customer_zip_code" => "" //Le code postal du client
            ];
            // enregistrer la transaction dans votre base de donnée
            /*  $commande->create(); */

            CinepayPayment::create([
                "transaction_id"=>$id_transaction,
                "origin_url"=>url()->previous(),
                "amount"=>$amount,
                "id_update"=>$id_update,
                "type_operation"=>$type_operation,
                "id_product"=>$id_product,
                "id_subscribe"=>$id_subscribe,
                "description_custom_content"=>$description_custom_content,
                "delivery_status"=>$delivery_status,
                "user_id"=>Auth::user()->id
            ]);
            $cinetPay = new CinetPay($site_id, $apikey);
            return $cinetPay->generatePaymentLink($formData);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}
