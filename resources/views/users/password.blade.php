@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.password'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="iconmoon icon-Key mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.password'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.update_your_password'), config("app.locale"))}}</p>
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

                    @if (session('incorrect_pass'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(session('incorrect_pass'), config("app.locale")) }}
                        </div>
                    @endif

                    @include('errors.errors-forms')

                    <form method="POST" action="{{ url('settings/password') }}">

                        @csrf

                        @if (auth()->user()->password != '')
                            <div class="form-group">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="feather icon-unlock"></i></span>
                                    </div>
                                    <input class="form-control" name="old_password"
                                           placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.old_password'), config("app.locale"))}}"
                                           type="password" required>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="input-group mb-4" id="showHidePassword">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                </div>
                                <input class="form-control" name="new_password"
                                       placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.new_password'), config("app.locale"))}}"
                                       type="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text c-pointer"><i class="feather icon-eye-off"></i></span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-1 btn-success btn-block"
                                type="submit">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.save_changes'), config("app.locale"))}}</button>

                    </form>
                </div><!-- end col-md-6 -->
            </div>
        </div>
    </section>
@endsection
