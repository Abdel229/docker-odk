@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.purchased_items'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi-bag-check mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.purchased_items'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.purchased_items_subtitle'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if ($purchases->count() != 0)

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
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.item'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.type'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.delivery_status'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.price'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale"))}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td>
                                                <a href="{{url('shop/product', $purchase->products()->id)}}">
                                                    {{ Str::limit($purchase->products()->name, 25, '...') }}
                                                </a>
                                            </td>
                                            <td>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($purchase->products()->type == 'digital' ? __('general.digital_download') : __('general.custom_content'), config("app.locale")) }}</td>
                                            <td>
                                                @if ($purchase->delivery_status == 'delivered')
                                                    <span
                                                        class="badge badge-pill badge-success text-uppercase">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delivered'), config("app.locale")) }}</span>

                                                @else
                                                    <span
                                                        class="badge badge-pill badge-warning text-uppercase">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.pending'), config("app.locale")) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ Helper::amountFormatDecimal($purchase->transactions()->amount) }}</td>
                                            <td>{{Helper::formatDate($purchase->created_at)}}</td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- card -->

                        @if ($purchases->hasPages())
                            <div class="mt-2">
                                {{ $purchases->onEachSide(0)->links() }}
                            </div>
                        @endif

                    @else
                        <div class="my-5 text-center">
            <span class="btn-block mb-3">
              <i class="bi-bag-x ico-no-result"></i>
            </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_results_found'), config("app.locale"))}}</h4>
                        </div>
                    @endif

                </div><!-- end col-md-6 -->
            </div>
        </div>
    </section>
@endsection
