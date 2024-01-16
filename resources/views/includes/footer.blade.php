<!-- FOOTER -->
<<<<<<< HEAD
<div class="py-5 @if (Auth::check() && auth()->user()->dark_mode == 'off' || Auth::guest() ) footer_background_color footer_text_color @else bg-white @endif @if (Auth::check() && auth()->user()->dark_mode == 'off' && $settings->footer_background_color == '#ffffff' || Auth::guest() && $settings->footer_background_color == '#ffffff' ) border-top @endif">
<footer class="container">
  <div class="row">
    <div class="col-md-3">
      <a href="{{url('/')}}">
        @if (Auth::check() && auth()->user()->dark_mode == 'on' )
          <img src="{{url('public/img', $settings->logo)}}" alt="{{$settings->title}}" class="max-w-125">
        @else
          <img src="{{url('public/img', $settings->logo_2)}}" alt="{{$settings->title}}" class="max-w-125">
      @endif
      </a>
      @if($settings->twitter != ''
          || $settings->facebook != ''
          || $settings->instagram != ''
          || $settings->pinterest != ''
          || $settings->youtube != ''
          || $settings->github != ''
          || $settings->tiktok != ''
          || $settings->snapchat != ''
          )
      <div class="w-100">
        <span class="w-100">{{trans('general.keep_connect_with_us')}} {{trans('general.follow_us_social')}}</span>
        <ul class="list-inline list-social">
          @if ($settings->twitter != '')
          <li class="list-inline-item"><a href="{{$settings->twitter}}" target="_blank" class="ico-social"><i class="fab fa-twitter"></i></a></li>
        @endif

        @if ($settings->facebook != '')
          <li class="list-inline-item"><a href="{{$settings->facebook}}" target="_blank" class="ico-social"><i class="fab fa-facebook"></i></a></li>
          @endif

          @if ($settings->instagram != '')
          <li class="list-inline-item"><a href="{{$settings->instagram}}" target="_blank" class="ico-social"><i class="fab fa-instagram"></i></a></li>
        @endif

          @if ($settings->pinterest != '')
          <li class="list-inline-item"><a href="{{$settings->pinterest}}" target="_blank" class="ico-social"><i class="fab fa-pinterest"></i></a></li>
          @endif

          @if ($settings->youtube != '')
          <li class="list-inline-item"><a href="{{$settings->youtube}}" target="_blank" class="ico-social"><i class="fab fa-youtube"></i></a></li>
          @endif

          @if ($settings->github != '')
          <li class="list-inline-item"><a href="{{$settings->github}}" target="_blank" class="ico-social"><i class="fab fa-github"></i></a></li>
          @endif

          @if ($settings->tiktok != '')
          <li class="list-inline-item"><a href="{{$settings->tiktok}}" target="_blank" class="ico-social"><i class="bi bi-tiktok"></i></a></li>
          @endif

          @if ($settings->snapchat != '')
          <li class="list-inline-item"><a href="{{$settings->snapchat}}" target="_blank" class="ico-social"><i class="bi bi-snapchat"></i></a></li>
          @endif
        </ul>
      </div>
    @endif

    <li>
      <div id="installContainer" class="display-none">
        <button class="btn btn-primary w-100 rounded-pill mb-4" id="butInstall" type="button">
          <i class="bi-phone mr-1"></i> {{ __('general.install_web_app') }}
        </button>
      </div>
    </li>

    </div>
    <div class="col-md-3">
      <h6 class="text-uppercase">@lang('general.about')</h6>
      <ul class="list-unstyled">
        @foreach (Helper::pages() as $page)

      @if ($page->access == 'all')

          <li>
            <a class="link-footer" href="{{ url('/p', $page->slug) }}">
              {{ $page->title }}
            </a>
        </li>

      @elseif ($page->access == 'creators' && auth()->check() && auth()->user()->verified_id == 'yes')
          <li>
            <a class="link-footer" href="{{ url('/p', $page->slug) }}">
              {{ $page->title }}
            </a>
        </li>

      @elseif ($page->access == 'members' && auth()->check())
          <li>
            <a class="link-footer" href="{{ url('/p', $page->slug) }}">
              {{ $page->title }}
            </a>
        </li>
      @endif

    @endforeach
        <li><a class="link-footer" href="{{ url('contact') }}">{{ trans('general.contact') }}</a></li>

        @if (App\Models\Blogs::count() != 0)
          <li><a class="link-footer" href="{{ url('blog') }}">{{ trans('general.blog') }}</a></li>
        @endif
      </ul>
    </div>
    @if (Categories::count() != 0)
    <div class="col-md-3">
      <h6 class="text-uppercase">@lang('general.categories')</h6>
      <ul class="list-unstyled">
        @foreach (Categories::where('mode','on')->orderBy('name')->take(6)->get() as $category)
        <li>
          <a class="link-footer" href="{{ url('category', $category->slug) }}">
            {{ Lang::has('categories.' . $category->slug) ? __('categories.' . $category->slug) : $category->name }}
          </a>
        </li>
        @endforeach

        @if (Categories::count() > 6)
          <li><a class="link-footer btn-arrow" href="{{ url('creators') }}">{{ trans('general.explore') }}</a></li>
          @endif
      </ul>
    </div>
  @endif
    <div class="col-md-3">
      <h6 class="text-uppercase">@lang('general.links')</h6>
      <ul class="list-unstyled">
      @guest
        <li><a class="link-footer" href="{{$settings->home_style == 0 ? url('login') : url('/')}}">{{ trans('auth.login') }}</a></li><li>
          @if ($settings->registration_active == '1')
        <li><a class="link-footer" href="{{$settings->home_style == 0 ? url('signup') : url('/')}}">{{ trans('auth.sign_up') }}</a></li><li>
        @endif
        @else
          <li><a class="link-footer url-user" href="{{ url(Auth::User()->username) }}">{{ auth()->user()->verified_id == 'yes' ? trans('general.my_page') : trans('users.my_profile') }}</a></li><li>
          <li><a class="link-footer" href="{{ url('settings/page') }}">{{ auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile')}}</a></li><li>
          <li><a class="link-footer" href="{{ url('my/subscriptions') }}">{{ trans('users.my_subscriptions') }}</a></li><li>
          <li><a class="link-footer" href="{{ url('logout') }}">{{ trans('users.logout') }}</a></li><li>
      @endguest

      @guest
        <li class="dropdown mt-1">
          <a class="btn btn-outline-secondary rounded-pill mt-2 dropdown-toggle px-4 dropdown-toggle text-decoration-none" href="javascript:;" data-toggle="dropdown">
            <i class="feather icon-globe mr-1"></i>
            @foreach (Languages::orderBy('name')->get() as $languages)
              @if ($languages->abbreviation == config('app.locale') ) {{ $languages->name }}  @endif
            @endforeach
        </a>

        <div class="dropdown-menu">
          @foreach (Languages::orderBy('name')->get() as $languages)
            <a @if ($languages->abbreviation != config('app.locale')) href="{{ url('lang', $languages->abbreviation) }}" @endif class="dropdown-item mb-1 dropdown-lang @if( $languages->abbreviation == config('app.locale') ) active text-white @endif">
            @if ($languages->abbreviation == config('app.locale')) <i class="fa fa-check mr-1"></i> @endif {{ $languages->name }}
            </a>
            @endforeach
        </div>
        </li>

      @endguest

      </ul>
    </div>
  </div>
</footer>
</div>

<footer class="py-3 @if (Auth::check() && auth()->user()->dark_mode == 'off' || Auth::guest() ) footer_background_color @endif text-center">
  <div class="container">
    <div class="row">
      <div class="col-md-12 copyright">
        &copy; {{date('Y')}} {{$settings->title}}
      </div>
    </div>
  </div>
=======
<div
    class="py-5 @if (Auth::check() && auth()->user()->dark_mode == 'off' || Auth::guest() ) footer_background_color footer_text_color @else bg-white @endif @if (Auth::check() && auth()->user()->dark_mode == 'off' && $settings->footer_background_color == '#ffffff' || Auth::guest() && $settings->footer_background_color == '#ffffff' ) border-top @endif">
    <footer class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="{{url('/')}}">
                    @if (Auth::check() && auth()->user()->dark_mode == 'on' )
                        <img src="{{url('img', $settings->logo)}}" alt="{{$settings->title}}" class="max-w-125">
                    @else
                        <img src="{{url('img', $settings->logo_2)}}" alt="{{$settings->title}}"
                             class="max-w-125">
                    @endif
                </a>
                @if($settings->twitter != ''
                    || $settings->facebook != ''
                    || $settings->instagram != ''
                    || $settings->pinterest != ''
                    || $settings->youtube != ''
                    || $settings->github != ''
                    || $settings->tiktok != ''
                    || $settings->snapchat != ''
                    )
                    <div class="w-100">
                        <span
                            class="w-100">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.keep_connect_with_us'), config('app.locale'))}}
                            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.follow_us_social'),config('app.locale'))}}</span>
                        <ul class="list-inline list-social">
                            @if ($settings->twitter != '')
                                <li class="list-inline-item"><a href="{{$settings->twitter}}" target="_blank"
                                                                class="ico-social"><i class="fab fa-twitter"></i></a>
                                </li>
                            @endif

                            @if ($settings->facebook != '')
                                <li class="list-inline-item"><a href="{{$settings->facebook}}" target="_blank"
                                                                class="ico-social"><i class="fab fa-facebook"></i></a>
                                </li>
                            @endif

                            @if ($settings->instagram != '')
                                <li class="list-inline-item"><a href="{{$settings->instagram}}" target="_blank"
                                                                class="ico-social"><i class="fab fa-instagram"></i></a>
                                </li>
                            @endif

                            @if ($settings->pinterest != '')
                                <li class="list-inline-item"><a href="{{$settings->pinterest}}" target="_blank"
                                                                class="ico-social"><i class="fab fa-pinterest"></i></a>
                                </li>
                            @endif

                            @if ($settings->youtube != '')
                                <li class="list-inline-item"><a href="{{$settings->youtube}}" target="_blank"
                                                                class="ico-social"><i class="fab fa-youtube"></i></a>
                                </li>
                            @endif

                            @if ($settings->github != '')
                                <li class="list-inline-item"><a href="{{$settings->github}}" target="_blank"
                                                                class="ico-social"><i class="fab fa-github"></i></a>
                                </li>
                            @endif

                            @if ($settings->tiktok != '')
                                <li class="list-inline-item"><a href="{{$settings->tiktok}}" target="_blank"
                                                                class="ico-social"><i class="bi bi-tiktok"></i></a></li>
                            @endif

                            @if ($settings->snapchat != '')
                                <li class="list-inline-item"><a href="{{$settings->snapchat}}" target="_blank"
                                                                class="ico-social"><i class="bi bi-snapchat"></i></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif

                <li>
                    <div id="installContainer" class="display-none">
                        <button class="btn btn-primary w-100 rounded-pill mb-4" id="butInstall" type="button">
                            <i class="bi-phone mr-1"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.install_web_app'), config('app.locale')) }}
                        </button>
                    </div>
                </li>

            </div>
            <div class="col-md-3">
                <h6 class="text-uppercase">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.about'), config('app.locale'))}}</h6>
                <ul class="list-unstyled">
                    @foreach (Helper::pages() as $page)

                        @if ($page->access == 'all')

                            <li>
                                <a class="link-footer" href="{{ url('/p', $page->slug) }}">
                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($page->title, config('app.locale')) }}
                                </a>
                            </li>

                        @elseif ($page->access == 'creators' && auth()->check() && auth()->user()->verified_id == 'yes')
                            <li>
                                <a class="link-footer" href="{{ url('/p', $page->slug) }}">
                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($page->title, config('app.locale')) }}
                                </a>
                            </li>

                        @elseif ($page->access == 'members' && auth()->check())
                            <li>
                                <a class="link-footer" href="{{ url('/p', $page->slug) }}">
                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($page->title, config('app.locale')) }}
                                </a>
                            </li>
                        @endif

                    @endforeach
                    <li><a class="link-footer"
                           href="{{ url('contact') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.contact'), config('app.locale')) }}</a>
                    </li>

                    @if (App\Models\Blogs::count() != 0)
                        <li><a class="link-footer"
                               href="{{ url('blog') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.blog'), config('app.locale')) }}</a>
                        </li>
                    @endif
                </ul>
            </div>
            @if (Categories::count() != 0)
                <div class="col-md-3">
                    <h6 class="text-uppercase">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.categories'), config('app.locale')) }}</h6>
                    <ul class="list-unstyled">
                        @foreach (Categories::where('mode','on')->orderBy('name')->take(6)->get() as $category)
                            <li>
                                <a class="link-footer" href="{{ url('category', $category->slug) }}">
                                    {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(Lang::has('categories.' . $category->slug) ? __('categories.' . $category->slug) : $category->name, config('app.locale')) }}
                                </a>
                            </li>
                        @endforeach

                        @if (Categories::count() > 6)
                            <li><a class="link-footer btn-arrow"
                                   href="{{ url('creators') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore'), config('app.locale')) }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
            <div class="col-md-3">
                <h6 class="text-uppercase">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.links'), config('app.locale')) }}</h6>
                <ul class="list-unstyled">
                    @guest
                        <li><a class="link-footer"
                               href="{{$settings->home_style == 0 ? url('login') : url('/')}}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.login'), config('app.locale')) }}</a>
                        </li>
                        <li>
                        @if ($settings->registration_active == '1')
                            <li><a class="link-footer"
                                   href="{{$settings->home_style == 0 ? url('signup') : url('/')}}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.sign_up'), config('app.locale')) }}</a>
                            </li>
                            <li>
                        @endif
                    @else
                        <li><a class="link-footer url-user"
                               href="{{ url(Auth::User()->username) }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.my_page') : trans('users.my_profile'), config('app.locale')) }}</a>
                        </li>
                        <li>
                        <li><a class="link-footer"
                               href="{{ url('settings/page') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile'), config('app.locale'))}}</a>
                        </li>
                        <li>
                        <li><a class="link-footer"
                               href="{{ url('my/subscriptions') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscriptions'), config('app.locale')) }}</a>
                        </li>
                        <li>
                        <li><a class="link-footer"
                               href="{{ url('logout') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.logout'), config('app.locale')) }}</a>
                        </li>
                        <li>
                    @endguest

                    @guest
                        <li class="dropdown mt-1">
                            <a class="btn btn-outline-secondary rounded-pill mt-2 dropdown-toggle px-4 dropdown-toggle text-decoration-none"
                               href="javascript:void(0);" data-toggle="dropdown">
                                <i class="feather icon-globe mr-1"></i>
                                @foreach (Languages::orderBy('name')->get() as $languages)
                                    @if ($languages->abbreviation == config('app.locale') ) {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($languages->name, config('app.locale')) }}  @endif
                                @endforeach
                            </a>

                            <div class="dropdown-menu" id="selectLang">
                                @foreach (Languages::orderBy('name')->get() as $languages)
                                    <a @if ($languages->abbreviation != config('app.locale')) href="{{ url('lang', Str::lower($languages->abbreviation)) }}"
                                       @endif class="dropdown-item mb-1 dropdown-lang @if( $languages->abbreviation == config('app.locale') ) active text-white @endif">
                                        @if ($languages->abbreviation == config('app.locale')) <i
                                            class="fa fa-check mr-1"></i> @endif {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($languages->name, config('app.locale')) }}
                                    </a>
                                @endforeach
                            </div>
                        </li>

                    @endguest

                </ul>
            </div>
        </div>
    </footer>
</div>

<footer
    class="py-3 @if (Auth::check() && auth()->user()->dark_mode == 'off' || Auth::guest() ) footer_background_color @endif text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 copyright">
                &copy; {{date('Y')}} {{\Stichoza\GoogleTranslate\GoogleTranslate::trans($settings->title, config('app.locale'))}}
            </div>
        </div>
    </div>
>>>>>>> main
</footer>
