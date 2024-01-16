<div class="menuMobile w-100 bg-white shadow-lg p-3 border-top">
<<<<<<< HEAD
	<ul class="list-inline d-flex bd-highlight m-0 text-center">

		<li class="flex-fill bd-highlight">
			<a class="p-3 btn-mobile" href="{{url('/')}}" title="{{trans('admin.home')}}">
				<i class="feather icon-home icon-navbar"></i>
			</a>
		</li>

		<li class="flex-fill bd-highlight">
			<a class="p-3 btn-mobile" href="{{url('creators')}}" title="{{trans('general.explore')}}">
				<i class="far	fa-compass icon-navbar"></i>
			</a>
		</li>

		@if ($settings->shop)
		<li class="flex-fill bd-highlight">
			<a class="p-3 btn-mobile" href="{{url('shop')}}" title="{{trans('general.shop')}}">
				<i class="feather icon-shopping-bag icon-navbar"></i>
			</a>
		</li>
		@endif

		<li class="flex-fill bd-highlight">
			<a href="{{url('messages')}}" class="p-3 btn-mobile position-relative" title="{{ trans('general.messages') }}">

				<span class="noti_msg notify @if (auth()->user()->messagesInbox() != 0) d-block @endif">
					{{ auth()->user()->messagesInbox() }}
				</span>

				<i class="feather icon-send icon-navbar"></i>
			</a>
		</li>

		<li class="flex-fill bd-highlight">
			<a href="{{url('notifications')}}" class="p-3 btn-mobile position-relative" title="{{ trans('general.notifications') }}">
				<span class="noti_notifications notify @if (auth()->user()->notifications()->where('status', '0')->count()) d-block @endif">
					{{ auth()->user()->notifications()->where('status', '0')->count() }}
				</span>
				<i class="far fa-bell icon-navbar"></i>
			</a>
		</li>
	</ul>
</div>
=======
    <ul class="list-inline d-flex bd-highlight m-0 text-center">

        <li class="flex-fill bd-highlight">
            <a class="p-3 btn-mobile" href="{{url('/')}}"
               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.home'), config("app.locale"))}}">
                <i class="feather icon-home icon-navbar"></i>
            </a>
        </li>

        <li class="flex-fill bd-highlight">
            <a class="p-3 btn-mobile" href="{{url('creators')}}"
               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore'), config("app.locale"))}}">
                <i class="far	fa-compass icon-navbar"></i>
            </a>
        </li>

        @if ($settings->shop)
            <li class="flex-fill bd-highlight">
                <a class="p-3 btn-mobile" href="{{url('shop')}}"
                   title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.shop'), config("app.locale"))}}">
                    <i class="feather icon-shopping-bag icon-navbar"></i>
                </a>
            </li>
        @endif

        <li class="flex-fill bd-highlight">
            <a href="{{url('messages')}}" class="p-3 btn-mobile position-relative"
               title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.messages'), config("app.locale")) }}">

					<span class="noti_msg notify @if (auth()->user()->messagesInbox() != 0) d-block @endif">
						{{ auth()->user()->messagesInbox() }}
						</span>

                <i class="feather icon-send icon-navbar"></i>
            </a>
        </li>

        <li class="flex-fill bd-highlight">
            <a href="{{url('notifications')}}" class="p-3 btn-mobile position-relative"
               title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.notifications'), config("app.locale")) }}">
					<span
                        class="noti_notifications notify @if (auth()->user()->notifications()->where('status', '0')->count()) d-block @endif">
						{{ auth()->user()->notifications()->where('status', '0')->count() }}
						</span>
                <i class="far fa-bell icon-navbar"></i>
            </a>
        </li>
    </ul>
</div>
>>>>>>> main
