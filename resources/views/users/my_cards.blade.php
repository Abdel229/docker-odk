@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.my_cards'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="feather icon-credit-card mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.my_cards'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_my_cards'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if (session('success_removed'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('success_removed'), config("app.locale")) }}
                        </div>
                    @endif

                    @if (session('success_message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payment_card_success'), config("app.locale")) }}
                        </div>
                    @endif

                    @if (session('error_message'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('error_message'), config("app.locale")) }}
                        </div>
                    @endif

                    @if ($key_secret)

                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="card-text">
                                    @if (auth()->user()->pm_type != '')
                                        <img
                                            src="{{ asset('img/payments/brands/'.strtolower(auth()->user()->pm_type).'.svg')}}"
                                            class="mr-1" alt="">
                                        <strong class="text-capitalize">{{ auth()->user()->pm_type }}</strong> <br> ••••
                                        •••• •••• {{ auth()->user()->pm_last_four }}
                                        <small
                                            class="float-right d-block">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.expiry'), config("app.locale")) }}
                                            : {{ $expiration }}</small>

                                    @else
                                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.not_card_added'), config("app.locale")) }}
                                    @endif
                                </p>

                                <a href="{{ url('settings/payments/card') }}"
                                   class="btn btn-success btn-sm">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->pm_type == '' ? __('general.add') : __('admin.edit'), config("app.locale")) }}</a>

                                @if (auth()->user()->pm_type != '')
                                    <form method="POST" action="{{ url('stripe/delete/card') }}" class="d-inline"
                                          id="formDeleteCardStripe">
                                        @csrf
                                        <input type="button" class="btn btn-danger btn-sm" id="deleteCardStripe"
                                               value="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.delete'), config("app.locale")) }}">
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($paystackPayment)
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">
                                    @if (auth()->user()->paystack_card_brand != '')
                                        <img
                                            src="{{ asset('img/payments/brands/'.strtolower(auth()->user()->paystack_card_brand).'.svg')}}"
                                            class="mr-1" alt="">
                                        <strong
                                            class="text-capitalize">{{ auth()->user()->paystack_card_brand }}</strong>
                                        <br> •••• •••• •••• {{ auth()->user()->paystack_last4 }}
                                        <small
                                            class="float-right d-block">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.expiry'), config("app.locale")) }}
                                            : {{ auth()->user()->paystack_exp }}</small>

                                    @else
                                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.not_card_added'), config("app.locale")) }}
                                    @endif

                                    <small class="alert alert-primary w-100 d-block mt-1">
                                        <i class="fa fa-info-circle mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.notice_charge_to_card', ['amount' => Helper::amountWithoutFormat($chargeAmountPaystack). ' '.$settings->currency_code ]), config("app.locale")) }}
                                    </small>

                                <form method="POST" action="{{ url('paystack/card/authorization') }}" class="d-inline">
                                    @csrf
                                    <input type="submit" class="btn btn-success btn-sm"
                                           value="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->paystack_card_brand == '' ? __('general.add') : __('admin.edit'), config("app.locale")) }}">
                                </form>

                                @if (auth()->user()->paystack_card_brand != '')
                                    <form method="POST" action="{{ url('paystack/delete/card') }}" class="d-inline"
                                          id="formDeleteCardPaystack">
                                        @csrf
                                        <input type="button" class="btn btn-danger btn-sm" id="deleteCardPaystack"
                                               value="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.delete'), config("app.locale")) }}">
                                    </form>
                                @endif

                            </div>
                        </div>
                    @endif

                    <div class="btn-block mt-2">
                        <small><i
                                class="fa fa-lock text-success mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_payment_card'), config("app.locale")) }}
                        </small>
                    </div>

                    @if (! $key_secret && ! $paystackPayment)

                        <div class="alert alert-primary text-center" role="alert">
                            <i class="fa fa-info-circle mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.not_card_added'), config("app.locale")) }}
                        </div>
                    @endif
                </div><!-- end col-md-6 -->
            </div>
        </div>
    </section>
@endsection
