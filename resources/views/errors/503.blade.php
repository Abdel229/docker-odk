<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="UTF-8">
    <title>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.maintenance_mode'), config('app.locale'))}}</title>
    <link href="{{ asset('css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ url('img', $settings->favicon) }}"/>
</head>
<body>
<div class="wrap-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 error-page text-center parallax-fade-top" style="top: 0; opacity: 1;">
                <h1>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('error.sorry'), config('app.locale'))}}</h1>
                <p class="mt-3 mb-5">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.msg_maintenance_mode'), config('app.locale'))}}</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
