@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription_price'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi bi-cash-stack mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription_price'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_subscription'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if (session('status'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('status'), config("app.locale")) }}
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </button>

                            <i class="far fa-times-circle mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.error_desc'), config("app.locale"))}}
                        </div>
                    @endif

                    @if (auth()->user()->verified_id == 'no' && $settings->requests_verify_account == 'on')
                        <div class="alert alert-danger mb-3">
                            <ul class="list-unstyled m-0">
                                <li>
                                    <i class="fa fa-exclamation-triangle"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.verified_account_info'), config("app.locale"))}}
                                    <a href="{{url('settings/verify/account')}}"
                                       class="text-white link-border">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.verify_account'), config("app.locale"))}}</a>
                                </li>
                            </ul>
                        </div>
                    @endif

                    @if (auth()->user()->free_subscription == 'no' && auth()->user()->verified_id == 'yes')
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <i class="fa fa-info-circle mr-2"></i>
                            <span>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.user_gain', ['percentage' => auth()->user()->custom_fee == 0 ? (100 - $settings->fee_commission) : (100 - auth()->user()->custom_fee)]), config("app.locale")) }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('settings/subscription') }}">

                        @csrf

                        <div class="form-group">

                            <label><strong>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription_price_weekly'), config("app.locale"))}}</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{$settings->currency_symbol}}</span>
                                </div>
                                <input class="form-control form-control-lg isNumber subscriptionPrice"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject' || auth()->user()->free_subscription == 'yes') disabled
                                       @endif name="price_weekly" placeholder="0.00"
                                       value="{{$settings->currency_code == 'JPY' ? round(auth()->user()->plan('weekly', 'price')) : auth()->user()->plan('weekly', 'price')}}"
                                       type="text">
                                @error('price_weekly')
                                <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject') disabled
                                       @endif name="status_weekly" value="1"
                                       @if (auth()->user()->plan('weekly', 'status')) checked
                                       @endif id="customSwitchWeekly">
                                <label class="custom-control-label switch"
                                       for="customSwitchWeekly">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.status'), config("app.locale")) }}</label>
                            </div>

                            <label
                                class="mt-4"><strong>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.subscription_price'), config("app.locale"))}}
                                    *</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{$settings->currency_symbol}}</span>
                                </div>
                                <input class="form-control form-control-lg isNumber subscriptionPrice"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject' || auth()->user()->free_subscription == 'yes') disabled
                                       @endif name="price" placeholder="0.00"
                                       value="{{$settings->currency_code == 'JPY' ? round(auth()->user()->plan('monthly', 'price')) : auth()->user()->plan('monthly', 'price')}}"
                                       type="text">
                                @error('price')
                                <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <label
                                class="mt-4"><strong>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription_price_quarterly'), config("app.locale"))}}</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{$settings->currency_symbol}}</span>
                                </div>
                                <input class="form-control form-control-lg isNumber subscriptionPrice"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject' || auth()->user()->free_subscription == 'yes') disabled
                                       @endif name="price_quarterly" placeholder="0.00"
                                       value="{{$settings->currency_code == 'JPY' ? round(auth()->user()->plan('quarterly', 'price')) : auth()->user()->plan('quarterly', 'price')}}"
                                       type="text">
                                @error('price_quarterly')
                                <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject') disabled
                                       @endif name="status_quarterly" value="1"
                                       @if (auth()->user()->plan('quarterly', 'status')) checked
                                       @endif id="customSwitchQuarterly">
                                <label class="custom-control-label switch"
                                       for="customSwitchQuarterly">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.status'), config("app.locale")) }}</label>
                            </div>

                            <label
                                class="mt-4"><strong>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans('general.subscription_price_biannually')}}</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{$settings->currency_symbol}}</span>
                                </div>
                                <input class="form-control form-control-lg isNumber subscriptionPrice"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject' || auth()->user()->free_subscription == 'yes') disabled
                                       @endif name="price_biannually" placeholder="0.00"
                                       value="{{$settings->currency_code == 'JPY' ? round(auth()->user()->plan('biannually', 'price')) : auth()->user()->plan('biannually', 'price')}}"
                                       type="text">
                                @error('price_biannually')
                                <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject') disabled
                                       @endif name="status_biannually" value="1"
                                       @if (auth()->user()->plan('biannually', 'status')) checked
                                       @endif id="customSwitchBiannually">
                                <label class="custom-control-label switch"
                                       for="customSwitchBiannually">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.status'), config("app.locale")) }}</label>
                            </div>

                            <label
                                class="mt-4"><strong>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription_price_yearly'), config("app.locale"))}}</strong></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{$settings->currency_symbol}}</span>
                                </div>
                                <input class="form-control form-control-lg isNumber subscriptionPrice"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject' || auth()->user()->free_subscription == 'yes') disabled
                                       @endif name="price_yearly" placeholder="0.00"
                                       value="{{$settings->currency_code == 'JPY' ? round(auth()->user()->plan('yearly', 'price')) : auth()->user()->plan('yearly', 'price')}}"
                                       type="text">
                                @error('price_yearly')
                                <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject') disabled
                                       @endif name="status_yearly" value="1"
                                       @if (auth()->user()->plan('yearly', 'status')) checked
                                       @endif id="customSwitchYearly">
                                <label class="custom-control-label switch"
                                       for="customSwitchYearly">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.status'), config("app.locale")) }}</label>
                            </div>

                            <div class="text-muted btn-block mb-4 mt-4">
                                <div class="custom-control custom-switch custom-switch-lg">
                                    <input type="checkbox" class="custom-control-input"
                                           @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject') disabled
                                           @endif name="free_subscription" value="yes"
                                           @if (auth()->user()->free_subscription == 'yes') checked
                                           @endif id="customSwitchFreeSubscription">
                                    <label class="custom-control-label switch"
                                           for="customSwitchFreeSubscription">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.free_subscription'), config("app.locale")) }}</label>
                                </div>

                                @if (auth()->user()->totalSubscriptionsActive() != 0)

                                    @if (auth()->user()->free_subscription == 'yes')
                                        <div class="alert alert-warning display-none mt-3" role="alert"
                                             id="alertDisableFreeSubscriptions">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <span>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.alert_disable_free_subscriptions'), config("app.locale")) }}</span>
                                        </div>

                                    @else
                                        <div class="alert alert-warning display-none mt-3" role="alert"
                                             id="alertDisablePaidSubscriptions">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <span>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.alert_disable_paid_subscriptions'), config("app.locale")) }}</span>
                                        </div>
                                    @endif

                                @endif
                            </div>
                        </div><!-- End form-group -->

                        <button class="btn btn-1 btn-success btn-block"
                                @if (auth()->user()->verified_id == 'no' || auth()->user()->verified_id == 'reject') disabled
                                @endif onClick="this.form.submit(); this.disabled=true; this.innerText='{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.please_wait'), config("app.locale"))}}';"
                                type="submit">
                            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.save_changes'), config("app.locale"))}}
                        </button>

                    </form>
                </div><!-- end col-md-6 -->
            </div>
        </div>
    </section>
@endsection
