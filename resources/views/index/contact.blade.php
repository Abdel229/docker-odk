@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.contact'), config("app.locale"))}} -@endsection

@section('css')
    <script type="text/javascript">
        var error_scrollelement = {{ count($errors) > 0 ? 'true' : 'false' }};
    </script>
@endsection

@section('content')
    <div class="jumbotron home m-0 bg-gradient">
        <div class="container pt-lg-md">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card bg-white shadow border-0">

                        <div class="p-4">
                            <h4 class="text-center mb-0 font-weight-bold">
                                {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.contact'), config("app.locale"))}}
                            </h4>
                            <small
                                class="btn-block text-center mt-2">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subtitle_contact'), config("app.locale")) }}</small>
                        </div>

                        <div class="card-body px-lg-5 py-lg-5">

                            @if (session('notification'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>

                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('notification'), config("app.locale")) }}
                                </div>
                            @endif

                            @include('errors.errors-forms')

                            <form method="POST" action="{{ url('contact') }}">
                                @csrf

                                @if ($settings->captcha_contact == 'on')
                                    @captcha
                                @endif

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="feather icon-user"></i></span>
                                                </div>
                                                <input class="form-control" required
                                                       value="{{Auth::user()->name ??  old('full_name')}}"
                                                       placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.full_name'), config("app.locale"))}}"
                                                       name="full_name" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="feather icon-mail"></i></span>
                                                </div>
                                                <input name="email" required type="email"
                                                       value="{{Auth::user()->email ??  old('email')}}"
                                                       class="form-control"
                                                       placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.email'), config("app.locale")) }}">
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- Row -->

                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-feather"></i></span>
                                        </div>
                                        <input name="subject" required type="text" value="{{old('subject')}}"
                                               class="form-control"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans( trans('general.subject'), config("app.locale")) }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea name="message" required rows="4"
                                              class="form-control">{{old('message') }}</textarea>
                                </div><!-- End Form Group -->

                                @if ($settings->link_terms != '' && $settings->link_privacy != '')
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        <input class="custom-control-input" required id=" customCheckLogin"
                                               name="agree_terms_privacy" type="checkbox">
                                        <label class="custom-control-label" for=" customCheckLogin">
                      <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.i_agree_with'), config("app.locale"))}}
                        <a href="{{$settings->link_terms}}"
                           target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.terms_conditions'), config("app.locale"))}}</a>
                        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.and'), config("app.locale"))}} <a
                              href="{{$settings->link_privacy}}"
                              target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.privacy_policy'), config("app.locale"))}}</a>
                      </span>
                                        </label>
                                    </div>
                                @endif

                                <div class="text-center">
                                    <button type="submit"
                                            class="btn btn-primary my-4 w-100">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.send'), config("app.locale"))}}
                                        <i class="fa fa-paper-plane ml-1"></i></button>
                                </div>
                            </form>
                            @if ($settings->captcha_contact == 'on')
                                <small
                                    class="btn-block text-center">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.protected_recaptcha'), config("app.locale"))}}
                                    <a href="https://policies.google.com/privacy"
                                       target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy'), config("app.locale"))}}</a>
                                    - <a href="https://policies.google.com/terms"
                                         target="_blank">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.terms'), config("app.locale"))}}</a>
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
