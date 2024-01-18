@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.restricted_users'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="feather icon-slash mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.restricted_users'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.info_restricted_users'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')

                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">

                    @if ($restrictions->count() != 0)

                        @if (session('message'))
                            <div class="alert alert-success mb-3">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                                </button>
                                <i class="fa fa-check mr-1"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans( session('message'), config("app.locale")) }}
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
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.user'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.actions'), config("app.locale"))}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($restrictions as $restriction)
                                        <tr>
                                            <td>
                                                @if (! isset($restriction->userRestricted()->username))
                                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_available'), config("app.locale")) }}
                                                @else
                                                    <a href="{{ url($restriction->userRestricted()->username) }}">
                                                        <img
                                                            src="{{Helper::getFile(config('path.avatar').$restriction->userRestricted()->avatar)}}"
                                                            width="40" height="40" class="rounded-circle mr-2" alt="">

                                                        {{ '@'.$restriction->userRestricted()->username }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{Helper::formatDate($restriction->created_at)}}</td>

                                            <td>
                                                <button title="" class="btn btn-danger btn-sm-custom removeRestriction"
                                                        type="button" data-user="{{$restriction->userRestricted()->id}}"
                                                        id="restrictUser">
                                                    <i class="bi-trash"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.remove_restriction'), config("app.locale")) }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- card -->

                        @if ($restrictions->hasPages())
                            <div class="mt-2">
                                {{ $restrictions->onEachSide(0)->links() }}
                            </div>
                        @endif

                    @else
                        <div class="my-5 text-center">
            <span class="btn-block mb-3">
              <i class="feather icon-slash ico-no-result"></i>
            </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_results_found'), config("app.locale"))}}</h4>
                        </div>
                    @endif

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection
