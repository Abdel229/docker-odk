<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
          content="@yield('description_custom')@if(!Request::route()->named('seo') && !Request::route()->named('profile')){{\Stichoza\GoogleTranslate\GoogleTranslate::trans('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut tortor rutrum massa efficitur tincidunt vel nec lacus. Curabitur porta aliquet diam, eu gravida neque lacinia.', config('app.locale'))}}@endif">
    <meta name="keywords"
          content="@yield('keywords_custom'){{ \Stichoza\GoogleTranslate\GoogleTranslate::trans('donations,support,creators,OnlyFans,subscription,content', config('app.locale')) }}"/>
    <meta name="theme-color"
          content="{{ auth()->check() && auth()->user()->dark_mode == 'on' ? '#303030' : $settings->color_default }}">
    <title>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->check() && User::notificationsCount() ? '('.User::notificationsCount().') ' : '', config("app.locale")) }}@section('title')@show @if( isset( $settings->title ) ){{$settings->title}}@endif</title>
    <!-- Favicon -->
    <link href="{{ url('img', $settings->favicon) }}" rel="icon">

    @include('includes.css_general')

    @laravelPWA

    @yield('css')

    @if($settings->google_analytics != '')
        {!! $settings->google_analytics !!}
    @endif
</head>

<body>
@if ($settings->disable_banner_cookies == 'off')
    <div class="btn-block text-center showBanner padding-top-10 pb-3 display-none">
        <i class="fa fa-cookie-bite"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans('This site uses cookies, by continuing to use the service, you accept our use of cookies', config('app.locale'))}}
        @if ($settings->link_cookies != '')
            <a href="{{$settings->link_cookies}}" class="mr-2 text-white link-border"
               target="_blank">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans('Cookies Policy', config('app.locale')) }}</a>
        @endif
        <button class="btn btn-sm btn-primary"
                id="close-banner">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans('Got it!', config('app.locale'))}}
        </button>
    </div>
@endif

<div id="mobileMenuOverlay" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
     aria-expanded="false"></div>

@auth
    @if (! request()->is('messages/*') && ! request()->is('live/*'))
        @include('includes.menu-mobile')
    @endif
@endauth

@if ($settings->alert_adult == 'on')
    <div class="modal fade" tabindex="-1" id="alertAdult">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <p>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.alert_content_adult'), config("app.locale")) }}</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a href="https://google.com"
                       class="btn e-none p-0 mr-3">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.leave'), config("app.locale"))}}</a>
                    <button type="button" class="btn btn-primary"
                            id="btnAlertAdult">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.i_am_age'), config("app.locale"))}}</button>
                </div>
            </div>
        </div>
    </div>
@endif


<div class="popout popout-error font-default"></div>

@if (auth()->guest() && request()->path() == '/' && $settings->home_style == 0
    || auth()->guest() && request()->path() != '/' && $settings->home_style == 0
    || auth()->guest() && request()->path() != '/' && $settings->home_style == 1
    || auth()->check()
    )
    @include('includes.navbar')
@endif

<main @if (request()->is('messages/*') || request()->is('live/*')) class="h-100" @endif role="main">
    @yield('content')

    @if (auth()->guest() && ! request()->route()->named('profile')
          || auth()->check()
          && request()->path() != '/'
          && ! request()->is('my/bookmarks')
          && ! request()->is('my/purchases')
          && ! request()->is('explore')
          && ! request()->route()->named('profile')
          && ! request()->is('messages')
          && ! request()->is('messages/*')
          && ! request()->is('live/*')
          )

        @if (auth()->guest() && request()->path() == '/' && $settings->home_style == 0
              || auth()->guest() && request()->path() != '/' && $settings->home_style == 0
              || auth()->guest() && request()->path() != '/' && $settings->home_style == 1
              || auth()->check()
                )

            @if (auth()->guest() && $settings->who_can_see_content == 'users')
                <div class="text-center py-3 px-3">
                    @include('includes.footer-tiny')
                </div>
            @else
                @include('includes.footer')
            @endif

        @endif

    @endif

    @guest

        @if (request()->is('/')
            && $settings->home_style == 0
            || request()->is('creators')
            || request()->is('creators/*')
            || request()->is('category/*')
            || request()->is('p/*')
            || request()->is('blog')
            || request()->is('blog/post/*')
            || request()->is('shop')
            || request()->is('shop/product/*')
            || request()->route()->named('profile')
            )

            @include('includes.modal-login')

        @endif
    @endguest

    @auth

        @if ($settings->disable_tips == 'off')
            @include('includes.modal-tip')
        @endif

        @include('includes.modal-payperview')

        @if ($settings->live_streaming_status == 'on')
            @include('includes.modal-live-stream')
        @endif

    @endauth

    @guest
        @include('includes.modal-2fa')
    @endguest
</main>

@include('includes.javascript_general')

@yield('javascript')

@auth
    <div id="bodyContainer"></div>
@endauth
</body>
</html>
