@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div
                        class="card-header">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('Verify Your Email Address'), config("app.locale")) }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('A fresh verification link has been sent to your email address.'), config("app.locale")) }}
                            </div>
                        @endif

                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('Before proceeding, please check your email for a verification link.'), config("app.locale")) }}
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('If you did not receive the email'), config("app.locale")) }}
                        , <a
                            href="{{ route('verification.resend') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('click here to request another'), config("app.locale")) }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
