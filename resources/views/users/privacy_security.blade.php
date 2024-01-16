@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy_security'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi bi-shield-check mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy_security'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.desc_privacy'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if (session('status'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('status'), config("app.locale")) }}
                        </div>
                    @endif

                    @include('errors.errors-forms')

                    @if ($sessions)
                        <h5>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.login_sessions'), config("app.locale")) }}</h5>
                        <div class="card mb-4">
                            <div class="card-body">
                                <small
                                    class="w-100 d-block"><strong>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.last_login_record'), config("app.locale")) }}</strong></small>
                                <p class="card-text">{{ $sessions->user_agent }}</p>
                                <p>
                    <span>IP: {{ $sessions->ip_address }}

            <span class="w-100 d-block mt-2">
              @if ($current_session_id == $sessions->id)
                    <button type="button" disabled
                            class="btn btn-sm btn-primary e-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.this_device'), config("app.locale")) }}</button>
                                @else
                                    <form method="POST" action="{{ url('logout/session', $sessions->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                class="feather icon-trash-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delete'), config("app.locale")) }}
                                        </button>
                                    </form>
                                @endif


                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->verified_id == 'yes')

                        <h5>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.privacy'), config("app.locale")) }}</h5>

                        <form method="POST" action="{{ url('privacy/security') }}">

                            @csrf

                            <div class="form-group">
                                <div class="btn-block mb-4">
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="checkbox" class="custom-control-input" name="hide_profile"
                                               value="yes" @if (auth()->user()->hide_profile == 'yes') checked
                                               @endif id="customSwitch1">
                                        <label class="custom-control-label switch"
                                               for="customSwitch1">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.hide_profile'), config("app.locale")) }} {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.info_hide_profile'), config("app.locale")) }}</label>
                                    </div>
                                </div>

                                <div class="btn-block mb-4">
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="checkbox" class="custom-control-input" name="hide_last_seen"
                                               value="yes" @if (auth()->user()->hide_last_seen == 'yes') checked
                                               @endif id="customSwitch2">
                                        <label class="custom-control-label switch"
                                               for="customSwitch2">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.hide_last_seen'), config("app.locale")) }}</label>
                                    </div>
                                </div>

                                <div class="btn-block mb-4">
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="checkbox" class="custom-control-input" name="active_status_online"
                                               value="yes" @if (auth()->user()->active_status_online == 'yes') checked
                                               @endif id="customSwitch6">
                                        <label class="custom-control-label switch"
                                               for="customSwitch6">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.active_status_online'), config("app.locale")) }}</label>
                                    </div>
                                </div>

                                <div class="btn-block mb-4">
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="checkbox" class="custom-control-input"
                                               name="hide_count_subscribers" value="yes"
                                               @if (auth()->user()->hide_count_subscribers == 'yes') checked
                                               @endif id="customSwitch3">
                                        <label class="custom-control-label switch"
                                               for="customSwitch3">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.hide_count_subscribers'), config("app.locale")) }}</label>
                                    </div>
                                </div>

                                <div class="btn-block mb-4">
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="checkbox" class="custom-control-input" name="hide_my_country"
                                               value="yes" @if (auth()->user()->hide_my_country == 'yes') checked
                                               @endif id="customSwitch4">
                                        <label class="custom-control-label switch"
                                               for="customSwitch4">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.hide_my_country'), config("app.locale")) }}</label>
                                    </div>
                                </div>

                                <div class="btn-block mb-4">
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="checkbox" class="custom-control-input" name="show_my_birthdate"
                                               value="yes" @if (auth()->user()->show_my_birthdate == 'yes') checked
                                               @endif id="customSwitch5">
                                        <label class="custom-control-label switch"
                                               for="customSwitch5">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.show_my_birthdate'), config("app.locale")) }}</label>
                                    </div>
                                </div>

                                <h5 class="mt-5">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.security'), config("app.locale")) }}</h5>

                                <div class="btn-block mb-4">
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="checkbox" class="custom-control-input" name="two_factor_auth"
                                               value="yes" @if (auth()->user()->two_factor_auth == 'yes') checked
                                               @endif id="customSwitch7">
                                        <label class="custom-control-label switch" for="customSwitch7">
                                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.two_step_auth'), config("app.locale")) }}
                                            <i class="bi bi-info-circle text-muted" data-toggle="tooltip"
                                               data-placement="top"
                                               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.two_step_auth_info'), config("app.locale"))}}"></i>
                                        </label>
                                    </div>
                                </div>
                            </div><!-- End form-group -->

                            <button class="btn btn-1 btn-success btn-block"
                                    onClick="this.form.submit(); this.disabled=true; this.innerText='{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.please_wait'), config("app.locale"))}}';"
                                    type="submit">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.save_changes'), config("app.locale"))}}</button>

                        </form>
                    @endif

                    @if (! auth()->user()->isSuperAdmin())
                        <h5 class="mt-5">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delete_account'), config("app.locale")) }}</h5>
                        <small
                            class="w-100">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delete_account_alert'), config("app.locale")) }}</small>

                        <div class="w-100 d-block mt-2 mb-5">
                            <a class="btn btn-main btn-danger pr-3 pl-3" href="{{ url('account/delete') }}">
                                <i class="feather icon-user-x mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delete_account'), config("app.locale")) }}
                            </a>
                        </div>
                    @endif

                </div><!-- end col-md-6 -->
            </div>
        </div>
    </section>
@endsection
