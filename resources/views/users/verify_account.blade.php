@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.verify_account'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="feather icon-check-circle mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.verify_account'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(Auth::user()->verified_id != 'yes' ? trans('general.verified_account_desc') : trans('general.verified_account'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if (session('status'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('status'), config("app.locale")) }}
                        </div>
                    @endif

                    @include('errors.errors-forms')

                    @if ($settings->requests_verify_account == 'on'
                        && auth()->user()->verified_id != 'yes'
                        && auth()->user()->verificationRequests() != 1
                        && auth()->user()->verified_id != 'reject')

                        @if (auth()->user()->countries_id != ''
                            && auth()->user()->birthdate != ''
                            && auth()->user()->cover != ''
                            && auth()->user()->cover != $settings->cover_default
                            && auth()->user()->avatar != $settings->avatar
                          )

                            <div class="alert alert-warning mr-1">
                                <span class="alert-inner--text"><i class="fa fa-exclamation-triangle"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.warning_verification_info'), config("app.locale"))}}</span>
                            </div>

                            <form method="POST" id="formVerify" action="{{ url('settings/verify/account') }}"
                                  accept-charset="UTF-8" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marked-alt"></i></span>
                                        </div>
                                        <input class="form-control" name="address"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.address'), config("app.locale"))}}"
                                               value="{{old('address')}}"
                                               type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-pin"></i></span>
                                        </div>
                                        <input class="form-control" name="city"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.city'), config("app.locale"))}}"
                                               value="{{old('city')}}" type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                        </div>
                                        <input class="form-control" name="zip"
                                               placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.zip'), config("app.locale"))}}"
                                               value="{{old('zip')}}" type="text">
                                    </div>
                                </div>

                                @if (auth()->user()->countries_id == 1)
                                    <div class="mb-3 text-center">
                                        <span class="btn-block mb-2" id="previewImageFormW9"></span>

                                        <input type="file" name="form_w9" id="fileVerifiyAccountFormW9"
                                               accept="application/pdf" class="visibility-hidden">
                                        <button class="btn btn-1 btn-block btn-outline-primary mb-2 border-dashed"
                                                type="button"
                                                id="btnFileFormW9">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.upload_form_w9'), config("app.locale"))}}
                                            (PDF) {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.maximum'), config("app.locale"))}}
                                            : {{Helper::formatBytes($settings->file_size_allowed_verify_account * 1024)}}</button>

                                        <small
                                            class="text-muted btn-block">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.form_w9_required'), config("app.locale"))}}</small>
                                        <h6 class="btn-block text-center font-weight-bold">
                                            <a href="https://www.irs.gov/pub/irs-pdf/fw9.pdf"
                                               target="_blank">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.complete_form_W9_here'), config("app.locale")) }}
                                                <i
                                                    class="feather icon-external-link"></i></a>
                                        </h6>
                                    </div>

                                @endif

                                <div class="mb-3 text-center">
                                    <span class="btn-block mb-2" id="previewImage"></span>

                                    <input type="file" name="image" id="fileVerifiyAccount"
                                           accept="image/*,application/x-zip-compressed" class="visibility-hidden">
                                    <button class="btn btn-1 btn-block btn-outline-primary mb-2 border-dashed"
                                            type="button"
                                            id="btnFilePhoto">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.upload_image'), config("app.locale"))}}
                                        (JPG, PNG,
                                        GIF) {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.or'),config("app.locale"))}}
                                        ZIP - {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.maximum'),config("app.locale"))}}
                                        : {{Helper::formatBytes($settings->file_size_allowed_verify_account * 1024)}}</button>

                                    <small
                                        class="text-muted btn-block">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_verification_user'), config("app.locale"))}}</small>
                                </div>

                                <button class="btn btn-1 btn-success btn-block" id="sendData"
                                        type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.send_approval'), config("app.locale"))}}</button>
                            </form>

                        @else

                            <div class="alert alert-danger">
                                <span class="alert-inner--text"><i class="fa fa-exclamation-triangle mr-1"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.complete_profile_alert'), config("app.locale"))}}</span>

                                <ul class="list-unstyled">
                                    <br>

                                    @if (auth()->user()->avatar == $settings->avatar)
                                        <li>
                                            <i class="far fa-times-circle"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.set_avatar'), config("app.locale")) }}
                                            <a
                                                href="{{ url(auth()->user()->username) }}"
                                                class="text-white link-border">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.upload'), config("app.locale")) }}
                                                <i
                                                    class="feather icon-arrow-right"></i></a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->cover == '' || auth()->user()->cover == $settings->cover_default)
                                        <li>
                                            <i class="far fa-times-circle"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.set_cover'), config("app.locale")) }}
                                            <a
                                                href="{{ url(auth()->user()->username) }}"
                                                class="text-white link-border">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.upload'), config("app.locale")) }}
                                                <i
                                                    class="feather icon-arrow-right"></i></a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->countries_id == '')
                                        <li>
                                            <i class="far fa-times-circle"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.set_country'), config("app.locale")) }}
                                            <a
                                                href="{{ url('settings/page') }}"
                                                class="text-white link-border">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans( __('admin.edit'), config("app.locale")) }}
                                                <i
                                                    class="feather icon-arrow-right"></i></a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->birthdate == '')
                                        <li>
                                            <i class="far fa-times-circle"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.set_birthdate'), config("app.locale")) }}
                                            <a
                                                href="{{ url('settings/page') }}"
                                                class="text-white link-border">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.edit'), config("app.locale")) }}
                                                <i
                                                    class="feather icon-arrow-right"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                        @endif

                    @elseif (auth()->user()->verificationRequests() == 1)
                        <div class="alert alert-primary alert-dismissible text-center fade show" role="alert">
                            <span class="alert-inner--icon mr-2"><i class="fa fa-info-circle"></i></span>
                            <span
                                class="alert-inner--text">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.pending_request_verify'), config("app.locale"))}}</span>
                        </div>
                    @elseif (auth()->user()->verified_id == 'reject')
                        <div class="alert alert-danger alert-dismissible text-center fade show" role="alert">
                            <span class="alert-inner--icon mr-2"><i class="fa fa-info-circle"></i></span>
                            <span
                                class="alert-inner--text">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.rejected_request'), config("app.locale"))}}</span>
                        </div>
                    @elseif (auth()->user()->verified_id != 'yes' && $settings->requests_verify_account == 'off')
                        <div class="alert alert-primary alert-dismissible text-center fade show" role="alert">
                            <span class="alert-inner--icon mr-2"><i class="fa fa-info-circle"></i></span>
                            <span
                                class="alert-inner--text">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_receive_verification_requests'), config("app.locale"))}}</span>
                        </div>

                    @else
                        <div class="alert alert-success alert-dismissible text-center fade show" role="alert">
                            <span class="alert-inner--icon mr-2"><i class="feather icon-check-circle"></i></span>
                            <span
                                class="alert-inner--text">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.verified_account_success'), config("app.locale"))}}</span>
                        </div>

                    @endif

                </div><!-- end col-md-6 -->
            </div>
        </div>
    </section>
@endsection
