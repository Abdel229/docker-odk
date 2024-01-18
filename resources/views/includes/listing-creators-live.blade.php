<div class="card card-updates h-100 card-user-profile shadow-sm">
    <div class="card-cover"
         style="background: @if ($response->user()->cover != '') url({{ Helper::getFile(config('path.cover').$response->user()->cover) }})  @endif #505050 center center; background-size: cover;"></div>
    <div class="card-avatar liveLink" data-url="{{ url('live', $response->user()->username) }}">

        <span
            class="live-span">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.live'), config("app.locale")) }}</span>
        <div class="live-pulse"></div>

        <a href="{{url('live', $response->user()->username)}}">
            <img src="{{Helper::getFile(config('path.avatar').$response->user()->avatar)}}" width="95" height="95"
                 alt="{{$response->user()->name}}" class="img-user-small">
        </a>
    </div>
    <div class="card-body text-center">
        <h6 class="card-title pt-4 mt-2 mb-0">
            {{$response->user()->hide_name == 'yes' ? $response->user()->username : $response->user()->name}}

            @if ($response->user()->verified_id == 'yes')
                <small class="verified mr-1"
                       title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.verified_account'), config("app.locale"))}}"
                       data-toggle="tooltip" data-placement="top">
                    <i class="bi bi-patch-check-fill"></i>
                </small>
            @endif

            @if ($response->user()->featured == 'yes')
                <small class="text-featured"
                       title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.creator_featured'), config("app.locale"))}}"
                       data-toggle="tooltip" data-placement="top">
                    <i class="fas fa fa-award"></i>
                </small>
            @endif
        </h6>

        <p class="m-0 py-2 text-muted card-text text-truncate">
            {{ Str::limit($response->name, 100, '...') }}
        </p>

        <a href="{{url('live', $response->user()->username)}}" class="btn btn-1 btn-sm btn-outline-primary">
            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.join'), config("app.locale"))}}

            @if ($response->user()->id != auth()->id() && $response->price != 0)
                {{ Helper::amountFormatDecimal($response->price) }}
            @endif
        </a>

    </div>
</div><!-- End Card -->
