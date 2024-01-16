@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.sales'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi-cart2 mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.sales'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.sales_your_products'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if ($sales->count() != 0)

                        <div class="btn-block mb-3 text-right">
                <span>
                  {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.filter_by'), config("app.locale"))}}

                  <select class="ml-2 custom-select w-auto" id="filter">
                      <option @if (! request()->get('sort')) selected
                              @endif value="{{url('my/sales')}}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.latest'), config("app.locale"))}}</option>
                        <option @if (request()->get('sort') == 'oldest') selected
                                @endif value="{{url('my/sales')}}?sort=oldest">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.oldest'), config("app.locale"))}}</option>
                      <option @if (request()->get('sort') == 'pending') selected
                              @endif value="{{url('my/sales')}}?sort=pending">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.pending'), config("app.locale"))}}</option>
                    </select>
                </span>
                        </div>

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
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.buyer'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.delivery_status'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.price'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.actions'), config("app.locale"))}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>
                                                <a href="{{url('shop/product', $sale->products()->id)}}">
                                                    {{ Str::limit($sale->products()->name, 25, '...') }}
                                                </a>
                                            </td>
                                            <td>
                                                @if (! isset($sale->user()->username))
                                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_available'), config("app.locale")) }}
                                                @else
                                                    <a href="{{ url($sale->user()->username) }}">{{ '@'.$sale->user()->username }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($sale->delivery_status == 'delivered')
                                                    <span
                                                        class="badge badge-pill badge-success text-uppercase">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delivered'), config("app.locale")) }}</span>

                                                @else
                                                    <span
                                                        class="badge badge-pill badge-warning text-uppercase">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.pending'), config("app.locale")) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ Helper::amountFormatDecimal($sale->transactions()->amount) }}</td>
                                            <td>{{Helper::formatDate($sale->created_at)}}</td>

                                            <td>
                                                @if ($sale->products()->type == 'product' || $sale->products()->type == 'custom')
                                                    <div class="d-flex">

                                                        <a title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.see_details'), config("app.locale")) }}"
                                                           class="d-inline-block mr-2 btn btn-primary btn-sm-custom"
                                                           data-toggle="modal"
                                                           data-target="#customContentForm{{$sale->id}}" href="#">
                                                            <i class="bi-eye"></i>
                                                        </a>

                                                        @if ($sale->delivery_status == 'pending')

                                                             @if($sale->products()->type != "product")

                                                                <form class="d-inline-block" method="post"
                                                                    action="{{url('delivered/product', $sale->id)}}">
                                                                    @csrf
                                                                    <button
                                                                        title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.mark_as_delivered'), config("app.locale")) }}"
                                                                        class="mr-2 btn btn-success btn-sm-custom actionAcceptRejectOrder acceptOrder"
                                                                        type="button">
                                                                        <i class="bi-check"></i>
                                                                    </button>
                                                                </form>




                                                            @else


                                                                <a title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.see_details'), config("app.locale")) }}"
                                                                    class="d-inline-block mr-2 btn btn-success btn-sm-custom"
                                                                    data-toggle="modal"
                                                                    data-target="#productDeliveryContentForm{{$sale->id}}" href="#">
                                                                        <i class="bi-check"></i>
                                                                </a>


                                                            @endif
                                                            <form class="d-inline-block" method="post"
                                                                  action="{{ url('reject/order', $sale->id) }}">
                                                                @csrf
                                                                <button
                                                                    title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.reject'), config("app.locale")) }}"
                                                                    class="btn btn-danger btn-sm-custom actionAcceptRejectOrder rejectOrder"
                                                                    type="button">
                                                                    <i class="bi-trash"></i>
                                                                </button>
                                                            </form>

                                                    </div>
                                                @endif

                                                @else
                                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.not_applicable'), config("app.locale")) }}
                                                @endif
                                            </td>
                                        </tr>

                                        @include('includes.modal-custom-content')
                                        @include('includes.product-delivery-content-form')

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- card -->

                        @if ($sales->hasPages())
                            <div class="mt-2">
                                {{ $sales->onEachSide(0)->appends(['sort' => request('sort')])->links() }}
                            </div>
                        @endif

                    @else
                        <div class="my-5 text-center">
            <span class="btn-block mb-3">
              <i class="bi-cart-x ico-no-result"></i>
            </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_results_found'), config("app.locale"))}}</h4>
                        </div>
                    @endif

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection
