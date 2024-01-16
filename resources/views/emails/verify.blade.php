<!DOCTYPE html>
<html lang="{{ config("app.locale") }}">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
    <title></title>
</head>


<body style="margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;" align="center">
            <table width="100%" cellpadding="0" cellspacing="0">
                <!-- Logo -->
                <tr>
                    <td style="padding: 25px 0; text-align: center;">
                        <a href="{{ url('/') }}" style="display: inline-block; text-decoration: none;">
                            <img src="{{ url('img', $settings->logo_2) }}"
                                 style="position: relative; border: none; height: auto; width: auto; max-width: 190px !important;"
                                 alt="">
                        </a>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td style="width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;"
                        width="100%">
                        <table style="width: auto; max-width: 570px; margin: 0 auto; padding: 0;" align="center"
                               width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding: 35px;">
                                    <!-- Greeting -->
                                    <h1 style="margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;">
                                        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('emails.verify_email_msg'), config("app.locale"))}} {{$settings->title}}
                                    </h1>

                                    <!-- Intro -->
                                    <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                        <a href="{{url('verify/account', $confirmation_code).$isProfile}}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('emails.click_here'), config("app.locale"))}}</a> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('emails.verify_email_msg_2'), config("app.locale"))}}
                                    </p>

                                    <!-- Salutation -->
                                    <p style="margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;">
                                        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('emails.regards'), config("app.locale"))}}
                                        <br>{{$settings->title}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td>
                        <table style="width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;"
                               align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #AEAEAE; padding: 35px; text-align: center;">
                                    <p style="margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;">
                                        &copy; <?php echo date('Y'); ?>
                                        {{$settings->title}}
                                        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('emails.rights_reserved'), config("app.locale"))}}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>