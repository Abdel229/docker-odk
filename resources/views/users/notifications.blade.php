@extends('layouts.app')

@section('title'){{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.notifications'), config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat">
                        <i class="far fa-bell mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.notifications'), config("app.locale"))}}

                        <small class="font-tiny">
                            <a href="javascript:void(0);" class="btn-notify" data-toggle="modal"
                               data-target="#notifications"><i class="fa fa-cog mr-2"></i></a>

                            @if (count($notifications) != 0)
                                {!! Form::open([
                                              'method' => 'POST',
                                              'url' => "notifications/delete",
                                              'class' => 'd-inline'
                                          ]) !!}

                                {!! Form::button('<i class="fa fa-trash-alt"></i>', ['class' => 'btn btn-lg  align-baseline p-0 e-none btn-link actionDeleteNotify']) !!}
                                {!! Form::close() !!}
                            @endif
                        </small>
                    </h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.notifications_subtitle'), config("app.locale"))}}</p>
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

                    <?php

                    use Stichoza\GoogleTranslate\GoogleTranslate;
                    foreach ($notifications as $key) {

                    $postUrl = url($key->usernameAuthor . '/' . 'post', $key->id);
                    $notyNormal = true;

                    switch ($key->type) {
                        case 1:
                            $action = GoogleTranslate::trans(trans('users.has_subscribed'), config("app.locale"));
                            $linkDestination = false;
                            break;
                        case 2:
                            $action = GoogleTranslate::trans(trans('users.like_you'), config("app.locale"));
                            $linkDestination = $postUrl;
                            $text_link = Str::limit($key->description, 50, '...');
                            break;
                        case 3:
                            $action = GoogleTranslate::trans(trans('users.comment_you'), config("app.locale"));
                            $linkDestination = $postUrl;
                            $text_link = Str::limit($key->description, 50, '...');
                            break;

                        case 4:
                            $action = GoogleTranslate::trans(trans('general.liked_your_comment'), config("app.locale"));
                            $linkDestination = $postUrl;
                            $text_link = Str::limit($key->description, 50, '...');
                            break;

                        case 5:
                            $action = GoogleTranslate::trans(trans('general.he_sent_you_tip'), config("app.locale"));
                            $linkDestination = url('my/payments/received');
                            $text_link = GoogleTranslate::trans(trans('general.tip'), config("app.locale"));
                            break;

                        case 6:
                            $action = GoogleTranslate::trans(trans('general.has_bought_your_message'), config("app.locale"));
                            $linkDestination = url('messages', $key->userId);
                            $text_link = Str::limit($key->message, 50, '...');
                            break;

                        case 7:
                            $action = GoogleTranslate::trans(trans('general.has_bought_your_content'), config("app.locale"));
                            $linkDestination = $postUrl;
                            $text_link = Str::limit($key->description, 50, '...');
                            break;

                        case 8:
                            $action = GoogleTranslate::trans(trans('general.has_approved_your_post'), config("app.locale"));
                            $linkDestination = $postUrl;
                            $text_link = Str::limit($key->description, 50, '...');
                            $iconNotify = 'bi bi-check2-circle';
                            $notyNormal = false;
                            break;

                        case 9:
                            $action = GoogleTranslate::trans(trans('general.video_processed_successfully_post'), config("app.locale"));
                            $linkDestination = $postUrl;
                            $text_link = Str::limit($key->description, 50, '...');
                            $iconNotify = 'bi bi-play-circle';
                            $notyNormal = false;
                            break;

                        case 10:
                            $action = GoogleTranslate::trans(trans('general.video_processed_successfully_message'), config("app.locale"));
                            $linkDestination = url('messages', $key->userDestination);
                            $text_link = Str::limit($key->message, 50, '...');
                            $iconNotify = 'bi bi-play-circle';
                            $notyNormal = false;
                            break;

                        case 11:
                            $action = GoogleTranslate::trans(trans('general.referrals_made'), config("app.locale"));
                            $linkDestination = url('my/referrals');
                            $text_link = GoogleTranslate::trans(trans('general.transaction'), config("app.locale"));
                            $iconNotify = 'bi bi-person-plus';
                            $notyNormal = false;
                            break;

                        case 12:
                            $action = GoogleTranslate::trans(trans('general.payment_received_subscription_renewal'), config("app.locale"));
                            $linkDestination = url('my/payments/received');
                            $text_link = GoogleTranslate::trans(trans('general.go_payments_received'), config("app.locale"));
                            break;

                        case 13:
                            $action = GoogleTranslate::trans(trans('general.has_changed_subscription_paid'), config("app.locale"));
                            $linkDestination = url($key->username);
                            $text_link = GoogleTranslate::trans(trans('general.subscribe_now'), config("app.locale"));
                            break;

                        case 14:
                            $isLive = Helper::liveStatus($key->target);
                            $action = GoogleTranslate::trans($isLive ? trans('general.is_streaming_live') : trans('general.streamed_live'), config("app.locale"));
                            $linkDestination = url('live', $key->username);
                            $text_link = $isLive ? GoogleTranslate::trans(trans('general.go_live_stream'), config("app.locale")) : null;
                            break;

                        case 15:
                            $action = GoogleTranslate::trans(trans('general.has_bought_your_item'), config("app.locale"));
                            $linkDestination = url('my/sales');
                            $text_link = Str::limit($key->productName, 50, '...');
                            break;

                        case 16:
                            $action = GoogleTranslate::trans(trans('general.has_mentioned_you'), config("app.locale"));
                            $linkDestination = $postUrl;
                            $text_link = Str::limit($key->description, 50, '...');
                            break;
                    }

                    ?>

                    <div class="card mb-3 card-updates">
                        <div class="card-body">
                            <div class="media">

                                @if ($notyNormal)
                                    <span class="rounded-circle mr-3">
          			<a href="{{url($key->username)}}">
          				<img src="{{Helper::getFile(config('path.avatar').$key->avatar)}}" class="rounded-circle"
                             width="60" height="60" alt="">
          				</a>
          		</span>

                                @else

                                    <span class="rounded-circle mr-3">
                <span class="icon-notify">
                  <i class="{{ $iconNotify }}"></i>
                </span>
            </span>
                                @endif

                                <div class="media-body">
                                    <h6 class="mb-0 font-montserrat text-notify">

                                        @if ($notyNormal)
                                            <a href="{{url($key->username)}}">
                                                {{$key->hide_name == 'yes' ? $key->username : $key->name}}
                                            </a>
                                        @endif

                                        {{$action}}

                                        @if ($linkDestination != false)
                                            <a href="{{url($linkDestination)}}">{{$text_link}}</a>
                                        @endif
                                    </h6>

                                    <small class="timeAgo text-muted"
                                           data="{{date('c', strtotime($key->created_at))}}"></small>
                                </div><!-- media body -->
                            </div><!-- media -->
                        </div><!-- card body -->
                    </div>

                    <?php } //foreach ?>

                    @if (count($notifications) == 0)

                        <div class="my-5 text-center">
        <span class="btn-block mb-3">
          <i class="far fa-bell-slash ico-no-result"></i>
        </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_notifications'), config("app.locale"))}}</h4>
                        </div>
                    @endif

                    @if($notifications->hasPages())
                        {{ $notifications->onEachSide(0)->links() }}
                    @endif

                </div><!-- end col-md-6 -->

            </div>
        </div>
    </section>

    <div class="modal fade" id="notifications" tabindex="-1" role="dialog" aria-labelledby="modal-form"
         aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-white shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5">

                            <div class="mb-3">
                                <h6 class="position-relative">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.receive_notifications_when'), config("app.locale"))}}
                                    <small data-dismiss="modal" class="btn-cancel-msg"><i
                                            class="bi bi-x-lg"></i></small>
                                </h6>
                            </div>

                            <form method="POST" action="{{ url('notifications/settings') }}" id="form">

                                @csrf

                                @if (auth()->user()->verified_id == 'yes')
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="notify_new_subscriber"
                                               value="yes" @if (auth()->user()->notify_new_subscriber == 'yes') checked
                                               @endif id="customSwitch1">
                                        <label class="custom-control-label switch"
                                               for="customSwitch1">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_subscribed_content'), config("app.locale")) }}</label>
                                    </div>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="notify_liked_post"
                                               value="yes" @if (auth()->user()->notify_liked_post == 'yes') checked
                                               @endif id="customSwitch2">
                                        <label class="custom-control-label switch"
                                               for="customSwitch2">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_liked_post'), config("app.locale")) }}</label>
                                    </div>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="notify_commented_post"
                                               value="yes" @if (auth()->user()->notify_commented_post == 'yes') checked
                                               @endif id="customSwitch3">
                                        <label class="custom-control-label switch"
                                               for="customSwitch3">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_commented_post'), config("app.locale")) }}</label>
                                    </div>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="notify_new_tip"
                                               value="yes" @if (auth()->user()->notify_new_tip == 'yes') checked
                                               @endif id="customSwitch5">
                                        <label class="custom-control-label switch"
                                               for="customSwitch5">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_sent_tip'), config("app.locale")) }}</label>
                                    </div>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="notify_new_ppv"
                                               value="yes" @if (auth()->user()->notify_new_ppv == 'yes') checked
                                               @endif id="customSwitch9">
                                        <label class="custom-control-label switch"
                                               for="customSwitch9">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_bought_my_content'), config("app.locale")) }}</label>
                                    </div>
                                @endif

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="notify_liked_comment"
                                           value="yes" @if (auth()->user()->notify_liked_comment == 'yes') checked
                                           @endif id="customSwitch10">
                                    <label class="custom-control-label switch"
                                           for="customSwitch10">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_liked_comment'), config("app.locale")) }}</label>
                                </div>

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="notify_live_streaming"
                                           value="yes" @if (auth()->user()->notify_live_streaming == 'yes') checked
                                           @endif id="notify_live_streaming">
                                    <label class="custom-control-label switch"
                                           for="notify_live_streaming">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_live_streaming'), config("app.locale")) }}</label>
                                </div>

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="notify_mentions"
                                           value="yes" @if (auth()->user()->notify_mentions == 'yes') checked
                                           @endif id="notify_mentions">
                                    <label class="custom-control-label switch"
                                           for="notify_mentions">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_mentioned_me'), config("app.locale")) }}</label>
                                </div>

                                <div class="mt-3">
                                    <h6 class="position-relative">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.email_notification'), config("app.locale"))}}
                                    </h6>
                                </div>

                                @if (auth()->user()->verified_id == 'yes')
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="email_new_subscriber"
                                               value="yes" @if (auth()->user()->email_new_subscriber == 'yes') checked
                                               @endif id="customSwitch4">
                                        <label class="custom-control-label switch"
                                               for="customSwitch4">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_subscribed_content'), config("app.locale")) }}</label>
                                    </div>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="email_new_tip"
                                               value="yes" @if (auth()->user()->email_new_tip == 'yes') checked
                                               @endif id="customSwitch7">
                                        <label class="custom-control-label switch"
                                               for="customSwitch7">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_sent_tip'), config("app.locale")) }}</label>
                                    </div>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="email_new_ppv"
                                               value="yes" @if (auth()->user()->email_new_ppv == 'yes') checked
                                               @endif id="customSwitch8">
                                        <label class="custom-control-label switch"
                                               for="customSwitch8">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.someone_bought_my_content'), config("app.locale")) }}</label>
                                    </div>
                                @endif


                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="notify_email_new_post"
                                           value="yes" @if (auth()->user()->notify_email_new_post == 'yes') checked
                                           @endif id="customSwitch6">
                                    <label class="custom-control-label switch"
                                           for="customSwitch6">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.new_post_creators_subscribed'), config("app.locale")) }}</label>
                                </div>

                                <button type="submit" id="save"
                                        data-msg-success="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.success_update'), config("app.locale")) }}"
                                        class="btn btn-primary btn-sm mt-3 w-100"
                                        data-msg="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.save'), config("app.locale"))}}">
                                    {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.save'), config("app.locale"))}}
                                </button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Modal new Message -->
@endsection
