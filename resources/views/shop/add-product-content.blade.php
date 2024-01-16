@extends('layouts.app')

@section('title') {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.sell_custom_content'), config("app.locale")) }} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-12 py-5">
                    <h2 class="mb-0 font-montserrat">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.product_content'), config("app.locale")) }}
                    </h2>
                    <p class="lead text-muted mt-0">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.product_content_desc'), config("app.locale")) }}
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">

                <div class="col-lg-7">
                    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data"
                          id="shopProductForm">
                        @csrf

                        <div class="form-group preview-shop">
                            <label
                                for="preview">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.preview'), config("app.locale")) }}
                                <small>(JPG, PNG)</small></label>
                            <input type="file" name="preview" id="preview" accept="image/*">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="name"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.name'), config("app.locale")) }}">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control isNumber" name="price" autocomplete="off"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.price'), config("app.locale")) }}">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="tags"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.tags'), config("app.locale")) }} ({{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.separate_with_comma'), config("app.locale")) }})">
                        </div>

                        <div class="form-group">
                        <select name="delivery_time" class="form-control custom-select">
                                <option value=""
                                        selected>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delivery_time'), config("app.locale")) }}</option>
                                @for ($i=1; $i <= 30; ++$i)
                                    <option
                                        value="{{$i}}">{{$i}} {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans_choice('general.days', $i), config("app.locale")) }}</option>
                                @endfor
                            </select>

                        </div>

                        <div class="form-group">
                            <textarea class="form-control textareaAutoSize" name="description"
                                      placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.description'), config("app.locale")) }}"
                                      rows="3"></textarea>
                        </div>




                        <div  class="form-group" >
                        <select name="categorie" class="form-control custom-select">
                                <option value=""
                                        selected>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.product_categories'), config("app.locale")) }}</option>
                                @foreach($categories as $cate)
                                    <option
                                        value="{{$cate->id}}">{{ $cate->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        <div class="form-group">
                            <input type="text" class="form-control isNumber" name="promo" autocomplete="off"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.promo'), config("app.locale")) }}">
                        </div>

                        <div class="form-group">
                            <input type="hidden"  value="0" class="form-control isNumber" name="dim" autocomplete="off"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.dimension'), config("app.locale")) }}">
                        </div>


                        <div class="form-group">
                            <input type="hidden" class="form-control isNumber" value="0" name="kg" autocomplete="off"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.size'), config("app.locale")) }}">
                        </div>


                        <div class="form-group">
                            <input type="text" class="form-control isNumber" name="stock" autocomplete="off"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.stock'), config("app.locale")) }}">
                        </div>






                        <!-- Alert -->
                        <div class="alert alert-danger my-3 display-none" id="errorShopProduct">
                            <ul class="list-unstyled m-0" id="showErrorsShopProduct">
                                <li></li>
                            </ul>
                        </div><!-- Alert -->

                        <button class="btn btn-1 btn-primary btn-block" id="shopProductBtn" type="submit">
                            <i></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('users.create'), config("app.locale")) }}
                        </button>
                    </form>
                </div><!-- end col-md-12 -->
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('js/fileuploader/fileuploader-shop-preview.js') }}"></script>
    <script src="{{ asset('js/fileuploader/fileuploader-shop-file.js') }}"></script>
    <script src="{{ asset('js/shop.js') }}"></script>

@endsection
