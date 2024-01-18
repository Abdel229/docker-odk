<!-- Start Modal liveStreamingForm -->
<div class="modal fade" id="liveStreamingForm" tabindex="-1" role="dialog" aria-labelledby="modal-form"
     aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-white shadow border-0">

                    <div class="card-body px-lg-5 py-lg-5 position-relative">

                        <div class="mb-3">
                            <i class="bi bi-broadcast mr-1"></i>
                            <strong>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.create_live_stream'), config("app.locale"))}}</strong>
                        </div>

                        <form method="post" action="{{url('create/live')}}" id="formSendLive">

                            @csrf

                            <div class="form-group">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-lightning-charge"></i></span>
                                    </div>
                                    <input type="text" autocomplete="off" class="form-control" name="name"
                                           placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('auth.name'), config("app.locale")) }} *">
                                </div>
                            </div><!-- End form-group -->

                            <div class="form-group">
                                <div class="input-group mb-2" id="AvailabilityGroup">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-eye"></i></span>
                                    </div>
                                    <select name="availability" id="Availability" class="form-control custom-select">
                                        <option value="all_pay"
                                                data-text="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.desc_available_everyone_paid'), config("app.locale")) }}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.available_everyone_paid'), config("app.locale"))}}</option>
                                        <option value="free_paid_subscribers"
                                                data-text="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_price_live'), config("app.locale")) }}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.available_free_paid_subscribers'), config("app.locale"))}}</option>

                                        @if ($settings->live_streaming_free)
                                            <option value="everyone_free"
                                                    data-text="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.desc_everyone_free'), config("app.locale")) }}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.available_everyone_free'), config("app.locale"))}}</option>
                                        @endif
                                    </select>
                                </div>

                                @if ($settings->limit_live_streaming_paid != 0)
                                    <small class="form-text text-danger" id="LimitLiveStreamingPaid">
                                        <i class="bi bi-exclamation-triangle-fill mr-1"></i>
                                        <strong>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.limit__minutes_per_transmission_paid', ['min' => $settings->limit_live_streaming_paid]), config("app.locale")) }}</strong>
                                    </small>
                                @endif

                                @if ($settings->limit_live_streaming_free != 0)
                                    <small class="form-text display-none text-danger" id="everyoneFreeAlert">
                                        <i class="bi bi-exclamation-triangle-fill mr-1"></i>
                                        <strong>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.limit__minutes_per_transmission_free', ['min' => $settings->limit_live_streaming_free]), config("app.locale")) }}</strong>
                                    </small>
                                @endif

                            </div><!-- ./form-group -->

                            <div class="form-group mb-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{$settings->currency_symbol}}</span>
                                    </div>
                                    <input type="number" min="{{$settings->live_streaming_minimum_price}}"
                                           autocomplete="off" id="onlyNumber" class="form-control priceLive"
                                           name="price"
                                           placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.price'), config("app.locale")) }} ({{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.minimum'), config("app.locale")) }} {{ Helper::amountWithoutFormat($settings->live_streaming_minimum_price) }})">
                                </div>
                            </div><!-- End form-group -->
                            <small class="form-text mb-4"
                                   id="descAvailability">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.desc_available_everyone_paid'), config("app.locale")) }}</small>

                            <div class="alert alert-danger display-none mb-0 mt-3" id="errorLive">
                                <ul class="list-unstyled m-0" id="showErrorsLive"></ul>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn e-none mt-4"
                                        data-dismiss="modal">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.cancel'), config("app.locale"))}}</button>
                                <button type="submit" id="liveBtn" class="btn btn-primary mt-4 liveBtn">
                                    <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.create'), config("app.locale"))}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Modal liveStreamingForm -->
