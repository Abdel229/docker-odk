<!-- Start Modal payPerViewForm -->
<div class="modal fade" id="addItemForm" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-white shadow border-0">

                    <div class="card-body px-lg-5 py-lg-5 position-relative">

                        <div class="mb-4 position-relative">
                            <i class="bi-tag mr-1"></i>
                            <strong>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.choose_type_sale'), config("app.locale")) }}</strong>

                            <small data-dismiss="modal" class="btn-cancel-msg"><i class="bi bi-x-lg"></i></small>
                        </div>

                        <a class="card choose-type-sale mb-3" href="{{ url('add/product') }}">
                            <div class="card-body">
                                <h6 class="mb-1"><i
                                        class="bi-cloud-download mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.digital_products'), config("app.locale")) }}
                                </h6>
                                <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.digital_products_desc'), config("app.locale")) }}</small>
                            </div>
                        </a>

                        <a class="card choose-type-sale" href="{{ url('add/custom/content') }}">
                            <div class="card-body">
                                <h6 class="mb-1"><i
                                        class="bi-lightning-charge mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.custom_content'), config("app.locale")) }}
                                </h6>
                                <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.custom_content_desc'), config("app.locale")) }}</small>
                            </div>
                        </a>

                        <a class="card choose-type-sale" href="{{ url('add/custom/product/content') }}">
                            <div class="card-body">
                                <h6 class="mb-1"><i
                                        class="bi-bag mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.product_content'), config("app.locale")) }}
                                </h6>
                                <small>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.product_content_desc'), config("app.locale")) }}</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Modal addItemForm -->