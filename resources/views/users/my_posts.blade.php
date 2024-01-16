@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.my_posts'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat"><i
                            class="feather icon-feather mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.my_posts'), config("app.locale"))}}
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.all_post_created'), config("app.locale"))}}</p>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12 mb-5 mb-lg-0">

                    @if ($posts->count() != 0)
                        <div class="card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.content'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.description'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.type'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.price'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.interactions'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.date'), config("app.locale"))}}</th>
                                        <th scope="col">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.status'), config("app.locale"))}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach ($posts as $post)

                                        @php
                                            $allFiles = $post->media()->groupBy('type')->get();
                                        @endphp
                                        <tr>
                                            <td>{{ $post->id }}</td>

                                            <td>
                                                @if ($allFiles->count() != 0)
                                                    @foreach ($allFiles as $media)

                                                        @if ($media->type == 'image')
                                                            <i class="feather icon-image mr-1"></i>
                                                        @endif

                                                        @if ($media->type == 'video')
                                                            <i class="feather icon-video mr-1"></i>
                                                        @endif

                                                        @if ($media->type == 'music')
                                                            <i class="feather icon-mic mr-1"></i>
                                                        @endif

                                                        @if ($media->type == 'file')
                                                            <i class="far fa-file-archive"></i>
                                                        @endif

                                                    @endforeach

                                                @else
                                                    <i class="bi bi-file-font"></i>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ url($post->user()->username, 'post').'/'.$post->id }}"
                                                   target="_blank">
                                                    {{ str_limit($post->description, 20, '...') }} <i
                                                        class="bi bi-box-arrow-up-right ml-1"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if ($post->locked == 'yes')
                                                    <i class="feather icon-lock mr-1"
                                                       title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.content_locked'), config("app.locale"))}}"></i>
                                                @else
                                                    <i class="iconmoon icon-WorldWide mr-1"
                                                       title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.public'), config("app.locale"))}}"></i>
                                                @endif
                                            </td>
                                            <td>{{ Helper::amountFormatDecimal($post->price) }}</td>
                                            <td><i class="far fa-heart"></i> {{ $post->likes()->count() }} <i
                                                    class="far fa-comment ml-1"></i> {{ $post->comments()->count() }}
                                            </td>
                                            <td>{{Helper::formatDate($post->date)}}</td>
                                            <td>
                                                @if ($post->status == 'active')
                                                    <span
                                                        class="badge badge-pill badge-success text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.active'), config("app.locale"))}}</span>
                                                @else
                                                    <span
                                                        class="badge badge-pill badge-warning text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.pending'), config("app.locale"))}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- card -->

                        @if ($posts->hasPages())
                            {{ $posts->onEachSide(0)->links() }}
                        @endif

                    @else
                        <div class="my-5 text-center">
            <span class="btn-block mb-3">
              <i class="feather icon-feather ico-no-result"></i>
            </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.not_post_created'), config("app.locale"))}}</h4>
                        </div>
                    @endif
                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>
@endsection
