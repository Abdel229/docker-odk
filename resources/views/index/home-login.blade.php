@extends('layouts.app')

@section('content')
<<<<<<< HEAD
  <div class="jumbotron m-0 bg-gradient">
    <div class="container pt-lg-md">
      <div class="row">
        <div class="col-lg-7">
          <img src="{{url('public/img', $settings->home_index)}}" class="img-center img-fluid d-lg-block d-none">
        </div>
        <div class="col-lg-5">

          <div class="text-center d-block w-100">
            <img src="{{url('public/img', $settings->logo)}}" alt="{{$settings->title}}" width="50%" class="logo align-baseline mb-1" />
          </div>

          <div class="card bg-white shadow border-0">

            <div class="card-body px-lg-5 py-lg-5 pt-4">

              <small class="btn-block text-center pb-4 h6">{{ trans('general.title_home_login') }}</small>

        @if (session('login_required'))
    			<div class="alert alert-danger" id="dangerAlert">
                		<i class="fa fa-exclamation-triangle"></i> {{trans('auth.login_required')}}
                		</div>
                	@endif

              @if ($settings->facebook_login == 'on' || $settings->google_login == 'on' || $settings->twitter_login == 'on')
              <div class="mb-2 w-100">

                @if ($settings->facebook_login == 'on')
                  <a href="{{url('oauth/facebook')}}" class="btn btn-facebook auth-form-btn flex-grow mb-2 w-100">
                    <i class="fab fa-facebook mr-2"></i> {{ __('auth.login_with') }} Facebook
                  </a>
                @endif

                @if ($settings->twitter_login == 'on')
                <a href="{{url('oauth/twitter')}}" class="btn btn-twitter auth-form-btn mb-2 w-100">
                  <i class="fab fa-twitter mr-2"></i> {{ __('auth.login_with') }} Twitter
                </a>
              @endif

                  @if ($settings->google_login == 'on')
                  <a href="{{url('oauth/google')}}" class="btn btn-google auth-form-btn flex-grow w-100">
                    <img src="{{ url('public/img/google.svg') }}" class="mr-2" width="18" height="18"> {{ __('auth.login_with') }} Google
                  </a>
                @endif
                </div>

                <small class="btn-block text-center my-3 text-uppercase or">{{__('general.or')}}</small>

              @endif

              <form method="POST" action="{{ route('login') }}" data-url-login="{{ route('login') }}" data-url-register="{{ route('register') }}" id="formLoginRegister" enctype="multipart/form-data">
                  @csrf

                  <input type="hidden" name="return" value="{{ count($errors) > 0 ? old('return') : url()->previous() }}">

                  @if ($settings->captcha == 'on')
                    @captcha
                  @endif

                  <div class="form-group mb-3 display-none" id="full_name">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="feather icon-user"></i></span>
                      </div>
                      <input class="form-control"  value="{{ old('name')}}" placeholder="{{trans('auth.full_name')}}" name="name" type="text">
                    </div>
                  </div>

                <div class="form-group mb-3 display-none" id="email">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="feather icon-mail"></i></span>
                    </div>
                    <input class="form-control" value="{{ old('email')}}" placeholder="{{trans('auth.email')}}" name="email" type="text">
                  </div>
                </div>

                <div class="form-group mb-3" id="username_email">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="feather icon-mail"></i></span>
                    </div>
                    <input class="form-control" value="{{ old('username_email') }}" placeholder="{{ trans('auth.username_or_email') }}" name="username_email" type="text">

                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative" id="showHidePassword">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="iconmoon icon-Key"></i></span>
                    </div>
                    <input name="password" type="password" class="form-control" placeholder="{{ trans('auth.password') }}">
                    <div class="input-group-append">
                      <span class="input-group-text c-pointer"><i class="feather icon-eye-off"></i></span>
                  </div>
                </div>
                <small class="form-text text-muted">
                  <a href="{{url('password/reset')}}" id="forgotPassword">
                    {{trans('auth.forgot_password')}}
                  </a>
                </small>
                </div>

                <div class="form-group d-none">
                  <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-globe"></i></span>
                  </div>
                  <select name="countries_id" class="form-control custom-select">
                    <option value="">{{trans('general.select_your_country')}}</option>
                        @foreach(  Countries::orderBy('country_name')->get() as $country )
                          <option id="{{$country->country_code}}" value="{{$country->id}}">{{ $country->country_name }}</option>
                          @endforeach
                        </select>
                        </div>
                  </div>

                <div class="custom-control custom-control-alternative custom-checkbox" id="remember">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span>{{trans('auth.remember_me')}}</span>
                  </label>
                </div>

                <div class="custom-control custom-control-alternative custom-checkbox display-none" id="agree_gdpr">
                  <input class="custom-control-input" id="customCheckRegister" type="checkbox" name="agree_gdpr">
                    <label class="custom-control-label" for="customCheckRegister">
                      <span>{{trans('admin.i_agree_gdpr')}}
                        <a href="{{$settings->link_privacy}}" target="_blank">{{trans('admin.privacy_policy')}}</a>
                      </span>
                    </label>
                </div>

                <div class="alert alert-danger display-none mb-0 mt-3" id="errorLogin">
                    <ul class="list-unstyled m-0" id="showErrorsLogin"></ul>
                  </div>

                  <div class="alert alert-success display-none mb-0 mt-3" id="checkAccount"></div>

                <div class="text-center">
                  <button type="submit" id="btnLoginRegister" class="btn btn-primary mt-4 w-100"><i></i> {{trans('auth.login')}}</button>
                </div>
              </form>

              @if ($settings->captcha == 'on')
                <small class="btn-block text-center mt-3">{{trans('auth.protected_recaptcha')}} <a href="https://policies.google.com/privacy" target="_blank">{{trans('general.privacy')}}</a> - <a href="https://policies.google.com/terms" target="_blank">{{trans('general.terms')}}</a></small>
              @endif

              @if ($settings->registration_active == '1')
              <div class="row mt-3">
                <div class="col-12 text-center">
                  <a href="javascript:void(0);" id="toggleLogin" data-not-account="{{trans('auth.not_have_account')}}" data-already-account="{{trans('auth.already_have_an_account')}}" data-text-login="{{trans('auth.login')}}" data-text-register="{{trans('auth.sign_up')}}">
                    <strong>{{trans('auth.not_have_account')}}</strong>
                  </a>
                </div>
              </div>
            @endif

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="text-center py-3 px-3">
    @include('includes.footer-tiny')
  </div>
