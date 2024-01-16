@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.referrals'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi bi-person-plus mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.referrals'), config("app.locale"))}}
                    </h2>

                    @if ($settings->referral_system == 'on')

                        <p class="lead text-muted mt-0">
                            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.referrals_welcome_desc', ['percentage' => $settings->percentage_referred]), config("app.locale"))}}
                            <small class="d-block">
                                @if ($settings->referral_transaction_limit <> 'unlimited')
                                    * {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans_choice('general.total_transactions_per_referral', $settings->referral_transaction_limit, ['percentage' => $settings->percentage_referred, 'total' => $settings->referral_transaction_limit]), config("app.locale")) }}
                                @else
                                    * {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.total_transactions_referral_unlimited', ['percentage' => $settings->percentage_referred]), config("app.locale"))}}
                                @endif

                            </small>
                        </p>

                        <button class="d-none copy-url" id="copyLink"
                                data-clipboard-text="{{ url('/?ref='.auth()->user()->id) }}"></button>
                        <span>
              <span
                  class="text-muted">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.your_referral_link'), config("app.locale")) }}</span>

              <span class="text-break"><strong>{{ url('/?ref='.auth()->user()->id) }}</strong></span>

              <button class="btn btn-link e-none p-1 text-decoration-none" data-toggle="tooltip" data-placement="top"
                      title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.copy_link'), config("app.locale"))}}"
                      onclick="$('#copyLink').trigger('click')">
  							<i class="far fa-clone"></i>
  						</button>
            </span>
                    @else
                        <div class="alert alert-danger mt-3">
          <span class="alert-inner--text">
            <i class="fa fa-exclamation-triangle mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.referral_system_disabled'), config("app.locale")) }}
          </span>
                        </div>
                    @endif

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
                                            <i class="fas fa-users mr-2 text-primary icon-dashboard"></i> {{ number_format(auth()->user()->referrals()->count()) }}
                                        </h4>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.total_registered_users'), config("app.locale")) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>
                                            <i class="fa fa-receipt mr-2 text-primary icon-dashboard"></i> {{ number_format(auth()->user()->referralTransactions()->count()) }}
                                        </h4>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.total_transactions'), config("app.locale")) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>
                                            <i class="fas fa-hand-holding-usd mr-2 text-primary icon-dashboard"></i> {{ Helper::amountFormatDecimal(auth()->user()->referralTransactions()->sum('earnings')) }}
                                        </h4>
                                        <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.earnings_total'), config("app.locale")) }}</small>
                                    </div>
                                </div><!-- card 1 -->
                            </div><!-- col-lg-4 -->

                            <div class="col-lg-12 mt-3 py-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mb-4">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.transactions'), config("app.locale")) }}</h4>

                                        <div class="table-responsive">
                                            <table class="table table-striped m-0">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.type'), config("app.locale"))}}</th>
                                                    <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale"))}}</th>
                                                    <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.earnings'), config("app.locale"))}}</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                @if ($transactions->count() != 0)
                                                    @foreach ($transactions as $referred)
                                                        <tr>
                                                            <td>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.'.$referred->type), config("app.locale")) }}</td>
                                                            <td>{{ Helper::formatDate($referred->created_at) }}</td>
                                                            <td>{{ Helper::amountFormatDecimal($referred->earnings) }}</td>
                                                        </tr>
                                                    @endforeach

                                                @else
                                                    <tr>
                                                        <td>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_transactions_yet'), config("app.locale")) }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- card -->

                                @if ($transactions->hasPages())
                                    {{ $transactions->links() }}
                                @endif

                            </div><!-- col-lg-12 -->

                        </div><!-- end row -->
                    </div><!-- end content -->

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection
