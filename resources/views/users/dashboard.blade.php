@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.dashboard'), config('app.locale'))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi bi-speedometer2 mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.dashboard'), config('app.locale'))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.dashboard_desc'), config('app.locale'))}}</p>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-12 mb-5 mb-lg-0">

                    <div class="content">
                        <div class="row">
                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>
                                            <i class="fas fa-hand-holding-usd mr-2 text-primary icon-dashboard"></i> {{ Helper::amountFormatDecimal($earningNetUser) }}
                                        </h4>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.earnings_net'), config('app.locale')) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>
                                            <i class="fas fa-wallet mr-2 text-primary icon-dashboard"></i> {{ Helper::amountFormatDecimal(Auth::user()->balance) }}
                                        </h4>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.balance'), config('app.locale')) }}
                                            @if (Auth::user()->balance >= $settings->amount_min_withdrawal)
                                                <a href="{{ url('settings/withdrawals')}}"
                                                   class="link-border"> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.make_withdrawal'), config('app.locale')) }}</a>
                                            @endif
                                        </small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h4><i class="fas fa-users mr-2 text-primary icon-dashboard"></i> <span
                                                title="{{$subscriptionsActive}}">{{ Helper::formatNumber($subscriptionsActive) }}</span>
                                        </h4>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.subscriptions_active'), config('app.locale')) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="{{$stat_revenue_today > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ Helper::amountFormatDecimal($stat_revenue_today) }}
                                            <small class="float-right ml-2">
                                                <i class="bi bi-question-circle text-muted" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.compared_yesterday'), config('app.locale')) }}"></i>
                                            </small>
                                            {!! Helper::PercentageIncreaseDecrease($stat_revenue_today, $stat_revenue_yesterday) !!}
                                        </h6>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.revenue_today'), config('app.locale')) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="{{$stat_revenue_week > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ Helper::amountFormatDecimal($stat_revenue_week) }}
                                            <small class="float-right ml-2">
                                                <i class="bi bi-question-circle text-muted" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.compared_last_week'), config('app.locale')) }}"></i>
                                            </small>
                                            {!! Helper::PercentageIncreaseDecrease($stat_revenue_week, $stat_revenue_last_week) !!}
                                        </h6>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.revenue_week'), config('app.locale')) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="{{$stat_revenue_month > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ Helper::amountFormatDecimal($stat_revenue_month) }}
                                            <small class="float-right ml-2">
                                                <i class="bi bi-question-circle text-muted" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.compared_last_month'), config('app.locale')) }}"></i>
                                            </small>
                                            {!! Helper::PercentageIncreaseDecrease($stat_revenue_month, $stat_revenue_last_month) !!}
                                        </h6>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.revenue_month'), config('app.locale')) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-12 mt-3 py-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mb-4">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.earnings_this_month'), config('app.locale')) }}
                                            ({{ $month }})</h4>
                                        <div style="height: 350px">
                                            <canvas id="Chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end row -->
                    </div><!-- end content -->

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>

    <script type="text/javascript">

        function decimalFormat(nStr) {
            @if ($settings->decimal_format == 'dot')
                $decimalDot = '.';
            $decimalComma = ',';
            @else
                $decimalDot = ',';
            $decimalComma = '.';
            @endif

                @if ($settings->currency_position == 'left')
                currency_symbol_left = '{{$settings->currency_symbol}}';
            currency_symbol_right = '';
            @else
                currency_symbol_right = '{{$settings->currency_symbol}}';
            currency_symbol_left = '';
            @endif

                nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? $decimalDot + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + $decimalComma + '$2');
            }
            return currency_symbol_left + x1 + x2 + currency_symbol_right;
        }

        function transparentize(color, opacity) {
            var alpha = opacity === undefined ? 0.5 : 1 - opacity;
            return Color(color).alpha(alpha).rgbString();
        }

        var init = document.getElementById("Chart").getContext('2d');

        const gradient = init.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, '{{$settings->color_default}}');
        gradient.addColorStop(1, '{{$settings->color_default}}2b');

        const lineOptions = {
            pointRadius: 4,
            pointHoverRadius: 6,
            hitRadius: 5,
            pointHoverBorderWidth: 3
        }

        var ChartArea = new Chart(init, {
            type: 'line',
            data: {
                labels: [{!!$label!!}],
                datasets: [{
                    label: '{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.earnings'), config('app.locale'))}}',
                    backgroundColor: gradient,
                    borderColor: '{{$settings->color_default}}',
                    data: [{!!$data!!}],
                    borderWidth: 2,
                    fill: true,
                    lineTension: 0.4,
                    ...lineOptions
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0, // it is for ignoring negative step.
                            display: true,
                            maxTicksLimit: 8,
                            padding: 10,
                            beginAtZero: true,
                            callback: function (value, index, values) {
                                return '@if($settings->currency_position == 'left'){{ $settings->currency_symbol }}@endif' + value + '@if($settings->currency_position == 'right'){{ $settings->currency_symbol }}@endif';
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        display: true,
                        ticks: {
                            maxTicksLimit: 15,
                            padding: 5,
                        }
                    }]
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    reverse: true,
                    backgroundColor: '#000',
                    xPadding: 16,
                    yPadding: 16,
                    cornerRadius: 4,
                    caretSize: 7,
                    callbacks: {
                        label: function (t, d) {
                            var xLabel = d.datasets[t.datasetIndex].label;
                            var yLabel = t.yLabel == 0 ? decimalFormat(t.yLabel) : decimalFormat(t.yLabel.toFixed(2));
                            return xLabel + ': ' + yLabel;
                        }
                    },
                },
                hover: {
                    mode: 'index',
                    intersect: false
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
