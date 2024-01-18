@extends('layouts.app')

@section('title'){{ $user->hide_name == 'yes' ? $user->username : $user->name }} -@endsection
@section('description_custom'){{$user->username}} - {{strip_tags($user->story)}}@endsection

@section('css')

    <meta property="og:type" content="website"/>
    <meta property="og:image:width" content="200"/>
    <meta property="og:image:height" content="200"/>

    <!-- Current locale and alternate locales -->
    <meta property="og:locale" content="en_US"/>
    <meta property="og:locale:alternate" content="es_ES"/>

    <!-- Og Meta Tags -->
    <link rel="canonical" href="{{url($user->username)}}"/>
    <meta property="og:site_name"
          content="{{ $user->hide_name == 'yes' ? $user->username : $user->name }} - {{$settings->title}}"/>
    <meta property="og:url" content="{{url($user->username)}}"/>
    <meta property="og:image" content="{{Helper::getFile(config('path.avatar').$user->avatar)}}"/>

    <meta property="og:title"
          content="{{ $user->hide_name == 'yes' ? $user->username : $user->name }} - {{$settings->title}}"/>
    <meta property="og:description"
          content="{{ str_limit($updates[0]->description, 20) }} {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.by'), config("app.locale")) }} {{ $user->hide_name == 'yes' ? '@'.$user->username : $user->name }}"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:image" content="{{Helper::getFile(config('path.avatar').$user->avatar)}}"/>
    <meta name="twitter:title" content="{{ $user->hide_name == 'yes' ? $user->username : $user->name }}"/>
    <meta name="twitter:description"
          content="{{ str_limit($updates[0]->description, 20) }} {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.by'), config("app.locale")) }} {{ $user->hide_name == 'yes' ? '@'.$user->username : $user->name }}"/>
@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mb-lg-0 py-5 wrap-post">
                    @foreach ($updates as $response)
                        @include('includes.updates')
                    @endforeach

                    @if($user->updates()->count() == 0)
                        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_results_found'), config("app.locale"))}}
                    @endif
                </div><!-- end col-md-9 -->

                <div class="col-md-4 pb-4 py-lg-5">

                    @if ($users->total() != 0)
                        @include('includes.explore_creators')
                    @endif

                    @include('includes.footer-tiny')

                </div>

            </div>
        </div>
    </section>
@endsection

@section('javascript')

    @if (session('noty_error'))
        <script type="text/javascript">
            swal({
                title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.error_oops'), config("app.locale")) }}",
                text: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.already_sent_report'), config("app.locale")) }}",
                type: "error",
                confirmButtonText: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
            });
        </script>
    @endif

    @if (session('noty_success'))
        <script type="text/javascript">
            swal({
                title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.thanks'), config("app.locale")) }}",
                text: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.reported_success'), config("app.locale")) }}",
                type: "success",
                confirmButtonText: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
            });
        </script>
    @endif

@endsection
