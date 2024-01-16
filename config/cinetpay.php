<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cette valeur est disponible dans votre tableau de bord cinetpay
    |--------------------------------------------------------------------------
    */
    'api_key' => env('CINETPAY_API_KEY'),
    /*
    |--------------------------------------------------------------------------
    | Cette valeur est disponible dans votre tableau de bord cinetpay
    |--------------------------------------------------------------------------
    */
    'site_id' => env('CINETPAY_SITE_ID'),

    'key_pass' => env('CINETPAY_KEY_PASS'),

    'urls' => [
        /*
        |--------------------------------------------------------------------------
        | L'url qui sera appelé lorsque l'utilisateur effectue un paiement
        | Cet url eutilisé pour effectuer vos traitements en back office
        |--------------------------------------------------------------------------
        */
        'notify' => env('CINETPAY_NOTIFY_URL'),
        /*
        |--------------------------------------------------------------------------
        | L'url qui sera appelé lorsque l'utilisateur effectue un paiement
        |--------------------------------------------------------------------------
        */
        'return' => env('CINETPAY_RETURN_URL'),
        /*
        |--------------------------------------------------------------------------
        | L'url qui sera appelé lorsque l'utilisateur clique sur le bouton annuler le paiment
        | Vous pouvez utiliser ce bouton pour afficher d'autres moyens de paiement ou récupérer le motif de l'annulation
        |--------------------------------------------------------------------------
        */
        'cancel' => env('CINETPAY_CANCEL_URL'),
    ]

];
