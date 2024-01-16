@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delete_account'), config('app.locale'))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="feather icon-user-x mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delete_account'), config('app.locale'))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.subtitle_delete_account'), config('app.locale'))}}</p>
                </div>
            </div>
            <div class="row justify-content-center">

                <div class="col-md-7 mb-5 mb-lg-0">


                    @if (session('incorrect_pass'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="bi bi-x"></i>
                            </button>
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('incorrect_pass'), config("app.locale")) }}
                        </div>
                    @endif

                    @include('errors.errors-forms')

                    <div class="alert alert-warning" role="alert">
                        <i class="fa fa-exclamation-triangle"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.notice_delete_account'), config('app.locale')) }}
                    </div>

                    <form method="POST" id="formSend" action="{{ url()->current() }}">

                        @csrf
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input class="form-control" name="password"
                                       placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.enter_password'), config('app.locale'))}}"
                                       type="password" required>
                            </div>
                        </div>

                        <button class="btn btn-1 btn-danger btn-block" id="buttonDeleteAccount"
                                type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delete_account'), config('app.locale'))}}</button>

                        <div class="text-center mt-3">
                            <a href="{{ url('privacy/security') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.cancel'), config('app.locale')) }}</a>
                        </div>

                    </form>

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection
