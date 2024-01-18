@extends('layouts.app')

@section('title') {{ $product->name }} -@endsection

@section('description_custom'){{$product->description ? $product->description : \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('seo.description'), config("app.locale"))}}@endsection
@section('keywords_custom'){{$product->tags ? $product->tags.',' : null}}@endsection

@section('css')
    <meta property="og:type" content="website"/>
    <meta property="og:image:width" content="800"/>
    <meta property="og:image:height" content="600"/>

    <!-- Current locale and alternate locales -->
    <meta property="og:locale" content="en_US"/>
    <meta property="og:locale:alternate" content="es_ES"/>

    <!-- Og Meta Tags -->
    <link rel="canonical" href="{{url()->current()}}"/>
    <meta property="og:site_name" content="{{ $product->name }} - {{$settings->title}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:image" content="{{Helper::getFile(config('path.shop').$product->previews[0]->name)}}"/>
    <meta property="og:title" content="{{ $product->name }} - {{$settings->title}}"/>
    <meta property="og:description" content="{{strip_tags($product->description)}}"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:image" content="{{Helper::getFile(config('path.shop').$product->previews[0]->name)}}"/>
    <meta name="twitter:title" content="{{ $product->name }}"/>
    <meta name="twitter:description" content="{{strip_tags($product->description)}}"/>
@endsection

