@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.payout_method'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi bi-credit-card mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.payout_method'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.default_payout_method'), config("app.locale"))}}
                        :
                        @if(auth()->user()->payment_gateway != '')
                            <strong class="text-success">
                                {{auth()->user()->payment_gateway == 'Bank' ? \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.bank_transfer'), config("app.locale")) : auth()->user()->payment_gateway}}
                            </strong>
                        @else <strong
                            class="text-danger">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.none'), config("app.locale"))}}</strong> @endif
                    </p>
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
                            <i class="bi-check2 mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('status'), config("app.locale")) }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <i class="bi-exclamation-triangle mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('error'), config("app.locale")) }}
                        </div>
                    @endif

                    @include('errors.errors-forms')

                    @if (auth()->user()->verified_id != 'yes' && auth()->user()->balance == 0.00)

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

                    @if (auth()->user()->verified_id == 'yes' || auth()->user()->balance != 0.00)

                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <i class="fa fa-info-circle mr-2"></i>
                            <span> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payout_method_info'), config("app.locale")) }}
          <small
              class="btn-block">* {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payment_process_days', ['days' => $settings->days_process_withdrawals]), config("app.locale")) }}</small>
            </span>
                        </div>

                        @if( $settings->payout_method_paypal == 'on' )
                        <!--============ START PAYPAL ============-->
                            <div class="custom-control custom-radio mb-3">
                                <input name="payment_gateway" value="PayPal" id="radio1" class="custom-control-input"
                                       @if (auth()->user()->payment_gateway == 'PayPal') checked @endif type="radio">
                                <label class="custom-control-label" for="radio1">
                                    <span><img
                                            src="{{url('img/payments', auth()->user()->dark_mode == 'off' ? 'paypal.png' : 'paypal-white.png')}}"
                                            width="70" alt=""/></span>
                                    <small
                                        class="w-100 d-block">* {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.processor_fees_may_apply'), config("app.locale"))}}</small>
                                </label>
                            </div>

                            <form method="POST" action="{{ url('settings/payout/method/paypal') }}" id="PayPal"
                                  @if (auth()->user()->payment_gateway != 'PayPal') class="display-none" @endif>
                                @csrf

                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-paypal"></i></span>
                                        </div>
                                        <input class="form-control" name="email_paypal"
                                               value="{{auth()->user()->paypal_account == '' ? old('email_paypal') : auth()->user()->paypal_account}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.email_paypal'), config("app.locale"))}}"
                                               required type="email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" name="email_paypal_confirmation"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.confirm_email_paypal'), config("app.locale"))}}"
                                               required type="email">
                                    </div>
                                </div>
                                <button class="btn btn-1 btn-success btn-block"
                                        type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.save_payout_method'), config("app.locale"))}}</button>
                            </form>
                            <!--============ END PAYPAL ============-->
                        @endif

                        {{--                        @if( $settings->payout_method_paypal == 'on' )--}}
                        {{--                        <!--============ START PAYPAL ============-->--}}
                        {{--                            <div class="custom-control custom-radio mb-3">--}}
                        {{--                                <input name="payment_gateway" value="CinetPay" id="radio1" class="custom-control-input"--}}
                        {{--                                       @if (auth()->user()->payment_gateway == 'CinetPay') checked @endif type="radio">--}}
                        {{--                                <label class="custom-control-label" for="radio1">--}}
                        {{--                                    <span><img--}}
                        {{--                                            src="{{ url('img/payments/cinetpay.png') }}"--}}
                        {{--                                            width="70" alt=""/></span>--}}
                        {{--                                    <small--}}
                        {{--                                        class="w-100 d-block">* {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.processor_fees_may_apply'), config("app.locale"))}}</small>--}}
                        {{--                                </label>--}}
                        {{--                            </div>--}}

                        {{--                            <form method="POST" action="{{ url('settings/payout/method/cinetpay') }}" id="CinetPay"--}}
                        {{--                                  @if (auth()->user()->payment_gateway != 'CinetPay') class="display-none" @endif>--}}
                        {{--                                @csrf--}}

                        {{--                                <div class="form-group">--}}
                        {{--                                    <div class="input-group mb-4">--}}
                        {{--                                        <div class="input-group-prepend">--}}
                        {{--                                            <span class="input-group-text"><i class="fab fa-paypal"></i></span>--}}
                        {{--                                        </div>--}}
                        {{--                                        <input class="form-control" name="email_paypal"--}}
                        {{--                                               value="{{auth()->user()->paypal_account == '' ? old('email_paypal') : auth()->user()->paypal_account}}"--}}
                        {{--                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.email_paypal'), config("app.locale"))}}"--}}
                        {{--                                               required type="email">--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}

                        {{--                                <div class="form-group">--}}
                        {{--                                    <div class="input-group mb-4">--}}
                        {{--                                        <div class="input-group-prepend">--}}
                        {{--                                            <span class="input-group-text"><i class="far fa-envelope"></i></span>--}}
                        {{--                                        </div>--}}
                        {{--                                        <input class="form-control" name="email_paypal_confirmation"--}}
                        {{--                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.confirm_email_paypal'), config("app.locale"))}}"--}}
                        {{--                                               required type="email">--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <button class="btn btn-1 btn-success btn-block"--}}
                        {{--                                        type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.save_payout_method'), config("app.locale"))}}</button>--}}
                        {{--                            </form>--}}
                        {{--                            <!--============ END PAYPAL ============-->--}}
                        {{--                        @endif--}}
                        {{--                        @if( $settings->payout_method_payoneer == 'on' )--}}
                        {{--                        <!--============ START PAYONEER ============-->--}}
                        {{--                            <div class="custom-control custom-radio mb-3 mt-3">--}}
                        {{--                                <input name="payment_gateway" value="Payoneer" id="radio2" class="custom-control-input"--}}
                        {{--                                       @if (auth()->user()->payment_gateway == 'Payoneer') checked @endif type="radio">--}}
                        {{--                                <label class="custom-control-label" for="radio2">--}}
                        {{--                                    <span><img--}}
                        {{--                                            src="{{url('img/payments', auth()->user()->dark_mode == 'off' ? 'payoneer.png' : 'payoneer-white.png')}}"--}}
                        {{--                                            width="110" alt=""/></span>--}}
                        {{--                                    <small--}}
                        {{--                                        class="w-100 d-block">* {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.processor_fees_may_apply'), config("app.locale"))}}</small>--}}
                        {{--                                </label>--}}
                        {{--                            </div>--}}

                        {{--                            <form method="POST" action="{{ url('settings/payout/method/payoneer') }}" id="Payoneer"--}}
                        {{--                                  @if (auth()->user()->payment_gateway != 'Payoneer') class="display-none" @endif>--}}
                        {{--                                @csrf--}}

                        {{--                                <div class="form-group">--}}
                        {{--                                    <div class="input-group mb-4">--}}
                        {{--                                        <div class="input-group-prepend">--}}
                        {{--                                            <span class="input-group-text"><i class="far fa-envelope"></i></span>--}}
                        {{--                                        </div>--}}
                        {{--                                        <input class="form-control" name="email_payoneer"--}}
                        {{--                                               value="{{auth()->user()->payoneer_account == '' ? old('email_payoneer') : auth()->user()->payoneer_account}}"--}}
                        {{--                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.email_payoneer'), config("app.locale"))}}"--}}
                        {{--                                               required type="email">--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}

                        {{--                                <div class="form-group">--}}
                        {{--                                    <div class="input-group mb-4">--}}
                        {{--                                        <div class="input-group-prepend">--}}
                        {{--                                            <span class="input-group-text"><i class="far fa-envelope"></i></span>--}}
                        {{--                                        </div>--}}
                        {{--                                        <input class="form-control" name="email_payoneer_confirmation"--}}
                        {{--                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.confirm_email_payoneer'), config("app.locale"))}}"--}}
                        {{--                                               required type="email">--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <button class="btn btn-1 btn-success btn-block"--}}
                        {{--                                        type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.save_payout_method'), config("app.locale"))}}</button>--}}
                        {{--                            </form>--}}
                        {{--                            <!--============ END PAYONEER ============-->--}}
                        {{--                        @endif--}}

                        @if( $settings->payout_method_zelle == 'on' )
                        <!--============ START ZELLE ============-->
                            <div class="custom-control custom-radio mb-3 mt-3">
                                <input name="payment_gateway" value="CinetPay" id="radio3" class="custom-control-input"
                                       @if (auth()->user()->payment_gateway == 'CinetPay') checked @endif type="radio">
                                <label class="custom-control-label" for="radio3">
                                                            <span><img
                                                                    src="{{ url('img/payments/cinetpay.png') }}"
                                                                    width="50" alt=""/></span>
                                    <small
                                        class="w-100 d-block">* {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.processor_fees_may_apply'), config("app.locale"))}}</small>
                                </label>
                            </div>

                            <form method="POST" action="{{ route("payout.method-type", "cinetpay") }}" id="CinetPay"
                                  @if (auth()->user()->payment_gateway != 'CinetPay') class="display-none" @endif>
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                        </div>
                                        <input class="form-control" name="phone_indicative" value="{{auth()->user()->cinetpay_number_indicative == '' ? old('cinetpay_number_indicative') : auth()->user()->cinetpay_number_indicative}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans("Phone indicative ex: 228", config("app.locale"))}}"
                                               required type="number">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" name="phone_cinetpay"
                                        value="{{auth()->user()->cinetpay_number == '' ? old('cinetpay_number') : auth()->user()->cinetpay_number}}"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans("phone number", config("app.locale"))}}"
                                               required type="number">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" name="phone_cinetpay_confirmation"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans("Confirm phone number", config("app.locale"))}}"
                                               required type="number">
                                    </div>
                                </div>
                                <button class="btn btn-1 btn-success btn-block"
                                        type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.save_payout_method'), config("app.locale"))}}</button>
                            </form>
                            <!--============ END ZELLE ============-->
                        @endif

                        @if( $settings->payout_method_bank == 'on' )
                        <!--============ START BANK TRANSFER ============-->
                            <div class="custom-control custom-radio mb-3 mt-3">
                                <input name="payment_gateway" value="Bank" id="radio4" class="custom-control-input"
                                       @if (auth()->user()->payment_gateway == 'Bank') checked @endif type="radio">
                                <label class="custom-control-label" for="radio4">
                                    <span><strong><i class="fa fa-university mr-1 icon-sm-radio"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.bank_transfer'), config("app.locale"))}}</strong></span>
                                    <small
                                        class="w-100 d-block">* {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.processor_fees_may_apply'), config("app.locale"))}}</small>
                                </label>
                            </div>

                            <form method="POST" action="{{ url('settings/payout/method/bank') }}" id="Bank"
                                  @if (auth()->user()->payment_gateway != 'Bank') class="display-none" @endif>

                                @csrf
                                <div class="form-group">
                                    <textarea name="bank_details" rows="5" cols="40" class="form-control" required
                                              placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.bank_details'), config("app.locale"))}}">{{auth()->user()->bank == '' ? old('bank_details') : auth()->user()->bank}}</textarea>
                                </div>

                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <i class="fa fa-info-circle mr-2"></i>
                                    <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.bank_details'), config("app.locale"))}}</span>
                                </div>

                                <button class="btn btn-1 btn-success btn-block"
                                        type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.save_payout_method'), config("app.locale"))}}</button>
                            </form>
                            <!--============ END BANK TRANSFER ============-->
                        @endif

                    @endif

                    @if (auth()->user()->verified_id == 'yes'
                        && $settings->stripe_connect
                        && isset(auth()->user()->country()->country_code)
                        && in_array(auth()->user()->country()->country_code, $stripeConnectCountries)
                        )

                        <h6 class="mt-5">Stripe Connect @if (auth()->user()->completed_stripe_onboarding) <span
                                class="badge badge-pill badge-success font-weight-light opacity-75">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.connected'), config("app.locale")) }}</span> @else
                                <span
                                    class="badge badge-pill badge-danger font-weight-light opacity-75">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.not_connected'), config("app.locale")) }}</span>  @endif
                        </h6>
                        <small
                            class="d-block w-100 mb-3">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.stripe_connect_desc'), config("app.locale")) }}</small>


                        <a href="{{ route('redirect.stripe') }}" class="btn w-100 btn-lg btn-primary btn-arrow">

                            @if (! auth()->user()->completed_stripe_onboarding)
                                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.connect_stripe_account'), config("app.locale")) }}

                            @else
                                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.view_stripe_account'), config("app.locale")) }}
                            @endif
                        </a>

                    @endif

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script type="text/javascript">

        $('input[name=payment_gateway]').on('click', function () {
            console.log($(this).val())

            if ($(this).val() === 'PayPal') {
                $('#PayPal').slideDown();
            } else {
                $('#PayPal').slideUp();
            }

            if ($(this).val() === 'CinetPay') {
                $('#CinetPay').slideDown();
            } else {
                $('#CinetPay').slideUp();
            }

            if ($(this).val() === 'Zelle') {
                $('#Zelle').slideDown();
            } else {
                $('#Zelle').slideUp();
            }

            if ($(this).val() === 'Bank') {
                $('#Bank').slideDown();
            } else {
                $('#Bank').slideUp();
            }

        });
    </script>
@endsection