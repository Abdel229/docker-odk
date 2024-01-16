<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'L\':attribute doit être accepté.',
    'active_url' => 'L\' :attribute n\'est pas une URL valide.',
    'after' => 'Le :attribute doit être une date postérieure à :date.',
    'after_or_equal' => 'Le :attribute doit être une date postérieure ou égale à :date.',
    'alpha' => 'Le :attribut ne peut contenir que des lettres.',
    'alpha_dash' => 'Le :attribute ne peut contenir que des lettres, des chiffres et des tirets.',
    "ascii_only" => "L' :attribute ne peut contenir que des lettres, des chiffres et des tirets.",
    'alpha_num' => 'Le :attribute ne peut contenir que des lettres et des chiffres.',
    'array' => 'Le :attribute doit être un tableau.',
    'before' => 'Le :attribute doit être une date avant :date.',
    'before_or_equal' => 'Le :attribute doit être une date antérieure ou égale à :date.',

    'between' => [
      'numeric' => 'Le :attribute doit être compris entre :min et :max.',
      'file' => 'Le :attribute doit être compris entre :min et :max kilo-octets.',
      'string' => 'Le :attribute doit être compris entre :min et :max caractères.',
      'array' => 'Le :attribute doit avoir entre :min et :max éléments.',
  ],
  'boolean' => 'Le champ :attribute doit être vrai ou faux.',
  'confirmed' => 'La confirmation :attribute ne correspond pas.',
  'date' => 'Le :attribute n\'est pas une date valide.',
  'date_format' => 'Le :attribute ne correspond pas au format :format.',
  'different' => 'Le :attribute et :other doivent être différents.',
  'digits' => 'Le :attribute doit être :digits chiffres.',
  'digits_between' => 'Le :attribute doit être compris entre :min et :max chiffres.',
  'dimensions' => 'L\' :attribute a des dimensions d\'image invalides (:min_width x :min_height px).',
  'distinct' => 'Le champ :attribute a une valeur en double.',
  'email' => 'Le :attribute doit être une adresse e-mail valide.',
  'exists' => 'L\'attribute sélectionné n\'est pas valide.',
  'file' => 'Le :attribute doit être un fichier.',
  'filled' => 'Le champ :attribute doit avoir une valeur.',

  'gt' => [
      'numeric' => 'Le :attribute doit être supérieur à :value.',
      'file' => 'Le :attribute doit être supérieur à :value kilo-octets.',
      'string' => 'Le :attribut doit être supérieur à :value caractères.',
      'array' => 'Le :attribute doit avoir plus de :value éléments.',
  ],

    'gte' => [
      'numeric' => 'Le :attribute doit être supérieur ou égal à :value.',
      'file' => 'Le :attribute doit être supérieur ou égal à :value kilo-octets.',
      'string' => 'Le :attribute doit être supérieur ou égal à :value caractères.',
      'array' => 'Le :attribute doit avoir des éléments :value ou plus.',
  ],
  'image' => 'Le :attribute doit être une image.',
  'in' => 'L\'attribute sélectionné n\'est pas valide.',
  'in_array' => 'Le champ :attribute n\'existe pas dans :other.',
  'integer' => 'Le :attribute doit être un entier.',
  'ip' => 'Le :attribute doit être une adresse IP valide.',
  'ipv4' => 'Le :attribute doit être une adresse IPv4 valide.',
  'ipv6' => 'Le :attribute doit être une adresse IPv6 valide.',
  'json' => 'Le :attribute doit être une chaîne JSON valide.',
  'lt' => [
      'numeric' => 'Le :attribute doit être inférieur à :value.',
      'file' => 'Le :attribute doit être inférieur à :value kilo-octets.',
      'string' => 'Le :attribute doit être inférieur à :value caractères.',
      'array' => 'Le :attribute doit avoir moins de :value éléments.',
  ],
  'lte' => [
      'numeric' => 'Le :attribute doit être inférieur ou égal à :value.',
      'file' => 'Le :attribute doit être inférieur ou égal à :value kilo-octets.',
      'string' => 'Le :attribute doit être inférieur ou égal à :valeur caractères.',
      'array' => 'Le :attribute ne doit pas avoir plus de :value éléments.',
  ],
  'max' => [
      'numeric' => 'Le :attribute ne peut pas être supérieur à :max.',
      'file' => 'Le :attribute ne doit pas être supérieur à :max kilo-octets.',
      'string' => 'Le :attribute ne doit pas être supérieur à :max caractères.',
      'array' => 'Le :attribute ne peut pas avoir plus de :max éléments.',
  ],

    'mimes' => 'Le :attribute doit être un fichier de type : :values.',
    'mimetypes' => 'Le :attribute doit être un fichier de type : :values.',
    'min' => [
        'numeric' => 'Le :attribute doit être au moins égal à :min.',
        'file' => 'Le :attribute doit faire au moins :min kilo-octets.',
        'string' => 'Le :attribute doit contenir au moins :min caractères.',
        'array' => 'Le :attribute doit avoir au moins :min éléments.',
    ],


    'not_in' => 'L\'attribute sélectionné n\'est pas valide.',
    'not_regex' => 'Le format :attribute est invalide.',
    'numeric' => 'Le :attribute doit être un nombre.',
    'present' => 'Le champ :attribute doit être présent.',
    'regex' => 'Le format :attribute n\'est pas valide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'Le champ :attribute est obligatoire lorsque :other vaut :value.',
    'required_unless' => 'Le champ :attribute est obligatoire sauf si :other est dans :values.',
    'required_with' => 'Le champ :attribute est obligatoire lorsque :values ​​est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire lorsque :values ​​est présent.',
    'required_without' => 'Le champ :attribute est requis lorsque :values ​​n\'est pas présent.',
    'required_without_all' => 'Le champ :attribute est requis lorsqu\'aucune des :values ​​n\'est présente.',
    'same' => 'Le :attribute et :other doivent correspondre.',
    'size' => [
        'numeric' => 'Le :attribute doit être :size.',
        'file' => 'Le :attribute doit être :size kilo-octets.',
        'string' => 'Le :attribute doit être composé de :size caractères.',
        'array' => 'Le :attribute doit contenir des éléments :size.',
    ],
    'string' => 'Le :attribute doit être une chaîne.',
    'timezone' => 'Le :attribute doit être un fuseau valide.',
    'unique' => 'L\':attribute a déjà été pris.',
    'uploaded' => 'Le :attribute n\'a pas pu être téléchargé.',
    'url' => 'Le format :attribute n\'est pas valide.',
    "account_not_confirmed" => "Votre compte n'est pas confirmé, veuillez vérifier votre email",
    "user_suspended" => "Votre compte a été suspendu, merci de nous contacter en cas d'erreur",
    "letters" => "Le :attribute doit contenir au moins une lettre ou un chiffre",
    'video_url' => 'L\'URL invalide ne supporte que Youtube et Vimeo.',
    'update_max_length' => 'Le message ne doit pas dépasser :max caractères.',
    'update_min_length' => 'Le message doit contenir au moins :min caractères.',
    
    'video_url_required' => 'Le champ URL de la vidéo est obligatoire lorsque le contenu en vedette est vidéo.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
      'agree_gdpr' => 'Case à cocher J\'accepte le traitement des données personnelles',
      'agree_terms' => 'Case à cocher J\'accepte les conditions générales d\'utilisation',
      'agree_terms_privacy' => 'Case à cocher J\'accepte les conditions générales d\'utilisation et la politique de confidentialité',
      'full_name' => 'Nom complet',
      'name' => 'Nom',
      'username' => 'Nom d\'utilisateur',
      'username_email' => 'Nom d\'utilisateur ou e-mail',
      'email' => 'E-mail',
      'password' => 'Mot de passe',
      'password_confirmation' => 'Confirmation du mot de passe',
      'website' => 'Site web',
      'location' => 'Emplacement',
      'countries_id' => 'Pays',
      'twitter' => 'Twitter',
      'facebook' => 'Facebook',
      'google' => 'Google',
      'instagram' => 'Instagram',
      'comment' => 'Commentaire',
      'title' => 'Titre',
      'description' => 'Description',
      'old_password' => 'Ancien mot de passe',
      'new_password' => 'Nouveau mot de passe',
      'email_paypal' => 'E-mail PayPal',
      'email_paypal_confirmation' => 'Confirmation de l\'e-mail PayPal',
      'bank_details' => 'Coordonnées bancaires',
      'video_url' => 'URL de la vidéo',
      'categories_id' => 'Catégorie',
      'story' => 'Histoire',
      'image' => 'Image',
      'avatar' => 'Avatar',
      'message' => 'Message',
      'profession' => 'Profession',
      'thumbnail' => 'Miniature',
      'address' => 'Adresse',
      'city' => 'Ville',
      'zip' => 'Code postal',
      'payment_gateway' => 'Passerelle de paiement',
      'payment_gateway_tip' => 'Passerelle de paiement',
      'MAIL_FROM_ADDRESS' => 'E-mail de l\'expéditeur',
      'FILESYSTEM_DRIVER' => 'Disque',
      'price' => 'Prix',
      'amount' => 'Montant',
      'birthdate' => 'Date de naissance',
      'navbar_background_color' => 'Couleur de fond de la barre de navigation',
      'navbar_text_color' => 'Couleur du texte de la barre de navigation',
      'footer_background_color' => 'Couleur de fond du pied de page',
      'footer_text_color' => 'Couleur du texte du pied de page',

      'AWS_ACCESS_KEY_ID' => 'Amazon Key', // Not necessary edit
      'AWS_SECRET_ACCESS_KEY' => 'Amazon Secret', // Not necessary edit
      'AWS_DEFAULT_REGION' => 'Amazon Region', // Not necessary edit
      'AWS_BUCKET' => 'Amazon Bucket', // Not necessary edit

      'DOS_ACCESS_KEY_ID' => 'DigitalOcean Key', // Not necessary edit
      'DOS_SECRET_ACCESS_KEY' => 'DigitalOcean Secret', // Not necessary edit
      'DOS_DEFAULT_REGION' => 'DigitalOcean Region', // Not necessary edit
      'DOS_BUCKET' => 'DigitalOcean Bucket', // Not necessary edit

      'WAS_ACCESS_KEY_ID' => 'Wasabi Key', // Not necessary edit
      'WAS_SECRET_ACCESS_KEY' => 'Wasabi Secret', // Not necessary edit
      'WAS_DEFAULT_REGION' => 'Wasabi Region', // Not necessary edit
      'WAS_BUCKET' => 'Wasabi Bucket', // Not necessary edit

      //===== v2.0
      'BACKBLAZE_ACCOUNT_ID' => 'Backblaze Account ID', // Not necessary edit
      'BACKBLAZE_APP_KEY' => 'Backblaze Master Application Key', // Not necessary edit
      'BACKBLAZE_BUCKET' => 'Backblaze Bucket Name', // Not necessary edit
      'BACKBLAZE_BUCKET_REGION' => 'Backblaze Bucket Region', // Not necessary edit
      'BACKBLAZE_BUCKET_ID' => 'Backblaze Bucket Endpoint', // Not necessary edit

      'VULTR_ACCESS_KEY' => 'Vultr Key', // Not necessary edit
      'VULTR_SECRET_KEY' => 'Vultr Secret', // Not necessary edit
      'VULTR_REGION' => 'Vultr Region', // Not necessary edit
      'VULTR_BUCKET' => 'Vultr Bucket', // Not necessary edit
  	],

];
