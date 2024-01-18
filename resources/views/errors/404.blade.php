<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="UTF-8">
    <title>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('error.error_404'), config('app.locale')) }}</title>
    <link href="{{ asset('css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ url('img', $settings->favicon) }}"/>
</head>
<body>
<div class="wrap-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 error-page text-center parallax-fade-top" style="top: 0px; opacity: 1;">
                <h1>404</h1>
                <p class="mt-3 mb-5">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('error.error_404_subdescription'), config('app.locale')) }}</p>
                <a href="javascript:history.back();" class="error-link mt-5"><i
                        class="fa fa-long-arrow-alt-left mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.back'), config('app.locale')) }}
                </a><br>
                <a href="{{url('/')}}"
                   class="error-link mt-5">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('error.go_home'), config('app.locale')) }}</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
