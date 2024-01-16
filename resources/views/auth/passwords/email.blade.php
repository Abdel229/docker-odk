@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.password_recover'), config("app.locale"))}} -@endsection

@section('css')
    <script type="text/javascript">
        var error_scrollelement = {{ count($errors) > 0 ? 'true' : 'false' }};
    </script>
@endsection

@section('content')
    <div class="jumbotron home m-0 bg-gradient">
        <div class="container pt-lg-md">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card bg-white shadow border-0">

                        <h4 class="text-center mb-0 font-weight-bold pt-4 px-4">
                            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.password_recover'), config("app.locale"))}}
                        </h4>
                        <small class="btn-block text-center mt-2 px-4">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.recover_pass_subtitle'), config("app.locale")) }}</small>

                        <div class="card-body px-lg-5 py-lg-5">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('status'), config("app.locale")) }}}
                                </div>
                            @endif

                            @include('errors.errors-forms')

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                @if($settings->captcha == 'on')
                                    @captcha
                                @endif

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                        </div>
                                        <input class="form-control @if (count($errors) > 0) is-invalid @endif"
                                               value="{{ old('email')}}" placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.email'), config("app.locale"))}}"
                                               name="email" required type="text">

                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit"
                                            class="btn btn-primary my-4 w-100">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.send_pass_reset'), config("app.locale"))}}</button>
                                </div>
                            </form>

                            @if ($settings->captcha == 'on')
                                <small class="btn-block text-center">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.protected_recaptcha'), config("app.locale"))}} <a
                                        href="https://policies.google.com/privacy"
                                        target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy'), config("app.locale"))}}</a> - <a
                                        href="https://policies.google.com/terms"
                                        target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.terms'), config("app.locale"))}}</a></small>
                            @endif

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="{{ url()->previous() }}" class="text-light">
                                <small><i class="fas fa-arrow-left"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.go_back'), config("app.locale"))}}</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
