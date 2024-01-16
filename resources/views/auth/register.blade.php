@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.sign_up'), config("app.locale"))}} -@endsection

@section('content')
    <div class="jumbotron home m-0 bg-gradient">
        <div class="container pt-lg-md">
            <div class="row">
                <div class="col-lg-7">
                    <img src="{{url('img', $settings->home_index)}}"
                         class="img-center img-fluid d-lg-block d-none" alt="">
                </div>
                <div class="col-lg-5">
                    <div class="card bg-white shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5">

                            <h4 class="text-center mb-0 font-weight-bold">
                                {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.sign_up'), config("app.locale"))}}
                            </h4>
                            <small
                                class="btn-block text-center mt-2 mb-4">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.signup_welcome'), config("app.locale")) }}</small>

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('status'), config("app.locale")) }}
                                </div>
                            @endif

                            @include('errors.errors-forms')

                            @if($settings->facebook_login == 'on' || $settings->google_login == 'on' || $settings->twitter_login == 'on')
                                <div class="mb-2 w-100">

                                    @if ($settings->facebook_login == 'on')
                                        <a href="{{url('oauth/facebook')}}"
                                           class="btn btn-facebook auth-form-btn flex-grow mb-2 w-100">
                                            <i class="fab fa-facebook mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.sign_up_with'), config("app.locale")) }}
                                            Facebook
                                        </a>
                                    @endif

                                    @if ($settings->twitter_login == 'on')
                                        <a href="{{url('oauth/twitter')}}"
                                           class="btn btn-twitter auth-form-btn mb-2 w-100">
                                            <i class="fab fa-twitter mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.sign_up_with'), config("app.locale")) }}
                                            Twitter
                                        </a>
                                    @endif

                                    @if ($settings->google_login == 'on')
                                        <a href="{{url('oauth/google')}}"
                                           class="btn btn-google auth-form-btn flex-grow w-100">
                                            <img src="{{ url('img/google.svg') }}" class="mr-2" width="18"
                                                 height="18"
                                                 alt=""> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.sign_up_with'), config("app.locale")) }}
                                            Google
                                        </a>
                                    @endif
                                </div>

                                <small
                                    class="btn-block text-center my-3 text-uppercase or">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.or'), config("app.locale"))}}</small>

                            @endif

                            <form method="POST" action="{{ route('register') }}" id="formLoginRegister">
                                @csrf

                                @if($settings->captcha == 'on')
                                    @captcha
                                @endif

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-user"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('name')}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.full_name'), config("app.locale"))}}"
                                               name="name" type="text" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('email')}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.email'), config("app.locale"))}}"
                                               name="email" type="text" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative" id="showHidePassword">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconmoon icon-Key"></i></span>
                                        </div>
                                        <input name="password" type="password" class="form-control"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.password'), config("app.locale"))}}"
                                               required>
                                        <div class="input-group-append">
                                            <span class="input-group-text c-pointer"><i
                                                    class="feather icon-eye-off"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckRegister" type="checkbox"
                                           name="agree_gdpr" required>
                                    <label class="custom-control-label" for="customCheckRegister">
                      <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.i_agree_gdpr'), config("app.locale"))}}
                        <a href="{{$settings->link_privacy}}"
                           target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.privacy_policy'), config("app.locale"))}}</a>
                      </span>
                                    </label>
                                </div>

                                <div class="alert alert-danger display-none mb-0 mt-3" id="errorLogin">
                                    <ul class="list-unstyled m-0" id="showErrorsLogin"></ul>
                                </div>

                                <div class="alert alert-success mb-0 mt-3 display-none" id="checkAccount"></div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-4 w-100" id="btnLoginRegister">
                                        <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.sign_up'), config("app.locale"))}}
                                    </button>
                                </div>
                            </form>

                            @if ($settings->captcha == 'on')
                                <small
                                    class="btn-block text-center mt-3">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.protected_recaptcha'), config("app.locale"))}}
                                    <a href="https://policies.google.com/privacy"
                                       target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.privacy'), config("app.locale"))}}</a>
                                    - <a href="https://policies.google.com/terms"
                                         target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.terms'), config("app.locale"))}}</a></small>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="{{url('login')}}" class="text-light">
                                <small>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.already_have_an_account'), config("app.locale"))}}</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
