@extends('layouts.app')

@section('content')
    <section class="section section-sm">
        <div class="container container-lg-3 pt-5">
            <div class="row">

                <div class="col-md-2">
                    @include('includes.menu-sidebar-home')
                </div>

                <div class="col-md-6 p-0 second wrap-post">

                    @if ($settings->announcement != ''
                        && $settings->announcement_show == 'creators'
                        && auth()->user()->verified_id == 'yes'
                        || $settings->announcement != ''
                        && $settings->announcement_show == 'all'
                        )
                        <div
                            class="alert alert-{{$settings->type_announcement}} announcements display-none card-border-0"
                            role="alert">
                            <button type="button" class="close" id="closeAnnouncements">
              <span aria-hidden="true">
                <i class="bi bi-x-lg"></i>
              </span>
                            </button>

                            <h4 class="alert-heading"><i
                                    class="bi bi-megaphone mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.announcements'), config("app.locale")) }}
                            </h4>
                            <p class="update-text">
                                {!! $settings->announcement !!}
                            </p>
                        </div><!-- end announcements -->
                    @endif

                    @if (auth()->user()->payPerView()->count() != 0)
                        <div class="col-md-12 d-none">
                            <ul class="list-inline">
                                <li class="list-inline-item text-uppercase h5">
                                    <a href="{{ url('/') }}"
                                       class="text-decoration-none @if (request()->is('/')) link-border @else text-muted  @endif">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.home'), config("app.locale")) }}</a>
                                </li>
                                <li class="list-inline-item text-uppercase h5">
                                    <a href="{{ url('my/purchases') }}"
                                       class="text-decoration-none @if (request()->is('my/purchases')) link-border @else text-muted @endif">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.purchased'), config("app.locale")) }}</a>
                                </li>
                            </ul>
                        </div>
                    @endif

                    @if (auth()->user()->verified_id == 'yes')
                        @include('includes.form-post')
                    @endif

                    @if($updates->total() != 0)

                        @php
                            $counterPosts = ($updates->total() - $settings->number_posts_show)
                        @endphp

                        <div class="grid-updates position-relative" id="updatesPaginator">
                            @include('includes.updates')
                        </div>

                    @else
                        <div class="grid-updates position-relative" id="updatesPaginator"></div>

                        <div class="my-5 text-center no-updates">
          <span class="btn-block mb-3">
            <i class="fa fa-photo-video ico-no-result"></i>
          </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_posts_posted'), config("app.locale"))}}</h4>
                        </div>

                    @endif
                </div><!-- end col-md-12 -->

                <div class="col-md-4 @if ($users->total() != 0) mb-4 @endif first">

                    <a href="{{ url('explore') }}" class="btn btn-primary btn-block mb-3 d-lg-none">
                        <i class="far	fa-compass mr-1"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore_posts'), config("app.locale"))}}
                    </a>

                    @if ($users->total() != 0)
                        <button type="button" class="btn btn-primary btn-block mb-2 d-lg-none" type="button"
                                data-toggle="collapse" data-target="#navbarUserHome" aria-controls="navbarCollapse"
                                aria-expanded="false">
                            <i class="far	fa-compass mr-1"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore_creators'), config("app.locale"))}}
                        </button>
                    @endif

                    <div class="navbar-collapse collapse d-lg-block sticky-top" id="navbarUserHome">

                        @if ($users->total() == 0)
                            <div class="panel panel-default panel-transparent mb-4 d-lg-block d-none">
                                <div class="panel-body">
                                    <div class="media none-overflow">
                                        <div class="d-flex my-2 align-items-center">
                                            <img class="rounded-circle mr-2"
                                                 src="{{Helper::getFile(config('path.avatar').auth()->user()->avatar)}}"
                                                 width="60" height="60" alt="">

                                            <div class="d-block">
                                                <strong>{{auth()->user()->name}}</strong>


                                                <div class="d-block">
                                                    <small class="media-heading text-muted btn-block margin-zero">
                                                        <a href="{{url('settings/page')}}">
                                                            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans( auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile'), config("app.locale"))}}
                                                            <small class="pl-1"><i
                                                                    class="fa fa-long-arrow-alt-right"></i></small>
                                                        </a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($users->total() != 0)
                            @include('includes.explore_creators')
                        @endif

                        <div class="d-lg-block d-none">
                            @include('includes.footer-tiny')
                        </div>

                    </div><!-- navbarUserHome -->

                </div><!-- col-md -->

            </div>
        </div>
    </section>
@endsection

@section('javascript')

    @if (session('noty_error'))
        <script type="text/javascript">
            swal({
                title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.error_oops'), config("app.locale")) }}",
                "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.already_sent_report'), config("app.locale")) }}",
                "error",
                confirmButtonText: "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
            })
        </script>

    @endif

    @if (session('noty_success'))
        <script type="text/javascript">
            swal({
                title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.thanks'), config("app.locale")) }}",
                "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.reported_success'), config("app.locale")) }}",
                "success",
                confirmButtonText: "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
            })
        </script>

    @endif

    @if (session('success_verify'))
        <script type="text/javascript">
            swal({
                title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.welcome'), config("app.locale")) }}",
                "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.account_validated'), config("app.locale")) }}",
                "success",
                confirmButtonText: "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
            })
        </script>

    @endif

    @if (session('error_verify'))
        <script type="text/javascript">
            swal({
                title: "{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.error_oops'), config("app.locale")) }}",
                "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.code_not_valid'), config("app.locale")) }}",
                "error",
                confirmButtonText: "
                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.ok'), config("app.locale")) }}"
            })
        </script>

    @endif

@endsection
