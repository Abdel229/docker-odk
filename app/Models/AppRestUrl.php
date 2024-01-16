<?php

namespace App\Models;


class AppRestUrl
{

    const base_url = "http://localhost:8000";

    const url = AppRestUrl::base_url . "/";

    public static function Get(array $data = [], string $url)
    {
        set_time_limit(0);
    }


    /**
     * @param $curl
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public static function Post($curl, array $data = [])
    {
        set_time_limit(0);
        $link = AppRestUrl::url . $curl;
        $ch = curl_init($link);
        $curlConfig = [
            CURLOPT_URL            => $link,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: multipart/form-data'],
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_POSTFIELDS     => $data,
        ];

        //print_r($ch);exit;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);

        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            $message = "cURL error ({$errno}):\n {$error_message}";
            $tab["status"] = "005";
            $tab["message"] = $message;
            $response = json_encode($tab);
        }

        return $response;
    }
}