@section('content')
    <section class="section section-sm">
        <div class="container py-5">
            <div class="row">

                <div class="col-md-7 mb-lg-0 mb-4">

                    <div class="text-center mb-4 position-relative bg-light">

                        @if ($previews > 1)
                            <span class="count-previews">
                {{ $previews }} <i class="ml-1 bi-image"></i>
              </span>
                        @endif

                        <a href="{{ Helper::getFile(config('path.shop').$product->previews[0]->name) }}"
                           class="glightbox w-100" data-gallery="gallery{{$product->id}}">
                            <img class="img-fluid"
                                 src="{{ Helper::getFile(config('path.shop').$product->previews[0]->name) }}"
                                 style="max-height:600px; cursor: zoom-in;">
                        </a>

                        @if ($previews > 1)
                            @for ($i=1; $i < $previews; $i++)
                                <a href="{{ Helper::getFile(config('path.shop').$product->previews[$i]->name) }}"
                                   class="glightbox w-100 display-none" data-gallery="gallery{{$product->id}}">
                                    <img class="img-fluid"
                                         src="{{ Helper::getFile(config('path.shop').$product->previews[$i]->name) }}">
                                </a>
                            @endfor
                        @endif
                    </div>

                    <h4 class="mb-3">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.description'), config("app.locale")) }}</h4>
                    <p class="text-break">
                        {!! Helper::checkText($product->description)  !!}
                    </p>

                </div><!-- end col-md-7 -->

                <div class="col-md-5">
                    <h3 class="mb-2 font-weight-bold text-break">{{ $product->name }}</h3>

                    <div class="card bg-transparent mb-4 border-0">
                        <div class="card-body p-0">
                            <div class="d-flex">
                                <div class="d-flex my-2 align-items-center">
                                    <a href="{{ url($product->user()->username) }}">
                                        <img class="rounded-circle mr-2"
                                             src="{{ Helper::getFile(config('path.avatar').$product->user()->avatar) }}"
                                             width="60" height="60" alt="">
                                    </a>

                                    <div class="d-block">
                                        <a href="{{ url($product->user()->username) }}">
                                            <strong>{{ $product->user()->username }}</strong>

                                            <small class="verified mr-1">
                                                <i class="bi bi-patch-check-fill"></i>
                                            </small>
                                        </a>

                                        <div class="d-block">
                                            <small
                                                class="media-heading text-muted btn-block margin-zero">{{ Helper::formatDate($product->created_at) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->

                    <h3>
                        {{ Helper::amountFormatDecimal($product->price) }} <small>{{ $settings->currency_code }}</small>
                    </h3>

                    @if (auth()->check()
                        && auth()->id() != $product->user()->id
                        && ! $verifyPurchaseUser
                        || auth()->check()
                        && auth()->id() != $product->user()->id
                        && $verifyPurchaseUser
                        && $product->type == 'custom'

                        || auth()->guest()

                        )
                        <button class="btn btn-1 btn-primary btn-block mt-4" type="button" data-toggle="modal"
                                @auth data-target="#buyNowForm" @else data-target="#loginFormModal" @endauth>
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.buy_now'), config("app.locale")) }}
                        </button>


                    @elseif(auth()->check()
                        && auth()->id() != $product->user()->id
                        && ! $verifyPurchaseUser
                        || auth()->check()
                        && auth()->id() != $product->user()->id
                        && $verifyPurchaseUser
                        && $product->type == 'product'
                        || auth()->guest()
                        )
                        <button class="btn btn-1 btn-primary btn-block mt-4" type="button" data-toggle="modal"
                                @auth data-target="#buyNowForm" @else data-target="#loginFormModal" @endauth>
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.buy_now'), config("app.locale")) }}
                        </button>
                    @elseif (auth()->check() && auth()->id() != $product->user()->id && $verifyPurchaseUser && $product->type == 'digital')
                        <a class="btn btn-1 btn-primary btn-block mt-4"
                           href="{{ url('product/download', $product->id) }}">
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.download'), config("app.locale")) }}
                        </a>



                    @elseif (auth()->check() && auth()->id() == $product->user()->id)
                        <a class="btn btn-1 btn-primary btn-block mt-4" href="#" data-toggle="modal"
                           data-target="#editForm">
                            <i class="bi-pencil mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.edit'), config("app.locale")) }}
                        </a>

                        <form method="post" action="{{ url('delete/product', $product->id) }}">
                            @csrf
                            <button class="btn btn-1 btn-outline-danger btn-block mt-2 actionDeleteItem" type="button">
                                <i class="bi-trash mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.delete'), config("app.locale")) }}
                            </button>
                        </form>

                        @include('shop.modal-edit')

                    @endif

                    <div class="w-100 d-block mt-3">
                        <i class="bi-cart2 mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.purchases'), config("app.locale")) }}
                        ({{ $product->purchases()->count() }})
                    </div>

                    @if($product->type == 'product')
                         @if($product->product_promo != 0)
                        <div class="w-100 d-block mt-3">
                            <i class="bi-cart2 mr-2"></i> Promotion {{ $product->product_promo }} %
                        </div>

                        @endif

                    @endif

                    @if ($product->type == 'digital')
                        <div class="w-100 d-block mt-3">
                            <i class="bi-cloud-download mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.digital_download'), config("app.locale")) }}
                        </div>

                        <div class="w-100 d-block mt-3">
                            <i class="bi-box-seam mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.file'), config("app.locale")) }}
                            <span
                                class="text-uppercase">{{ $product->extension }}</span> -
                            <small>{{ $product->size }}</small>
                        </div>

                    @else
                        <div class="w-100 d-block mt-4">
                            <i class="fa fa-fire-alt mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delivery_time'), config("app.locale")) }}
                            ({{$product->delivery_time}} {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans_choice('general.days', $product->delivery_time), config("app.locale")) }}
                            )
                        </div>
                    @endif

                    <div class="w-100 d-block mt-4">
                        @for ($i = 0; $i < count($tags); ++$i)
                            <a href="{{ url('shop?tags=').trim($tags[$i]) }}">#{{ trim($tags[$i]) }}</a>
                        @endfor
                    </div>

                    <div class="w-100 d-block mt-4">
                        <i class="feather icon-share mr-2"></i> <span
                            class="mr-2">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.share'), config("app.locale")) }}</span>

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current().Helper::referralLink()}}"
                           title="Facebook" target="_blank" class="d-inline-block mr-2 h5">
                            <i class="fab fa-facebook facebook-btn"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{url()->current().Helper::referralLink()}}&text={{ $product->name }}"
                           title="Twitter" target="_blank" class="d-inline-block mr-2 h5">
                            <i class="fab fa-twitter twitter-btn"></i>
                        </a>

                        <a href="whatsapp://send?text={{url()->current().Helper::referralLink()}}"
                           data-action="share/whatsapp/share" class="d-inline-block h5" title="WhatsApp">
                            <i class="fab fa-whatsapp btn-whatsapp"></i>
                        </a>

                    </div>

                </div><!-- end col-md-7 -->

            </div><!-- row -->
        </div><!-- container -->

        @auth
            @include('shop.modal-buy')
        @endauth

        @if ($totalProducts > 1)
            <div class="container pt-5 border-top">
                <div class="row">

                    <div class="col-md-12 mb-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-weight-light">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.other_items_of'), config("app.locale")) }} {{ '@'.$product->user()->username }}</h4>

                            @if ($totalProducts > 4)
                                <h5 class="font-weight-light">
                                    <a href="{{ url($product->user()->username, 'shop') }}">
                                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.view_all'), config("app.locale")) }}
                                    </a>
                                </h5>
                            @endif
                        </div>

                    </div>

                    @foreach ($userProducts->where('id', '<>', $product->id)->take(3)->inRandomOrder()->get() as $product)
                        <div class="col-md-4 mb-4">
                            @include('shop.listing-products')
                        </div><!-- end col-md-4 -->
                    @endforeach

                </div><!-- row -->
            </div><!-- container -->
        @endif
    </section>

@endsection

@section('javascript')
    @auth
        <script src="{{ asset('js/shop.js') }}"></script>
    @endauth
@endsection
