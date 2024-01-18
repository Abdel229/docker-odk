@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.products'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="bi-tag mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.products'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted m-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.all_products_published'), config("app.locale"))}}</p>

                    <div class="mt-2">
                        @if ($settings->digital_product_sale && ! $settings->custom_content)
                            <a class="btn btn-primary" href="{{ url('add/product') }}">
                                <i class="bi-plus"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.add_product'), config("app.locale")) }}
                            </a>

                        @elseif (! $settings->digital_product_sale && $settings->custom_content)
                            <a class="btn btn-primary" href="{{ url('add/custom/content') }}">
                                <i class="bi-plus"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.add_custom_content'), config("app.locale")) }}
                            </a>

                        @else
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addItemForm">
                                <i class="bi-plus"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.add_new'), config("app.locale")) }}
                            </a>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">

                <div class="col-md-12 mb-5 mb-lg-0">

                    @if ($products->count() != 0)
                        <div class="card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>

                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.name'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.type'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.price'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.sales'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.status'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.actions'), config("app.locale"))}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach ($products as $product)

                                        <tr>


                                            <td>
                                                <a href="{{ url('shop/product', $product->id) }}" target="_blank">
                                                    {{ str_limit($product->name, 20, '...') }} <i
                                                        class="bi bi-box-arrow-up-right ml-1"></i>
                                                </a>
                                            </td>
                                            <td>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($product->type == 'digital' ? __('general.digital_download') : __('general.custom_content'), config("app.locale")) }}</td>
                                            <td>{{ Helper::amountFormatDecimal($product->price) }}</td>
                                            <td>{{ $product->purchases->count() }}</td>
                                            <td>{{Helper::formatDate($product->created_at)}}</td>
                                            <td>
                                                @if ($product->status)
                                                    <span
                                                        class="badge badge-pill badge-success text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.active'), config("app.locale"))}}</span>
                                                @else
                                                    <span
                                                        class="badge badge-pill badge-secondary text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.disabled'), config("app.locale"))}}</span>
                                                @endif
                                            </td>

                                            <td>


                                                    <a title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.edit'), config("app.locale")) }}"
                                                                    class="d-inline-block mr-2 btn btn-warning btn-sm-custom"
                                                                    data-toggle="modal"
                                                                     data-target="#editForm{{$product->id}}" href="#">
                                                                        <i class="bi-pencil mr-1"></i>
                                                                </a>

                                            </td>
                                        </tr>

                                         @include('shop.modal-edit-product')
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- card -->

                        @if ($products->hasPages())
                            {{ $products->onEachSide(0)->links() }}
                        @endif

                    @else
                        <div class="my-5 text-center">
            <span class="btn-block mb-3">
              <i class="bi-tag ico-no-result"></i>
            </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_results_found'), config("app.locale"))}}</h4>
                        </div>
                    @endif
                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>

    @includeWhen(auth()->check() && auth()->user()->verified_id == 'yes', 'shop.modal-add-item')





@endsection
