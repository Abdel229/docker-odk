@foreach ($updates as $response)

    @php
        if (auth()->check()) {
            $checkUserSubscription = auth()->user()->checkSubscription($response->user());
            $checkPayPerView = auth()->user()->payPerView()->where('updates_id', $response->id)->first();
        }

    $totalLikes = number_format($response->likes()->count());
    $totalComments = number_format($response->comments()->count());

    $mediaCount = $response->media()->count();

    $allFiles = $response->media()->groupBy('type')->get();

    $getFirstFile = $allFiles->where('type', '<>', 'music')->where('type', '<>', 'file')->where('video_embed', '')->first();

    if ($getFirstFile && $getFirstFile->type == 'image') {
        $urlMedia =  url('media/storage/focus/photo', $getFirstFile->id);
        $backgroundPostLocked = 'background: url('.$urlMedia.') no-repeat center center #b9b9b9; background-size: cover;';
        $textWhite = 'text-white';

    } elseif ($getFirstFile && $getFirstFile->type == 'video' && $getFirstFile->video_poster) {
            $videoPoster = url('media/storage/focus/video', $getFirstFile->video_poster);
            $backgroundPostLocked = 'background: url('.$videoPoster.') no-repeat center center #b9b9b9; background-size: cover;';
            $textWhite = 'text-white';

    } else {
        $backgroundPostLocked = null;
        $textWhite = null;
    }

    $countFilesImage = $response->media()->where('image', '<>', '')->groupBy('type')->count();
    $countFilesVideo = $response->media()->where('video', '<>', '')->orWhere('video_embed', '<>', '')->where('updates_id', $response->id)->groupBy('type')->count();
    $countFilesAudio = $response->media()->where('music', '<>', '')->groupBy('type')->count();

    $mediaImageVideo = $response->media()
            ->where('image', '<>', '')
            ->orWhere('updates_id', $response->id)
            ->where('video', '<>', '')
            ->get();

    $mediaImageVideoTotal = $mediaImageVideo->count();

    $videoEmbed = $response->media()->where('video_embed', '<>', '')->get();
    $isVideoEmbed = false;

    if ($videoEmbed->count() != 0) {
        foreach ($videoEmbed as $media) {
            $isVideoEmbed = $media->video_embed;
        }
    }
    $nth = 0; // nth foreach nth-child(3n-1)

    @endphp
    <div
        class="card mb-3 card-updates rounded-large shadow-large card-border-0 @if ($response->status == 'pending') post-pending @endif @if ($response->fixed_post == '1' && request()->path() == $response->user()->username || auth()->check() && $response->fixed_post == '1' && $response->user()->id == auth()->user()->id) pinned-post @endif"
        data="{{$response->id}}">
        <div class="card-body">
            <div
                class="pinned_post text-muted small w-100 mb-2 {{ $response->fixed_post == '1' && request()->path() == $response->user()->username || auth()->check() && $response->fixed_post == '1' && $response->user()->id == auth()->user()->id ? 'pinned-current' : 'display-none' }}">
                <i class="bi bi-pin mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.pinned_post'), config("app.locale")) }}
            </div>

            @if ($response->status == 'pending')
                <h6 class="text-muted w-100 mb-4">
                    <i class="bi bi-eye-fill mr-1"></i>
                    <em>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.post_pending_review'), config("app.locale")) }}</em>
                </h6>
            @endif

            <div class="media">
		<span class="rounded-circle mr-3 position-relative">
			<a href="{{$response->user()->isLive() ? url('live', $response->user()->username) : url($response->user()->username)}}">

				@if (auth()->check() && $response->user()->isLive())
                    <span
                        class="live-span">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.live'), config("app.locale")) }}</span>
                @endif

				<img src="{{ Helper::getFile(config('path.avatar').$response->user()->avatar) }}"
                     alt="{{$response->user()->hide_name == 'yes' ? $response->user()->username : $response->user()->name}}"
                     class="rounded-circle avatarUser" width="60" height="60">
				</a>
		</span>

                <div class="media-body">
                    <h5 class="mb-0 font-montserrat">
                        <a href="{{url($response->user()->username)}}">
                            {{$response->user()->hide_name == 'yes' ? $response->user()->username : $response->user()->name}}
                        </a>

                        @if($response->user()->verified_id == 'yes')
                            <small class="verified"
                                   title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.verified_account'), config("app.locale"))}}"
                                   data-toggle="tooltip"
                                   data-placement="top">
                                <i class="bi bi-patch-check-fill"></i>
                            </small>
                        @endif

                        <small class="text-muted font-14">{{'@'.$response->user()->username}}</small>

                        @if (auth()->check() && auth()->user()->id == $response->user()->id)
                            <a href="javascript:void(0);" class="text-muted float-right" id="dropdown_options"
                               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-ellipsis-h"></i>
                            </a>

                            <!-- Target -->
                            <button class="d-none copy-url" id="url{{$response->id}}"
                                    data-clipboard-text="{{url($response->user()->username.'/post', $response->id)}}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.copy_link'), config("app.locale"))}}</button>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_options">
                                @if (request()->path() != $response->user()->username.'/post/'.$response->id)
                                    <a class="dropdown-item"
                                       href="{{url($response->user()->username.'/post', $response->id)}}"><i
                                            class="bi bi-box-arrow-in-up-right mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.go_to_post'), config("app.locale"))}}
                                    </a>
                                @endif

                                @if ($response->status == 'active')
                                    <a class="dropdown-item pin-post" href="javascript:void(0);"
                                       data-id="{{$response->id}}">
                                        <i class="bi bi-pin mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans($response->fixed_post == '0' ? trans('general.pin_to_your_profile') : trans('general.unpin_from_profile'), config("app.locale")) }}
                                    </a>
                                @endif

                                <button class="dropdown-item" onclick="$('#url{{$response->id}}').trigger('click')"><i
                                        class="feather icon-link mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.copy_link'), config("app.locale"))}}
                                </button>

                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#editPost{{$response->id}}">
                                    <i class="bi bi-pencil mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.edit_post'), config("app.locale"))}}
                                </button>

                                {!! Form::open([
                                    'method' => 'POST',
                                    'url' => "update/delete/$response->id",
                                    'class' => 'd-inline'
                                ]) !!}

                                @if (isset($inPostDetail))
                                    {!! Form::hidden('inPostDetail', 'true') !!}
                                @endif

                                {!! Form::button('<i class="feather icon-trash-2 mr-2"></i> '.\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.delete_post'), config("app.locale")), ['class' => 'dropdown-item actionDelete']) !!}
                                {!! Form::close() !!}
                            </div>

                            <div class="modal fade modalEditPost" id="editPost{{$response->id}}" tabindex="-1"
                                 role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.edit_post'), config("app.locale"))}}</h5>
                                            <button type="button" class="close close-inherit" data-dismiss="modal"
                                                    aria-label="Close">
								<span aria-hidden="true">
									<i class="bi bi-x-lg"></i>
								</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{url('update/edit')}}"
                                                  enctype="multipart/form-data" class="formUpdateEdit">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$response->id}}"/>
                                                <div class="card mb-4">
                                                    <div class="blocked display-none"></div>
                                                    <div class="card-body pb-0">

                                                        <div class="media">
										<span class="rounded-circle mr-3">
												<img
                                                    src="{{ Helper::getFile(config('path.avatar').auth()->user()->avatar) }}"
                                                    class="rounded-circle" width="60" height="60" alt="">
										</span>

                                                            <div class="media-body">
                                                                <textarea name="description" rows="5" cols="40"
                                                                          placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.write_something'), config("app.locale"))}}"
                                                                          class="form-control textareaAutoSize border-0 updateDescription">{{$response->description}}</textarea>
                                                            </div>
                                                        </div><!-- media -->

                                                        <input class="custom-control-input d-none customCheckLocked"
                                                               type="checkbox"
                                                               {{$response->locked == 'yes' ? 'checked' : ''}}  name="locked"
                                                               value="yes">

                                                        <!-- Alert -->
                                                        <div class="alert alert-danger my-3 display-none errorUdpate">
                                                            <ul class="list-unstyled m-0 showErrorsUdpate small"></ul>
                                                        </div><!-- Alert -->

                                                    </div><!-- card-body -->

                                                    <div class="card-footer bg-white border-0 pt-0">
                                                        <div class="justify-content-between align-items-center">

                                                            <div
                                                                class="form-group @if ($response->price == 0.00) display-none @endif price">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text">{{$settings->currency_symbol}}</span>
                                                                    </div>
                                                                    <input class="form-control isNumber"
                                                                           value="{{$response->price != 0.00 ? $response->price : null}}"
                                                                           autocomplete="off" name="price"
                                                                           placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.price'), config("app.locale"))}}"
                                                                           type="text">
                                                                </div>
                                                            </div><!-- End form-group -->

                                                            @if ($response->price == 0.00)
                                                                <button type="button"
                                                                        class="btn btn-upload btn-tooltip e-none align-bottom setPrice @if (auth()->user()->dark_mode == 'off') text-primary @else text-white @endif rounded-pill"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.price_post_ppv'), config("app.locale"))}}">
                                                                    <i class="feather icon-tag f-size-25"></i>
                                                                </button>
                                                            @endif

                                                            @if ($response->price == 0.00)
                                                                <button type="button"
                                                                        class="contentLocked btn e-none align-bottom @if (auth()->user()->dark_mode == 'off') text-primary @else text-white @endif rounded-pill btn-upload btn-tooltip {{$response->locked == 'yes' ? '' : 'unlock'}}"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.locked_content'), config("app.locale"))}}">
                                                                    <i class="feather icon-{{$response->locked == 'yes' ? '' : 'un'}}lock f-size-25"></i>
                                                                </button>
                                                            @endif

                                                            <div class="d-inline-block float-right mt-3">
                                                                <button type="submit"
                                                                        class="btn btn-sm btn-primary rounded-pill float-right btnEditUpdate">
                                                                    <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.save'), config("app.locale"))}}
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div><!-- card footer -->
                                                </div><!-- card -->
                                            </form>
                                        </div><!-- modal-body -->
                                    </div><!-- modal-content -->
                                </div><!-- modal-dialog -->
                            </div><!-- modal -->
                        @endif

                        @if(auth()->check()
                            && auth()->user()->id != $response->user()->id
                            && $response->locked == 'yes'
                            && $checkUserSubscription && $response->price == 0.00

                            || auth()->check()
                                && auth()->user()->id != $response->user()->id
                                && $response->locked == 'yes'
                                && $checkUserSubscription
                                && $response->price != 0.00
                                && $checkPayPerView

                            || auth()->check()
                                && auth()->user()->id != $response->user()->id
                                && $response->price != 0.00
                                && ! $checkUserSubscription
                                && $checkPayPerView

                            || auth()->check() && auth()->user()->id != $response->user()->id && auth()->user()->role == 'admin' && auth()->user()->permission == 'all'
                            || auth()->check() && auth()->user()->id != $response->user()->id && $response->locked == 'no'
                            )
                            <a href="javascript:void(0);" class="text-muted float-right" id="dropdown_options"
                               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-ellipsis-h"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_options">

                                <!-- Target -->
                                <button class="d-none copy-url" id="url{{$response->id}}"
                                        data-clipboard-text="{{url($response->user()->username.'/post', $response->id).Helper::referralLink()}}">
                                    {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.copy_link'), config("app.locale"))}}
                                </button>

                                @if (request()->path() != $response->user()->username.'/post/'.$response->id)
                                    <a class="dropdown-item"
                                       href="{{url($response->user()->username.'/post', $response->id)}}">
                                        <i class="bi bi-box-arrow-in-up-right mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.go_to_post'), config("app.locale"))}}
                                    </a>
                                @endif

                                <button class="dropdown-item" onclick="$('#url{{$response->id}}').trigger('click')">
                                    <i class="feather icon-link mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.copy_link'), config("app.locale"))}}
                                </button>

                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#reportUpdate{{$response->id}}">
                                    <i class="bi bi-flag mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.report'), config("app.locale"))}}
                                </button>

                            </div>

                            <div class="modal fade modalReport" id="reportUpdate{{$response->id}}" tabindex="-1"
                                 role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title font-weight-light" id="modal-title-default"><i
                                                    class="fas fa-flag mr-1"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.report_update'), config("app.locale"))}}
                                            </h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>

                                        <!-- form start -->
                                        <form method="POST" action="{{url('report/update', $response->id)}}"
                                              enctype="multipart/form-data">
                                            <div class="modal-body">
                                            @csrf
                                            <!-- Start Form Group -->
                                                <div class="form-group">
                                                    <label>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.please_reason'), config("app.locale"))}}</label>
                                                    <select name="reason" class="form-control custom-select">
                                                        <option
                                                            value="copyright">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.copyright'), config("app.locale"))}}</option>
                                                        <option
                                                            value="privacy_issue">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.privacy_issue'), config("app.locale"))}}</option>
                                                        <option
                                                            value="violent_sexual">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.violent_sexual_content'), config("app.locale"))}}</option>
                                                    </select>
                                                </div><!-- /.form-group-->
                                            </div><!-- Modal body -->

                                            <div class="modal-footer">
                                                <button type="button" class="btn border text-white"
                                                        data-dismiss="modal">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.cancel'), config("app.locale"))}}</button>
                                                <button type="submit" class="btn btn-xs btn-white sendReport ml-auto">
                                                    <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.report_update'), config("app.locale"))}}
                                                </button>
                                            </div>
                                        </form>
                                    </div><!-- Modal content -->
                                </div><!-- Modal dialog -->
                            </div><!-- Modal -->
                        @endif
                    </h5>

                    <small class="timeAgo text-muted" data="{{date('c', strtotime($response->date))}}"></small>

                    @if ($response->locked == 'no')
                        <small class="text-muted type-post"
                               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.public'), config("app.locale"))}}">
                            <i class="iconmoon icon-WorldWide mr-1"></i>
                        </small>
                    @endif

                    @if ($response->locked == 'yes')

                        <small class="text-muted type-post"
                               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.content_locked'), config("app.locale"))}}">

                            <i class="feather icon-lock mr-1"></i>

                            @if (auth()->check() && $response->price != 0.00
                                    && $checkUserSubscription
                                    && ! $checkPayPerView
                                    || auth()->check() && $response->price != 0.00
                                    && ! $checkUserSubscription
                                    && ! $checkPayPerView
                                )
                                {{ Helper::amountFormatDecimal($response->price) }}

                            @elseif (auth()->check() && $checkPayPerView)
                                {{ __('general.paid') }}
                            @endif
                        </small>
                    @endif
                </div><!-- media body -->
            </div><!-- media -->
        </div><!-- card body -->

        @if (auth()->check() && auth()->user()->id == $response->user()->id
            || $response->locked == 'yes' && $mediaCount != 0

            || auth()->check() && $response->locked == 'yes'
            && $checkUserSubscription
            && $response->price == 0.00

            || auth()->check() && $response->locked == 'yes'
            && $checkUserSubscription
            && $response->price != 0.00
            && $checkPayPerView

            || auth()->check() && $response->locked == 'yes'
            && $response->price != 0.00
            && ! $checkUserSubscription
            && $checkPayPerView

            || auth()->check() && auth()->user()->role == 'admin' && auth()->user()->permission == 'all'
            || $response->locked == 'no'
            )
            <div class="card-body pt-0 pb-3">
                <p class="mb-0 update-text position-relative text-word-break">
                    {!! Helper::linkText(Helper::checkText($response->description, $isVideoEmbed ?? null)) !!}
                </p>
            </div>
        @endif

        @if (auth()->check() && auth()->user()->id == $response->user()->id

        || auth()->check() && $response->locked == 'yes'
        && $checkUserSubscription
        && $response->price == 0.00

        || auth()->check() && $response->locked == 'yes'
        && $checkUserSubscription
        && $response->price != 0.00
        && $checkPayPerView

        || auth()->check() && $response->locked == 'yes'
        && $response->price != 0.00
        && ! $checkUserSubscription
        && $checkPayPerView

        || auth()->check() && auth()->user()->role == 'admin' && auth()->user()->permission == 'all'
        || $response->locked == 'no'
        )

            <div class="btn-block">

                @if ($mediaImageVideoTotal <> 0)
                    @include('includes.media-post')
                @endif

                @foreach ($response->media as $media)
                    @if ($media->music != '')
                        <div class="mx-3 border rounded @if ($mediaCount > 1) mt-3 @endif">
                            <audio id="music-{{$media->id}}"
                                   class="js-player w-100 @if (!request()->ajax())invisible @endif" controls>
                                <source src="{{ Helper::getFile(config('path.music').$media->music) }}"
                                        type="audio/mp3">
                                Your browser does not support the audio tag.
                            </audio>
                        </div>
                    @endif

                    @if ($media->file != '')
                        <a href="{{url('download/file', $response->id)}}"
                           class="d-block text-decoration-none @if ($mediaCount > 1) mt-3 @endif">
                            <div class="card mb-3 mx-3">
                                <div class="row no-gutters">
                                    <div class="col-md-2 text-center bg-primary">
                                        <i class="far fa-file-archive m-4 text-white" style="font-size: 48px;"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary text-truncate mb-0">
                                                {{ $media->file_name }}.zip
                                            </h5>
                                            <p class="card-text">
                                                <small class="text-muted">{{ $media->file_size }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach

                @if ($isVideoEmbed)

                    @if (in_array(Helper::videoUrl($isVideoEmbed), array('youtube.com','www.youtube.com','youtu.be','www.youtu.be', 'm.youtube.com')))
                        <div class="embed-responsive embed-responsive-16by9 mb-2">
                            <iframe class="embed-responsive-item" height="360"
                                    src="https://www.youtube.com/embed/{{ Helper::getYoutubeId($isVideoEmbed) }}"
                                    allowfullscreen></iframe>
                        </div>
                    @endif

                    @if (in_array(Helper::videoUrl($isVideoEmbed), array('vimeo.com','player.vimeo.com')))
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                    src="https://player.vimeo.com/video/{{ Helper::getVimeoId($isVideoEmbed) }}"
                                    allowfullscreen></iframe>
                        </div>
                    @endif

                @endif

            </div><!-- btn-block -->

        @else

            <div class="btn-block p-sm text-center content-locked pt-lg pb-lg px-3 {{$textWhite}}"
                 style="{{$backgroundPostLocked}}">
                <span class="btn-block text-center mb-3"><i
                        class="feather icon-lock ico-no-result border-0 {{$textWhite}}"></i></span>

                @if ($response->user()->planActive() && $response->price == 0.00
                        || $response->user()->free_subscription == 'yes' && $response->price == 0.00)
                    <a href="javascript:void(0);" @guest data-toggle="modal" data-target="#loginFormModal"
                       @else @if ($response->user()->free_subscription == 'yes') data-toggle="modal"
                       data-target="#subscriptionFreeForm" @else data-toggle="modal" data-target="#subscriptionForm"
                       @endif @endguest class="btn btn-primary w-100">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.content_locked_user_logged'), config("app.locale")) }}
                    </a>
                @elseif ($response->user()->planActive() && $response->price != 0.00
                        || $response->user()->free_subscription == 'yes' && $response->price != 0.00)
                    <a href="javascript:void(0);" @guest data-toggle="modal" data-target="#loginFormModal"
                       @else @if ($response->status == 'active') data-toggle="modal" data-target="#payPerViewForm"
                       data-mediaid="{{$response->id}}"
                       data-price="{{Helper::amountFormatDecimal($response->price, true)}}"
                       data-subtotalprice="{{Helper::amountFormatDecimal($response->price)}}"
                       data-pricegross="{{$response->price}}" @endif @endguest class="btn btn-primary w-100">
                        @guest
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.content_locked_user_logged'), config("app.locale")) }}
                        @else

                            @if ($response->status == 'active')
                                <i class="feather icon-unlock mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.unlock_post_for'), config("app.locale")) }} {{Helper::amountFormatDecimal($response->price)}}

                            @else
                                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.post_pending_review'), config("app.locale")) }}
                            @endif
                        @endguest
                    </a>
                @else
                    <a href="javascript:void(0);" class="btn btn-primary disabled w-100">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription_not_available'), config("app.locale")) }}
                    </a>
                @endif

                <ul class="list-inline mt-3">

                    @if ($mediaCount == 0)
                        <li class="list-inline-item"><i class="bi bi-file-font"></i> {{ __('admin.text') }}</li>
                    @endif

                    @if ($mediaCount != 0)
                        @foreach ($allFiles as $media)

                            @if ($media->type == 'image')
                                <li class="list-inline-item"><i class="feather icon-image"></i> {{$countFilesImage}}
                                </li>
                            @endif

                            @if ($media->type == 'video')
                                <li class="list-inline-item"><i class="feather icon-video"></i> {{$countFilesVideo}}
                                </li>
                            @endif

                            @if ($media->type == 'music')
                                <li class="list-inline-item"><i class="feather icon-mic"></i> {{$countFilesAudio}}</li>
                            @endif

                            @if ($media->type == 'file')
                                <li class="list-inline-item"><i class="far fa-file-archive"></i> {{$media->file_size}}
                                </li>
                            @endif

                        @endforeach
                    @endif
                </ul>

            </div><!-- btn-block parent -->

        @endif

        @if ($response->status == 'active')
            <div class="card-footer bg-white border-top-0 rounded-large">
                <h4>
                    @php
                        $likeActive = auth()->check() && auth()->user()->likes()->where('updates_id', $response->id)->where('status','1')->first();
                        $bookmarkActive = auth()->check() && auth()->user()->bookmarks()->where('updates_id', $response->id)->first();

                        if(auth()->check() && auth()->user()->id == $response->user()->id

                        || auth()->check() && $response->locked == 'yes'
                        && $checkUserSubscription
                        && $response->price == 0.00

                        || auth()->check() && $response->locked == 'yes'
                        && $checkUserSubscription
                        && $response->price != 0.00
                        && $checkPayPerView

                        || auth()->check() && $response->locked == 'yes'
                        && $response->price != 0.00
                        && ! $checkUserSubscription
                        && $checkPayPerView

                        || auth()->check() && auth()->user()->role == 'admin' && auth()->user()->permission == 'all'
                        || auth()->check() && $response->locked == 'no') {
                            $buttonLike = 'likeButton';
                            $buttonBookmark = 'btnBookmark';
                        } else {
                            $buttonLike = null;
                            $buttonBookmark = null;
                        }
                    @endphp

                    <a href="javascript:void(0);" @guest data-toggle="modal" data-target="#loginFormModal"
                       @endguest class="pulse-btn btnLike @if ($likeActive)active @endif {{$buttonLike}} text-muted mr-2"
                       @auth data-id="{{$response->id}}" @endauth>
                        <i class="@if($likeActive)fas @else far @endif fa-heart"></i>
                        <small class="font-weight-bold countLikes">{{ $totalLikes == 0 ? null : $totalLikes }}</small>
                    </a>

                    <span
                        class="text-muted mr-2 @auth @if (! isset($inPostDetail) && $buttonLike) pulse-btn toggleComments @endif @endauth">
				<i class="far fa-comment"></i>
				<small class="font-weight-bold totalComments">{{ $totalComments == 0 ? null : $totalComments }}</small>
			</span>

                    <a href="javascript:void(0);"
                       title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.share'), config("app.locale"))}}"
                       data-toggle="modal"
                       data-target="#sharePost{{$response->id}}" class="pulse-btn text-muted text-decoration-none mr-2">
                        <i class="feather icon-share"></i>
                    </a>

                    <!-- Share modal -->
                    <div class="modal fade" id="sharePost{{$response->id}}" tabindex="-1" role="dialog"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <button type="button" class="close close-inherit" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true"><i class="bi bi-x-lg"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{url($response->user()->username.'/post', $response->id).Helper::referralLink()}}"
                                                   title="Facebook" target="_blank"
                                                   class="social-share text-muted d-block text-center h6">
                                                    <i class="fab fa-facebook-square facebook-btn"></i>
                                                    <span class="btn-block mt-3">Facebook</span>
                                                </a>
                                            </div>
                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="https://twitter.com/intent/tweet?url={{url($response->user()->username.'/post', $response->id).Helper::referralLink()}}&text={{ e( $response->user()->hide_name == 'yes' ? $response->user()->username : $response->user()->name ) }}"
                                                   data-url="{{url($response->user()->username.'/post', $response->id)}}"
                                                   class="social-share text-muted d-block text-center h6"
                                                   target="_blank" title="Twitter">
                                                    <i class="fab fa-twitter twitter-btn"></i> <span
                                                        class="btn-block mt-3">Twitter</span>
                                                </a>
                                            </div>
                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="whatsapp://send?text={{url($response->user()->username.'/post', $response->id).Helper::referralLink()}}"
                                                   data-action="share/whatsapp/share"
                                                   class="social-share text-muted d-block text-center h6"
                                                   title="WhatsApp">
                                                    <i class="fab fa-whatsapp btn-whatsapp"></i> <span
                                                        class="btn-block mt-3">WhatsApp</span>
                                                </a>
                                            </div>

                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="sms://?body={{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.check_this'), config("app.locale")) }} {{url($response->user()->username.'/post', $response->id).Helper::referralLink()}}"
                                                   class="social-share text-muted d-block text-center h6"
                                                   title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.sms'), config("app.locale")) }}">
                                                    <i class="fa fa-sms"></i> <span
                                                        class="btn-block mt-3">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.sms'), config("app.locale")) }}</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal share -->

                    @auth
                        @if (auth()->user()->id != $response->user()->id
                                    && $checkUserSubscription && $response->price == 0.00
                                    && $settings->disable_tips == 'off'

                                    || auth()->user()->id != $response->user()->id
                                    && $checkUserSubscription
                                    && $response->price != 0.00
                                    && $checkPayPerView
                                    && $settings->disable_tips == 'off'

                                    || auth()->check() && $response->locked == 'yes'
                                    && $response->price != 0.00
                                    && ! $checkUserSubscription
                                    && $checkPayPerView
                                    && $settings->disable_tips == 'off'

                                    || auth()->user()->id != $response->user()->id
                                    && $response->locked == 'no'
                                    && $settings->disable_tips == 'off'
                                    )
                            <a href="javascript:void(0);" data-toggle="modal"
                               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.tip'), config("app.locale"))}}"
                               data-target="#tipForm" class="pulse-btn text-muted text-decoration-none"
                               @auth data-id="{{$response->id}}"
                               data-cover="{{Helper::getFile(config('path.cover').$response->user()->cover)}}"
                               data-avatar="{{Helper::getFile(config('path.avatar').$response->user()->avatar)}}"
                               data-name="{{$response->user()->hide_name == 'yes' ? $response->user()->username : $response->user()->name}}"
                               data-userid="{{$response->user()->id}}" @endauth>
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                     class="bi bi-coin" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                                    <path fill-rule="evenodd"
                                          d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path fill-rule="evenodd"
                                          d="M8 13.5a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                </svg>

                                <h6 class="d-inline font-weight-lighter">@lang('general.tip')</h6>
                            </a>
                        @endif
                    @endauth

                    <a href="javascript:void(0);" @guest data-toggle="modal" data-target="#loginFormModal"
                       @endguest class="pulse-btn @if ($bookmarkActive) text-primary @else text-muted @endif float-right {{$buttonBookmark}}"
                       @auth data-id="{{$response->id}}" @endauth>
                        <i class="@if ($bookmarkActive)fas @else far @endif fa-bookmark"></i>
                    </a>
                </h4>

                @auth

                    @if (! auth()->user()->checkRestriction($response->user()->id))
                        <div class="container-comments @if ( ! isset($inPostDetail)) display-none @endif">

                            <div class="container-media">
                                @if($response->comments()->count() != 0)

                                    @php
                                        $comments = $response->comments()->take($settings->number_comments_show)->orderBy('id', 'DESC')->get();
                                        $data = [];

                                        if ($comments->count()) {
                                            $data['reverse'] = collect($comments->values())->reverse();
                                        } else {
                                            $data['reverse'] = $comments;
                                        }

                                        $dataComments = $data['reverse'];
                                          $counter = ($response->comments()->count() - $settings->number_comments_show);
                                    @endphp

                                    @if (auth()->user()->id == $response->user()->id

                                        || $response->locked == 'yes'
                                        && $checkUserSubscription
                                        && $response->price == 0.00

                                        || $response->locked == 'yes'
                                        && $checkUserSubscription
                                        && $response->price != 0.00
                                        && $checkPayPerView

                                        || auth()->check() && $response->locked == 'yes'
                                        && $response->price != 0.00
                                        && ! $checkUserSubscription
                                        && $checkPayPerView

                                        || auth()->user()->role == 'admin'
                                        && auth()->user()->permission == 'all'
                                        || $response->locked == 'no')

                                        @include('includes.comments')

                                    @endif

                                @endif
                            </div><!-- container-media -->

                            @if (auth()->user()->id == $response->user()->id

                                || $response->locked == 'yes'
                                && $checkUserSubscription
                                && $response->price == 0.00

                                || $response->locked == 'yes'
                                && $checkUserSubscription
                                && $response->price != 0.00
                                && $checkPayPerView

                                || auth()->check() && $response->locked == 'yes'
                                && $response->price != 0.00
                                && ! $checkUserSubscription
                                && $checkPayPerView

                                || auth()->user()->role == 'admin'
                                && auth()->user()->permission == 'all'
                                || $response->locked == 'no')

                                <hr/>

                                <div class="alert alert-danger alert-small dangerAlertComments display-none">
                                    <ul class="list-unstyled m-0 showErrorsComments"></ul>
                                </div><!-- Alert -->

                                <div class="media position-relative">
                                    <div class="blocked display-none"></div>
                                    <span href="#" class="float-left">
				<img src="{{ Helper::getFile(config('path.avatar').auth()->user()->avatar) }}"
                     class="rounded-circle mr-1 avatarUser" width="40">
			</span>
                                    <div class="media-body">
                                        <form action="{{url('comment/store')}}" method="post" class="comments-form">
                                            @csrf
                                            <input type="hidden" name="update_id" value="{{$response->id}}"/>

                                            <div>
					<span class="triggerEmoji" data-toggle="dropdown">
						<i class="bi-emoji-smile"></i>
					</span>

                                                <div class="dropdown-menu dropdown-menu-right dropdown-emoji"
                                                     aria-labelledby="dropdownMenuButton">
                                                    @include('includes.emojis')
                                                </div>
                                            </div>

                                            <input type="text" name="comment"
                                                   class="form-control comments emojiArea border-0" autocomplete="off"
                                                   placeholder="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.write_comment'), config("app.locale"))}}">
                                        </form>
                                    </div>
                                </div>
                            @endif

                        </div><!-- container-comments -->
                    @endif

                @endauth
            </div><!-- card-footer -->
        @endif
    </div><!-- card -->
@endforeach

@if (! isset($singlePost))
    <div class="card mb-3 pb-4 loadMoreSpin d-none rounded-large shadow-large">
        <div class="card-body">
            <div class="media">
		<span class="rounded-circle mr-3">
			<span class="item-loading position-relative loading-avatar"></span>
		</span>
                <div class="media-body">
                    <h5 class="mb-0 item-loading position-relative loading-name"></h5>
                    <small class="text-muted item-loading position-relative loading-time"></small>
                </div>
            </div>
        </div>
        <div class="card-body pt-0 pb-3">
            <p class="mb-1 item-loading position-relative loading-text-1"></p>
            <p class="mb-1 item-loading position-relative loading-text-2"></p>
            <p class="mb-0 item-loading position-relative loading-text-3"></p>
        </div>
    </div>
@endif

@php
    if (isset($ajaxRequest)) {
        $totalPosts = $total;
    } else {
        $totalPosts = $updates->total();
    }
@endphp

@if ($totalPosts > $settings->number_posts_show && $counterPosts >= 1)
    <button rel="next" class="btn btn-primary w-100 text-center loadPaginator d-none" id="paginator">
        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.loadmore'), config("app.locale"))}}
    </button>
@endif
