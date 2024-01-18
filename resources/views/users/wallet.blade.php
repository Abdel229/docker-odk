@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.wallet'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="iconmoon icon-Wallet mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.wallet'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.wallet_desc'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if (session('error_message'))
                        <div class="alert alert-danger mb-3">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('error_message'), config("app.locale")) }}
                        </div>
                    @endif

                    @if (session('success_message'))
                        <div class="alert alert-success mb-3">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('success_message'), config("app.locale")) }}
                        </div>
                    @endif

                    <div class="alert alert-primary shadow overflow-hidden" role="alert">

                        <div class="inner-wrap">
              <span>
                <h2><strong>{{ Helper::userWallet() }}</strong>
                  <small
                      class="h5">{{ $settings->wallet_format == 'real_money' ? $settings->currency_code : null}}</small>
                </h2>

                <span class="w-100 d-block">
                {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.funds_available'), config("app.locale"))}}
                </span>

                @if ($equivalent_money)
                      <span>
                    <strong>{{ $equivalent_money }}</strong>
                  </span>
                  @endif

              </span>
                        </div>

                        <span class="icon-wrap"><i class="iconmoon icon-Wallet"></i></span>

                    </div><!-- /alert -->

                    <form method="POST" action="{{ route("add.funds") }}" id="formAddFunds">

                        @csrf

                        <div class="form-group mb-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{$settings->currency_symbol}}</span>
                                </div>
                                <input class="form-control form-control-lg" id="onlyNumber" name="amount"  type="number"
                                       min="{{ $settings->min_deposits_amount }}"
                                       max="{{ $settings->max_deposits_amount }}" autocomplete="off"
                                       placeholder='{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans("admin.amount"), config("app.locale"))}} ({{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__("general.minimum"), config("app.locale")) }} {{ Helper::amountWithoutFormat($settings->min_deposits_amount) }} - {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__("general.maximum"), config("app.locale")) }} {{ Helper::amountWithoutFormat($settings->max_deposits_amount) }})'
                                      >
                            </div>

                            <p class="help-block margin-bottom-zero fee-wrap">

                <span class="d-block w-100">
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.transaction_fee'), config("app.locale")) }}:

                <span class="float-right"><strong>{{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}<span
                            id="handlingFee">0</span>{{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}</strong></span>
              </span><!-- end transaction fee -->

                                @if (auth()->user()->isTaxable()->count() && $settings->tax_on_wallet)

                                    @php
                                        $number = 0;
                                    @endphp

                                    @foreach (auth()->user()->isTaxable() as $tax)

                                        @php
                                            $number++;
                                        @endphp

                                        <span
                                            class="d-block w-100 isTaxableWallet percentageAppliedTaxWallet{{$number}}"
                                            data="{{ $tax->percentage }}">
                  {{ $tax->name }} {{ $tax->percentage }}%:

                  <span class="float-right">
                  <strong>{{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}<span
                          class="percentageTax{{$number}}">0</span>{{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}</strong>
                </span>
              </span>
                                    @endforeach

                                @endif

                                <span class="d-block w-100">
                  {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.total'), config("app.locale")) }}:

                  <span class="float-right">
                  <strong>{{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}<span
                          id="total">0</span>{{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}</strong>
                </span>
              </span><!-- end total -->
                            </p>

                        </div><!-- End form-group -->

                        @foreach (PaymentGateways::where('enabled', '1')->orderBy('type', 'DESC')->get() as $payment)

                            @php

                                if ($payment->type == 'card' ) {
                                  $paymentName = '<i class="far fa-credit-card mr-1 icon-sm-radio"></i> '.\Stichoza\GoogleTranslate\GoogleTranslate::trans( trans('general.debit_credit_card'), config("app.locale")) .' ('.$payment->name.')';
                                } elseif ($payment->type == 'bank') {
                                  $paymentName = '<i class="fa fa-university mr-1 icon-sm-radio"></i> '.\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.bank_transfer'), config("app.locale"));
                                } else if ($payment->name == 'PayPal') {
                                  $paymentName = '<img src="'.url('img/payments', auth()->user()->dark_mode == 'off' ? $payment->logo : 'paypal-white.png').'" width="70"/>';
                                } else if ($payment->name == 'Coinpayments') {
                                  $paymentName = '<img src="'.url('img/payments', auth()->user()->dark_mode == 'off' ? $payment->logo : 'coinpayments-white.png').'" width="150"/>';
                                } else if ($payment->name == 'Mercadopago') {
                                  $paymentName = '<img src="'.url('img/payments', auth()->user()->dark_mode == 'off' ? $payment->logo : 'mercadopago-white.png').'" width="100"/>';
                                } else if ($payment->name == 'Flutterwave') {
                                  $paymentName = '<img src="'.url('img/payments', auth()->user()->dark_mode == 'off' ? $payment->logo : 'flutterwave-white.png').'" width="150"/>';
                                } else if ($payment->name == 'Mollie') {
                                  $paymentName = '<img src="'.url('img/payments', auth()->user()->dark_mode == 'off' ? $payment->logo : 'mollie-white.png').'" width="80"/>';
                                } else if ($payment->name == 'Razorpay') {
                                  $paymentName = '<img src="'.url('img/payments', auth()->user()->dark_mode == 'off' ? $payment->logo : 'razorpay-white.png').'" width="110"/>';
                                } else {
                                  $paymentName = '<img src="'.url('img/payments', $payment->logo).'" width="100"/>';
                                }

                            @endphp
                            <div class="custom-control custom-radio mb-3">
                                <input name="payment_gateway" value="{{$payment->name}}"
                                       id="tip_radio{{$payment->name}}"
                                       @if (PaymentGateways::where('enabled', '1')->count() == 1) checked
                                       @endif class="custom-control-input" type="radio">
                                <label class="custom-control-label" for="tip_radio{{$payment->name}}">
                                    <span><strong>{!!$paymentName!!}</strong></span>
                                    <small
                                        class="w-100 d-block">* {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.transaction_fee'), config("app.locale")) }}
                                        : {{ $payment->fee }}
                                        % {{ $payment->fee_cents != 0.00 ? '+ '. $payment->fee_cents : null }}</small>
                                </label>
                            </div>

                            @if ($payment->type == 'bank')

                                <div
                                    class="btn-block @if (PaymentGateways::where('enabled', '1')->count() != 1) display-none @endif"
                                    id="bankTransferBox">
                                    <div class="alert alert-default border">
                                        <h5 class="font-weight-bold"><i
                                                class="fa fa-university mr-1 icon-sm-radio"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.make_payment_bank'), config("app.locale"))}}
                                        </h5>
                                        <ul class="list-unstyled">
                                            <li>
                                                {!!nl2br($payment->bank_info)!!}

                                                <hr/>
                                                <span class="d-block w-100 mt-2">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.total'), config("app.locale")) }}: <strong>{{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}<span
                                                            id="total2">0</span>{{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}</strong>
                        <span>

                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mb-3 text-center">
                                        <span class="btn-block mb-2" id="previewImage"></span>

                                        <input type="file" name="image" id="fileBankTransfer" accept="image/*"
                                               class="visibility-hidden">
                                        <button class="btn btn-1 btn-block btn-outline-primary mb-2 border-dashed"
                                                onclick="$('#fileBankTransfer').trigger('click');" type="button"
                                                id="btnFilePhoto">{{trans('general.upload_image')}} (JPG, PNG,
                                            GIF) {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.maximum'), config("app.locale"))}}
                                            : {{Helper::formatBytes($settings->file_size_allowed_verify_account * 1024)}}</button>

                                        <small
                                            class="text-muted btn-block">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_bank_transfer'), config("app.locale"))}}</small>
                                    </div>
                                </div><!-- Alert -->
                            @endif

                        @endforeach

                        <div class="alert alert-danger display-none" id="errorAddFunds">
                            <ul class="list-unstyled m-0" id="showErrorsFunds"></ul>
                        </div>

                        <button class="btn btn-1 btn-success btn-block mt-4" id="addFundsBtn" type="submit">
                            <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.add_funds'), config("app.locale"))}}
                        </button>
                    </form>

                    @if ($data->count() != 0)
                        <h6 class="text-center mt-5 font-weight-light">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.history_deposits'), config("app.locale")) }}</h6>

                        <div class="card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-striped m-0">
                                    <thead>
                                    <th scope="col">ID</th>
                                    <th scope="col">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.amount'), config("app.locale")) }}</th>
                                    <th scope="col">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payment_gateway'), config("app.locale")) }}</th>
                                    <th scope="col">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale")) }}</th>
                                    <th scope="col">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.status'), config("app.locale")) }}</th>
                                    <th> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.invoice'), config("app.locale"))}}</th>
                                    </thead>

                                    <tbody>
                                    @foreach ($data as $deposit)

                                        <tr>
                                            <td>{{ str_pad($deposit->id, 4, "0", STR_PAD_LEFT) }}</td>
                                            <td>{{ App\Helper::amountFormat($deposit->amount) }}</td>
                                            <td>{{ $deposit->payment_gateway == 'Bank Transfer' || $deposit->payment_gateway == 'Bank' ? \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.bank_transfer'), config("app.locale")) : $deposit->payment_gateway }}</td>
                                            <td>{{ date('d M, Y', strtotime($deposit->date)) }}</td>

                                            @php

                                                if ($deposit->status == 'pending' ) {
                                                             $mode    = 'warning';
                                                                       $_status = \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.pending'), config("app.locale"));
                                                    } else {
                                                      $mode = 'success';
                                                                       $_status = \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.success'), config("app.locale"));
                                                    }

                                            @endphp

                                            <td><span
                                                    class="badge badge-pill badge-{{$mode}} text-uppercase">{{ $_status }}</span>
                                            </td>

                                            <td>
                                                @if ($deposit->status == 'active')
                                                    <a href="{{url('deposits/invoice', $deposit->id)}}" target="_blank"><i
                                                            class="far fa-file-alt"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.invoice'), config("app.locale"))}}
                                                    </a>
                                            </td>
                                            @else
                                                {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_available'), config("app.locale"))}}
                                            @endif
                                        </tr><!-- /.TR -->
                                    @endforeach
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->
                        </div><!-- card -->
                        <small
                            class="w-100 d-block mt-2">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.transaction_fee_info'), config("app.locale")) }}</small>

                        @if ($data->hasPages())
                            <div class="mt-3">
                                {{ $data->links() }}
                            </div>
                        @endif

                    @endif

                </div><!-- end col-md-6 -->
            </div>
        </div>
    </section>
@endsection

@section('javascript')

    <script type="text/javascript">
        @if($settings->currency_code == 'JPY')
            $decimal = 0;
        @else
            $decimal = 2;
        @endif

        function toFixed(number, decimals) {
            var x = Math.pow(10, Number(decimals) + 1);
            return (Number(number) + (1 / x)).toFixed(decimals);
        }

        $('input[name=payment_gateway]').on('click', function () {

            var valueOriginal = $('#onlyNumber').val();
            var value = parseFloat($('#onlyNumber').val());
            var element = $(this).val();

            //==== Start Taxes
            var taxes = $('span.isTaxableWallet').length;
            var totalTax = 0;

            if (valueOriginal.length == 0
                || valueOriginal == ''
                || value < {{ $settings->min_deposits_amount }}
                || value > {{$settings->max_deposits_amount}}
            ) {
                // Reset
                for (var i = 1; i <= taxes; i++) {
                    $('.percentageTax' + i).html('0');
                }
                $('#handlingFee, #total, #total2').html('0');
            } else {
                // Taxes
                for (var i = 1; i <= taxes; i++) {
                    var percentage = $('.percentageAppliedTaxWallet' + i).attr('data');
                    var valueFinal = (value * percentage / 100);
                    $('.percentageTax' + i).html(toFixed(valueFinal, $decimal));
                    totalTax += valueFinal;
                }
                var totalTaxes = (Math.round(totalTax * 100) / 100).toFixed(2);
            }
            //==== End Taxes

            if (element != ''
                && value <= {{ $settings->max_deposits_amount }}
                && value >= {{ $settings->min_deposits_amount }}
                && valueOriginal != ''
            ) {
                // Fees
                switch (element) {
                    @foreach (PaymentGateways::where('enabled', '1')->get(); as $payment)
                    case '{{$payment->name}}':
                        $fee = {{$payment->fee}};
                        $cents = {{$payment->fee_cents}};
                        break;
                    @endforeach
                }

                var amount = (value * $fee / 100) + $cents;
                var amountFinal = toFixed(amount, $decimal);

                var total = (parseFloat(value) + parseFloat(amountFinal) + parseFloat(totalTaxes));

                if (valueOriginal.length != 0
                    || valueOriginal != ''
                    || value >= {{ $settings->min_deposits_amount }}
                    || value <= {{$settings->max_deposits_amount}}
                ) {
                    $('#handlingFee').html(amountFinal);
                    $('#total, #total2').html(total.toFixed($decimal));
                }
            }

        });

        //<-------- * TRIM * ----------->

        $('#onlyNumber').on('keyup', function () {

            var valueOriginal = $(this).val();
            var value = parseFloat($(this).val());
            var paymentGateway = $('input[name=payment_gateway]:checked').val();

            if (value > {{ $settings->max_deposits_amount }} || valueOriginal.length == 0) {
                $('#handlingFee').html('0');
                $('#total, #total2').html('0');
            }

            //==== Start Taxes
            var taxes = $('span.isTaxableWallet').length;
            var totalTax = 0;

            if (valueOriginal.length == 0
                || valueOriginal == ''
                || value < {{ $settings->min_deposits_amount }}
                || value > {{$settings->max_deposits_amount}}
            ) {
                // Reset
                for (var i = 1; i <= taxes; i++) {
                    $('.percentageTax' + i).html('0');
                }
                $('#handlingFee, #total, #total2').html('0');
            } else {
                // Taxes
                for (var i = 1; i <= taxes; i++) {
                    var percentage = $('.percentageAppliedTaxWallet' + i).attr('data');
                    var valueFinal = (value * percentage / 100);
                    $('.percentageTax' + i).html(toFixed(valueFinal, $decimal));
                    totalTax += valueFinal;
                }
                var totalTaxes = (Math.round(totalTax * 100) / 100).toFixed(2);
            }
            //==== End Taxes

            if (paymentGateway
                && value <= {{ $settings->max_deposits_amount }}
                && value >= {{ $settings->min_deposits_amount }}
                && valueOriginal != ''
            ) {

                switch (paymentGateway) {
                    @foreach (PaymentGateways::where('enabled', '1')->get(); as $payment)
                    case '{{$payment->name}}':
                        $fee = {{$payment->fee}};
                        $cents = {{$payment->fee_cents}};
                        break;
                    @endforeach
                }

                var amount = (value * $fee / 100) + $cents;
                var amountFinal = toFixed(amount, $decimal);

                var total = (parseFloat(value) + parseFloat(amountFinal) + parseFloat(totalTaxes));

                if (valueOriginal.length != 0
                    || valueOriginal != ''
                    || value >= {{ $settings->min_deposits_amount }}
                    || value <= {{$settings->max_deposits_amount}}
                ) {
                    $('#handlingFee').html(amountFinal);
                    $('#total, #total2').html(total.toFixed($decimal));
                } else {
                    $('#handlingFee, #total, #total2').html('0');
                }
            }
        });

        @if (session('payment_process'))
        swal({
            html: true,
            title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.congratulations'), config("app.locale")) }}",
            text: "{!! \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payment_process_wallet'), config("app.locale")) !!}",
            type: "success",
            confirmButtonText: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
        });
        @endif

    </script>
@endsection
