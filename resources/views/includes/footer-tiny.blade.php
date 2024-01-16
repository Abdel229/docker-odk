<div class="card border-0 bg-transparent">
<<<<<<< HEAD
  <div class="card-body p-0">
    <small class="text-muted">&copy; {{date('Y')}} {{$settings->title}}</small>
    <ul class="list-inline mb-0 small">

      @foreach (Helper::pages() as $page)
        @if ($page->access == 'all')

          <li class="list-inline-item">
            <a class="link-footer footer-tiny" href="{{ url('/p', $page->slug) }}">
              {{ $page->title }}
            </a>
          </li>

        @elseif ($page->access == 'creators' && auth()->check() && auth()->user()->verified_id == 'yes')
          <li class="list-inline-item">
            <a class="link-footer footer-tiny" href="{{ url('/p', $page->slug) }}">
              {{ $page->title }}
            </a>
          </li>

        @elseif ($page->access == 'members' && auth()->check())
          <li class="list-inline-item">
            <a class="link-footer footer-tiny" href="{{ url('/p', $page->slug) }}">
              {{ $page->title }}
            </a>
          </li>
        @endif

      @endforeach
      <li class="list-inline-item"><a class="link-footer footer-tiny" href="{{ url('contact') }}">{{ trans('general.contact') }}</a></li>

      @if (App\Models\Blogs::count() != 0)
      <li class="list-inline-item"><a class="link-footer footer-tiny" href="{{ url('blog') }}">{{ trans('general.blog') }}</a></li>
    @endif

    @guest
    <div class="btn-group dropup d-inline">
      <li class="list-inline-item">
        <a class="link-footer dropdown-toggle text-decoration-none footer-tiny" href="javascript:;" data-toggle="dropdown">
          <i class="feather icon-globe"></i>
          @foreach (Languages::orderBy('name')->get() as $languages)
            @if( $languages->abbreviation == config('app.locale') ) {{ $languages->name }}  @endif
          @endforeach
      </a>

      <div class="dropdown-menu">
        @foreach (Languages::orderBy('name')->get() as $languages)
          <a @if ($languages->abbreviation != config('app.locale')) href="{{ url('lang', $languages->abbreviation) }}" @endif class="dropdown-item mb-1 @if( $languages->abbreviation == config('app.locale') ) active text-white @endif">
          @if ($languages->abbreviation == config('app.locale')) <i class="fa fa-check mr-1"></i> @endif {{ $languages->name }}
          </a>
          @endforeach
      </div>
      </li>
    </div><!-- dropup -->
    @endguest

    <li class="list-inline-item">
      <div id="installContainer" class="display-none">
        <a class="link-footer footer-tiny" id="butInstall" href="javascript:void(0);">
          <i class="bi-phone"></i> {{ __('general.install_web_app') }}
        </a>
      </div>
    </li>
    </ul>
  </div>
=======
    <div class="card-body p-0">
        <small
            class="text-muted">&copy; {{date('Y')}} {{\Stichoza\GoogleTranslate\GoogleTranslate::trans($settings->title, "fr")}}</small>
        <ul class="list-inline mb-0 small">

            @foreach (Helper::pages() as $page)
                @if ($page->access == 'all')

                    <li class="list-inline-item">
                        <a class="link-footer footer-tiny" href="{{ url('/p', $page->slug) }}">
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($page->title, "fr") }}
                        </a>
                    </li>

                @elseif ($page->access == 'creators' && auth()->check() && auth()->user()->verified_id == 'yes')
                    <li class="list-inline-item">
                        <a class="link-footer footer-tiny" href="{{ url('/p', $page->slug) }}">
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($page->title, "fr") }}
                        </a>
                    </li>

                @elseif ($page->access == 'members' && auth()->check())
                    <li class="list-inline-item">
                        <a class="link-footer footer-tiny" href="{{ url('/p', $page->slug) }}">
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($page->title, "fr") }}
                        </a>
                    </li>
                @endif

            @endforeach
            <li class="list-inline-item"><a class="link-footer footer-tiny"
                                            href="{{ url('contact') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.contact'), "fr") }}</a></li>

            @if (App\Models\Blogs::count() != 0)
                <li class="list-inline-item"><a class="link-footer footer-tiny"
                                                href="{{ url('blog') }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.blog'), "fr") }}</a></li>
            @endif

            @guest
                <div class="btn-group dropup d-inline">
                    <li class="list-inline-item">
                        <a class="link-footer dropdown-toggle text-decoration-none footer-tiny" href="javascript:void(0);"
                           data-toggle="dropdown">
                            <i class="feather icon-globe"></i>
                            @foreach (Languages::orderBy('name')->get() as $languages)
                                @if( $languages->abbreviation == config('app.locale') ) {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($languages->name, "fr") }}  @endif
                            @endforeach
                        </a>

                        <div class="dropdown-menu">
                            @foreach (Languages::orderBy('name')->get() as $languages)
                                <a @if ($languages->abbreviation != config('app.locale')) href="{{ url('lang', $languages->abbreviation) }}"
                                   @endif class="dropdown-item mb-1 @if( $languages->abbreviation == config('app.locale') ) active text-white @endif">
                                    @if ($languages->abbreviation == config('app.locale')) <i
                                        class="fa fa-check mr-1"></i> @endif {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($languages->name, "fr") }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                </div><!-- dropup -->
            @endguest

            <li class="list-inline-item">
                <div id="installContainer" class="display-none">
                    <a class="link-footer footer-tiny" id="butInstall" href="javascript:void(0);">
                        <i class="bi-phone"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.install_web_app'),"fr") }}
                    </a>
                </div>
            </li>
        </ul>
    </div>
>>>>>>> main
</div>
