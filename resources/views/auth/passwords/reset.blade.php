@extends('layouts.app')

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

                        <div class="p-4">
                            <h4 class="text-center mb-0 font-weight-bold">
                                {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.reset_password'), config("app.locale"))}}
                            </h4>
                            <small
                                class="btn-block text-center mt-2">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.reset_pass_subtitle'), config("app.locale")) }}</small>
                        </div>

                        <div class="card-body px-lg-5 py-lg-5">

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('status'), config("app.locale")) }}
                                </div>
                            @endif

                            @include('errors.errors-forms')

                            <form method="POST" action="{{url('password/reset')}}">
                                @csrf

                                @if($settings->captcha == 'on')
                                    @captcha
                                @endif

                                <input type="hidden" name="token" value="{{$token}}">

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('email')}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.email'), config("app.locale"))}}"
                                               name="email" required type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative" id="showHidePassword">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconmoon icon-Key"></i></span>
                                        </div>
                                        <input name="password" type="password" class="form-control" required
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.password'), config("app.locale"))}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text c-pointer"><i
                                                    class="feather icon-eye-off"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconmoon icon-Key"></i></span>
                                        </div>
                                        <input name="password_confirmation" type="password" class="form-control"
                                               required
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.confirm_password'), config("app.locale"))}}">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit"
                                            class="btn btn-primary my-4 w-100">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.reset_password'), config("app.locale"))}}</button>
                                </div>
                            </form>

                            @if ($settings->captcha == 'on')
                                <small
                                    class="btn-block text-center">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.protected_recaptcha'), config("app.locale"))}}
                                    <a
                                        href="https://policies.google.com/privacy"
                                        target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy'), config("app.locale"))}}</a>
                                    - <a
                                        href="https://policies.google.com/terms"
                                        target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.terms'), config("app.locale"))}}</a></small>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
