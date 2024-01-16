@extends('layouts.app')

@section('title') {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.add_product'), config("app.locale")) }} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-12 py-5">
                    <h2 class="mb-0 font-montserrat">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.add_product'), config("app.locale")) }}
                    </h2>
                    <p class="lead text-muted mt-0">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.digital_products_desc'), config("app.locale")) }}
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
                                <small>(JPG,
                                    PNG)</small></label>
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
                            <textarea class="form-control textareaAutoSize" name="description"
                                      placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.description'), config("app.locale")) }}"
                                      rows="3"></textarea>
                        </div>

                        <div class="form-group file-shop mb-4">
                            <label for="file">
                                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.file'), config("app.locale")) }}
                                <small>(JPG, PNG, GIF, MP4, MOV, MP3, PDF, ZIP)</small>
                                <small
                                    class="d-block w-100">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.file_to_downloaded'), config("app.locale")) }}</small>
                            </label>
                            <input type="file" name="file" id="file"
                                   accept="image/*,application/pdf,application/x-zip-compressed,video/x-mpeg2,video/quicktime,video/mp4,video/x-m4v,audio/x-mpeg">
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