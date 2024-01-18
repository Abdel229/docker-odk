@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscriptions'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="feather icon-user-check mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscriptions'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscriptions_subtitle'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if ($subscriptions->count() != 0)

                        @if (session('message'))
                            <div class="alert alert-success mb-3">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                                </button>
                                <i class="fa fa-check mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('message'), config("app.locale")) }}
                            </div>
                        @endif

                        @if (session('error_message'))
                            <div class="alert alert-danger mb-3">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                                </button>
                                <i class="fa fa-check mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('error_message'), config("app.locale")) }}
                            </div>
                        @endif

                        <div class="card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.subscribed'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.interval'), config("app.locale"))}}</th>
                                        <th scope="col">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.ends_at'), config("app.locale")) }}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.status'), config("app.locale"))}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($subscriptions as $subscription)
                                        <tr>
                                            <td>
                                                @if (! isset($subscription->subscribed()->username))
                                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_available'), config("app.locale")) }}
                                                @else
                                                    <a href="{{url($subscription->subscribed()->username)}}">
                                                        <img
                                                            src="{{Helper::getFile(config('path.avatar').$subscription->subscribed()->avatar)}}"
                                                            width="40" height="40" class="rounded-circle mr-2" alt="">
                                                        {{$subscription->subscribed()->hide_name == 'yes' ? $subscription->subscribed()->username : $subscription->subscribed()->name}}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{Helper::formatDate($subscription->created_at)}}</td>
                                            <td>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($subscription->free == 'yes'? trans('general.not_applicable') : trans('general.'.$subscription->interval), config("app.locale"))}}</td>
                                            <td>
                                                @if ($subscription->ends_at)
                                                    {{Helper::formatDate($subscription->ends_at)}}
                                                @elseif ($subscription->free == 'yes')
                                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.free_subscription'), config("app.locale")) }}
                                                @else
                                                    {{Helper::formatDate(auth()->user()->subscription('main', $subscription->stripe_price)->asStripeSubscription()->current_period_end, true)}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($subscription->stripe_id == ''
                                                  && strtotime($subscription->ends_at) > strtotime(now()->format('Y-m-d H:i:s'))
                                                  && $subscription->cancelled == 'no'
                                                    || $subscription->stripe_id != '' && $subscription->stripe_status == 'active'
                                                    || $subscription->stripe_id == '' && $subscription->free == 'yes'
                                                  )
                                                    <span
                                                        class="badge badge-pill badge-success text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.active'), config("app.locale"))}}</span>
                                                    <br>

                                                @elseif ($subscription->stripe_id != '' && $subscription->stripe_status == 'incomplete')
                                                    <span
                                                        class="badge badge-pill badge-warning text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.incomplete'), config("app.locale"))}}</span>
                                                    <br>

                                                    <a class="badge badge-pill badge-success text-uppercase"
                                                       href="{{ route('cashier.payment', $subscription->last_payment) }}">
                                                        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.confirm_payment'), config("app.locale"))}}
                                                    </a>

                                                @else
                                                    <span
                                                        class="badge badge-pill badge-danger text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.cancelled'), config("app.locale"))}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- card -->

                        @if ($subscriptions->hasPages())
                            {{ $subscriptions->links() }}
                        @endif

                    @else
                        <div class="my-5 text-center">
            <span class="btn-block mb-3">
              <i class="feather icon-user-check ico-no-result"></i>
            </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.not_subscribed'), config("app.locale"))}}
                                <a href="{{url('creators')}}"
                                   class="font-weight-900 link-border">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore_creators'), config("app.locale"))}}</a>
                            </h4>
                        </div>
                    @endif

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection
