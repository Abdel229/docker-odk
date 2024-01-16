<?php

namespace App\Services\cinetpay;
/**
 * CinetPay
 *
 * LICENSE
 *
 * This source file is subject to the MIT License that is bundled
 * with this package in the file LICENSE.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@cinetpay.com so we can send you a copy immediately.
 * @category cinetpay
 * @package  cinetpay
 * @license  MIT
 * @version
 */

 /**
  * Cinetpay
  * @category cinetpay
  * @package  cinetpay
  * @copyright Copyright (c) 2015-2021 CinetPay Inc. (https://www.cinetpay.com)
  */
  use Exception;
  class CinetPayTransfert
  {
      protected $BASE_URL = null; //generer lien de paiement Pour la production

      //Variable obligatoire identifiant
    /**
     * An identifier
     * @var string
     */

     public $token = null ;
     public $apikey = null ;
     public $key_pass = null;

 /**
     * CinetPay constructor.
     * @param $site_id
     * @param $apikey
     * @param array $params
     */


     public function __construct($key_pass, $apikey, $params = null)
     {
       $this->BASE_URL = 'https://client.cinetpay.com/v1/auth/login';
       $this->apikey = $apikey;
       $this->key_pass = $key_pass;

       //$dataArray = 'apikey='.$this->apikey.'&password='.$this->key_pass;
       //$fields = array( 'penguins'=>$skipper, 'bestpony'=>'rainbowdash');
       
       $this->token = $this->Login($this->BASE_URL);
   
     }


     public function Login($url,$method = 'POST'){

        
        /*$postvars = '';
        foreach($params as $key=>$value) {
          $postvars .= $key . "=" . $value . "&";
        }*/
       /* $data = [
            'apikey' => ''.$this->apikey,
            'password' => ''.$this->key_pass, 
        ];*/
           $data = "apikey=".$this->apikey."&password=".$this->key_pass;
        if (function_exists('curl_version')) {
            try {
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type:application/x-www-form-urlencoded"
                    ),
                    
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 45,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   
                    
                    
                   
                ));
              
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    throw new Exception("Error :" . $err);
                } else {

                    if ( $response == false)
                    throw new Exception("Un probleme est survenu lors de la connexion  !");
                    
                    $responseData = json_decode($response,true);

                    if(is_array($responseData))
                    {
                    if(empty($responseData['data']))
                    {
                        $message = 'Une erreur est survenue, Code: ' . $responseData['code'] . ', Message: ' . $responseData['message'] . ', Description: ' . $responseData['description'];

                        throw new Exception($message);
                    }


                    }
                   // $this->token = $result["data"]["token"];
                    return $responseData["data"]["token"];
                            }
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }  else {
            throw new Exception("Vous devez activer curl ou allow_url_fopen pour utiliser CinetPay");
        }
     }


     public function AddContact($data,$method = "POST"){

        $this->BASE_URL = 'https://client.cinetpay.com/v1/transfer/contact?token='.$this->token.'&lang=fr';
        $datas = 'data='.$data;

        if (function_exists('curl_version')) {
            try {
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  $this->BASE_URL ,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 45,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => $datas,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => array(
                        "content-type:application/x-www-form-urlencoded",
                        
                    ),
                ));
               // dd($datas);
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    throw new Exception("Error :" . $err);
                } else {

                    if ( $response == false)
                    
                    throw new Exception("Un probleme est survenu lors de la connexion  !");
                    
                    $responseData = json_decode($response,true);

                    if(is_array($responseData))
                    {
                    if(empty($responseData['data']))
                    {
                       // dd($responseData);
                       // $message = 'Une erreur est survenue, Code: ' . $responseData['code'] . ', Message: ' . $responseData['message'] ;

                        //throw new Exception($message);
                        return $responseData["code"];
                    }


                    }
                    //dd($responseData);
                   // $this->token = $result["data"]["token"];
                    return $responseData["code"];
                            }
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }  else {
            throw new Exception("Vous devez activer curl ou allow_url_fopen pour utiliser CinetPay");
        }




     }


     public function Transfert($params,$method = "POST"){
        $this->BASE_URL = 'https://client.cinetpay.com/v1/transfer/money/send/contact?token='.$this->token.'&lang=fr';
        $datas = 'data='.$params;
        if (function_exists('curl_version')) {
            try {
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $this->BASE_URL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 45,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => $datas,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => array(
                        "content-type:application/x-www-form-urlencoded"
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    throw new Exception("Error :" . $err);
                } else {

                    if ( $response == false)
                    throw new Exception("Un probleme est survenu lors de la connexion  !");
                    
                    $responseData = json_decode($response,true);

                    if(is_array($responseData))
                    {
                    if(empty($responseData['data']))
                    {
                      //  $message = 'Une erreur est survenue, Code: ' . $responseData['code'] . ', Message: ' . $responseData['message'] . ', Description: ' . $responseData['description'];

                      //  throw new Exception($message);

                        return $responseData["code"];
                    }


                    }
                   // $this->token = $result["data"]["token"];
                    return $responseData["code"];
                            }
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }  else {
            throw new Exception("Vous devez activer curl ou allow_url_fopen pour utiliser CinetPay");
        }


     }


  }