@endsection

@section('javascript')
<script type="text/javascript">
    $.ajax({
		url: "https://geolocation-db.com/jsonp",
		jsonpCallback: "callback",
		dataType: "jsonp",
		success: function( location ) {
			$('#'+location.country_code).attr('selected', 'selected');
		}
	});

  @if (session('success_verify'))
  	swal({
  		title: "{{ trans('general.welcome') }}",
  		text: "{{ trans('users.account_validated') }}",
  		type: "success",
  		confirmButtonText: "{{ trans('users.ok') }}"
  		});
  	 @endif

  	 @if (session('error_verify'))
  	swal({
  		title: "{{ trans('general.error_oops') }}",
  		text: "{{ trans('users.code_not_valid') }}",
  		type: "error",
  		confirmButtonText: "{{ trans('users.ok') }}"
  		});
  	 @endif
</script>
=======
    <div class="jumbotron m-0 bg-gradient">
        <div class="container pt-lg-md">
            <div class="row">
                <div class="col-lg-7">
                    <img src="{{url('img', $settings->home_index)}}"
                         class="img-center img-fluid d-lg-block d-none" alt="">
                </div>
                <div class="col-lg-5">

                    <div class="text-center d-block w-100">
                        <img src="{{url('img', $settings->logo)}}" alt="{{$settings->title}}" width="50%"
                             class="logo align-baseline mb-1"/>
                    </div>

                    <div class="card bg-white shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5 pt-4">

                            <small
                                class="btn-block text-center pb-4 h6">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.title_home_login'), config("app.locale")) }}</small>

                            @if (session('login_required'))
                                <div class="alert alert-danger" id="dangerAlert">
                                    <i class="fa fa-exclamation-triangle"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.login_required'), config("app.locale"))}}
                                </div>
                            @endif

                            @if ($settings->facebook_login == 'on' || $settings->google_login == 'on' || $settings->twitter_login == 'on')
                                <div class="mb-2 w-100">

                                    @if ($settings->facebook_login == 'on')
                                        <a href="{{url('oauth/facebook')}}"
                                           class="btn btn-facebook auth-form-btn flex-grow mb-2 w-100">
                                            <i class="fab fa-facebook mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.login_with'), config("app.locale")) }}
                                            Facebook
                                        </a>
                                    @endif

                                    @if ($settings->twitter_login == 'on')
                                        <a href="{{url('oauth/twitter')}}"
                                           class="btn btn-twitter auth-form-btn mb-2 w-100">
                                            <i class="fab fa-twitter mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.login_with'), config("app.locale")) }}
                                            Twitter
                                        </a>
                                    @endif

                                    @if ($settings->google_login == 'on')
                                        <a href="{{url('oauth/google')}}"
                                           class="btn btn-google auth-form-btn flex-grow w-100">
                                            <img src="{{ url('img/google.svg') }}" class="mr-2" width="18"
                                                 height="18"
                                                 alt=""> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.login_with'), config("app.locale")) }}
                                            Google
                                        </a>
                                    @endif
                                </div>

                                <small
                                    class="btn-block text-center my-3 text-uppercase or">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.or'), config("app.locale"))}}</small>

                            @endif

                            <form method="POST" action="{{ route('login') }}" data-url-login="{{ route('login') }}"
                                  data-url-register="{{ route('register') }}" id="formLoginRegister"
                                  enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="return"
                                       value="{{ count($errors) > 0 ? old('return') : url()->previous() }}">

                                @if ($settings->captcha == 'on')
                                    @captcha
                                @endif

                                <div class="form-group mb-3 display-none" id="full_name">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-user"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('name')}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.full_name'), config("app.locale"))}}"
                                               name="name" type="text">
                                    </div>
                                </div>

                                <div class="form-group mb-3 display-none" id="email">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('email')}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.email'), config("app.locale"))}}"
                                               name="email" type="text">
                                    </div>
                                </div>

                                <div class="form-group mb-3" id="username_email">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('username_email') }}"
                                               placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.username_or_email'), config("app.locale")) }}"
                                               name="username_email"
                                               type="text">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative" id="showHidePassword">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconmoon icon-Key"></i></span>
                                        </div>
                                        <input name="password" type="password" class="form-control"
                                               placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.password'), config("app.locale")) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text c-pointer"><i
                                                    class="feather icon-eye-off"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        <a href="{{url('password/reset')}}" id="forgotPassword">
                                            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.forgot_password'), config("app.locale"))}}
                                        </a>
                                    </small>
                                </div>

                                <div class="form-group d-none">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                        </div>
                                        <select name="countries_id" class="form-control custom-select">
                                            <option
                                                value="">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.select_your_country'), config("app.locale"))}}</option>
                                            @foreach(  Countries::orderBy('country_name')->get() as $country )
                                                <option id="{{$country->country_code}}"
                                                        value="{{$country->id}}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="custom-control custom-control-alternative custom-checkbox" id="remember">
                                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox"
                                           name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for=" customCheckLogin">
                                        <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.remember_me'), config("app.locale"))}}</span>
                                    </label>
                                </div>

                                <div class="custom-control custom-control-alternative custom-checkbox display-none"
                                     id="agree_gdpr">
                                    <input class="custom-control-input" id="customCheckRegister" type="checkbox"
                                           name="agree_gdpr">
                                    <label class="custom-control-label" for="customCheckRegister">
                      <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.i_agree_gdpr'), config("app.locale"))}}
                        <a href="{{$settings->link_privacy}}"
                           target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.privacy_policy'), config("app.locale"))}}</a>
                      </span>
                                    </label>
                                </div>

                                <div class="alert alert-danger display-none mb-0 mt-3" id="errorLogin">
                                    <ul class="list-unstyled m-0" id="showErrorsLogin"></ul>
                                </div>

                                <div class="alert alert-success display-none mb-0 mt-3" id="checkAccount"></div>

                                <div class="text-center">
                                    <button type="submit" id="btnLoginRegister" class="btn btn-primary mt-4 w-100">
                                        <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.login'), config("app.locale"))}}
                                    </button>
                                </div>
                            </form>

                            @if ($settings->captcha == 'on')
                                <small
                                    class="btn-block text-center mt-3">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.protected_recaptcha'), config("app.locale"))}}
                                    <a
                                        href="https://policies.google.com/privacy"
                                        target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy'), config("app.locale"))}}</a>
                                    - <a
                                        href="https://policies.google.com/terms"
                                        target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.terms'), config("app.locale"))}}</a></small>
                            @endif

                            @if ($settings->registration_active == '1')
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <a href="javascript:void(0);" id="toggleLogin"
                                           data-not-account="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.not_have_account'), config("app.locale"))}}"
                                           data-already-account="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.already_have_an_account'), config("app.locale"))}}"
                                           data-text-login="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.login'), config("app.locale"))}}"
                                           data-text-register="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.sign_up'), config("app.locale"))}}">
                                            <strong>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.not_have_account'), config("app.locale"))}}</strong>
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="text-center py-3 px-3">
        @include('includes.footer-tiny')
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        $.ajax({
            url: "https://geolocation-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
                $('#' + location.country_code).attr('selected', 'selected');
            }
        });

        @if (session('success_verify'))
        swal({
            title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.welcome'), config("app.locale")) }}",
            text: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.account_validated'), config("app.locale")) }}",
            type: "success",
            confirmButtonText: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
        });
        @endif

        @if (session('error_verify'))
        swal({
            title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.error_oops'), config("app.locale")) }}",
            text: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.code_not_valid'), config("app.locale")) }}",
            type: "error",
            confirmButtonText: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
        });
        @endif
    </script>
>>>>>>> main
@endsection
