<header>
    <nav
        class="navbar navbar-expand-lg navbar-inverse fixed-top p-nav @if(auth()->guest() && request()->path() == '/') scroll @else p-0 @if (request()->is('live/*')) d-none @endif  @if (request()->is('messages/*')) d-none d-lg-block shadow-sm @elseif(request()->is('messages')) shadow-sm @else shadow-custom @endif {{ auth()->check() && auth()->user()->dark_mode == 'on' ? 'bg-white' : 'navbar_background_color' }} link-scroll @endif">
        <div class="container-fluid d-flex position-relative">

            @auth
                <div class="buttons-mobile-nav d-lg-none">
                    <a class="btn-mobile-nav navbar-toggler-mobile" href="#" data-toggle="collapse"
                       data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" role="button">
                        <i class="feather icon-menu icon-navbar"></i>
                    </a>
                </div>
            @endauth

            <a class="navbar-brand" href="{{url('/')}}">
                @if (auth()->check() && auth()->user()->dark_mode == 'on' )
                    <img src="{{url('img', $settings->logo)}}" data-logo="{{$settings->logo}}"
                         data-logo-2="{{$settings->logo_2}}" alt="{{$settings->title}}"
                         class="logo align-bottom max-w-100"/>
                @else
                    <img
                        src="{{url('img', auth()->guest() && request()->path() == '/' ? $settings->logo : $settings->logo_2)}}"
                        data-logo="{{$settings->logo}}" data-logo-2="{{$settings->logo_2}}" alt="{{$settings->title}}"
                        class="logo align-bottom max-w-100"/>
                @endif
            </a>

            @guest
                <button class="navbar-toggler @if(auth()->guest() && request()->path() == '/') text-white @endif"
                        type="button" data-toggle="collapse" data-target="#navbarCollapse"
                        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
            @endguest

            <div class="collapse navbar-collapse navbar-mobile" id="navbarCollapse">

                <div class="d-lg-none text-right pr-2 mb-2">
                    <button type="button" class="navbar-toggler close-menu-mobile" data-toggle="collapse"
                            data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                @if (auth()->guest() && $settings->who_can_see_content == 'all' || auth()->check())
                    <ul class="navbar-nav mr-auto">
                        <form class="form-inline my-lg-0 position-relative" method="get" action="{{url('creators')}}">
                            <input id="searchCreatorNavbar"
                                   class="form-control search-bar @if(auth()->guest() && request()->path() == '/') border-0 @endif"
                                   type="text" required name="q" autocomplete="off" minlength="3"
                                   placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.find_user'), config("app.locale")) }}"
                                   aria-label="Search">
                            <button class="btn btn-outline-success my-sm-0 button-search e-none" type="submit"><i
                                    class="bi bi-search"></i></button>

                            <div class="dropdown-menu dd-menu-user position-absolute" style="width: 95%; top: 48px;"
                                 id="dropdownCreators">

                                <button type="button" class="d-none" id="triggerBtn" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"></button>

                                <div class="w-100 text-center display-none py-2" id="spinnerSearch">
                                    <span class="spinner-border spinner-border-sm align-middle text-primary"></span>
                                </div>

                                <div id="containerCreators"></div>

                                <div id="viewAll" class="display-none mt-2">
                                    <a class="dropdown-item border-top py-2 text-center"
                                       href="#">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.view_all'), config("app.locale")) }}</a>
                                </div>
                            </div><!-- dropdown-menu -->
                        </form>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{url('creators')}}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore'), config("app.locale"))}}</a>
                            </li>

                            @if ($settings->shop)
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{url('shop')}}">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.shop'), config("app.locale"))}}</a>
                                </li>
                            @endif
                        @endguest

                    </ul>
                @endif

                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item mr-1">
                            <a @if (request()->is('/') && $settings->home_style == 0 || request()->route()->named('profile') || request()->is('creators') || request()->is('creators/*') || request()->is('category/*') || request()->is('p/*') || request()->is('blog') || request()->is('blog/post/*') || request()->is('shop') || request()->is('shop/product/*')) data-toggle="modal"
                               data-target="#loginFormModal"
                               @endif class="nav-link login-btn @if ($settings->registration_active == '0')  btn btn-main btn-primary pr-3 pl-3 @endif"
                               href="{{$settings->home_style == 0 ? url('login') : url('/')}}">
                                {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.login'), config("app.locale"))}}
                            </a>
                        </li>

                        @if ($settings->registration_active == '1')
                            <li class="nav-item">
                                <a @if (request()->is('/') && $settings->home_style == 0 || request()->route()->named('profile') || request()->is('creators') || request()->is('creators/*') || request()->is('category/*') || request()->is('p/*') || request()->is('blog') || request()->is('blog/post/*') || request()->is('shop') || request()->is('shop/product/*')) data-toggle="modal"
                                   data-target="#loginFormModal"
                                   @endif class="toggleRegister nav-link btn btn-main btn-primary pr-3 pl-3 btn-arrow btn-arrow-sm"
                                   href="{{$settings->home_style == 0 ? url('signup') : url('/')}}">
                                    {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.getting_started'), config("app.locale"))}}
                                </a>
                            </li>
                        @endif

                    @else

                    <!-- ============ Menu Mobile ============-->

                        @if (auth()->user()->role == 'admin')
                            <li class="nav-item dropdown d-lg-none mt-2 border-bottom">
                                <a href="{{url('panel/admin')}}" class="nav-link px-2 link-menu-mobile py-1">
                                    <div>
                                        <i class="bi bi-speedometer2 mr-2"></i>
                                        <span
                                            class="d-lg-none">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.admin'), config("app.locale"))}}</span>
                                    </div>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown d-lg-none @if (auth()->user()->role != 'admin') mt-2 @endif">
                            <a href="{{url(auth()->user()->username)}}"
                               class="nav-link px-2 link-menu-mobile py-1 url-user">
                                <div>
                                    <img src="{{Helper::getFile(config('path.avatar').auth()->user()->avatar)}}"
                                         alt="User" class="rounded-circle avatarUser mr-1" width="20" height="20">
                                    <span
                                        class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.my_page') : trans('users.my_profile'), config("app.locale")) }}</span>
                                </div>
                            </a>
                        </li>

                        @if (auth()->user()->verified_id == 'yes')
                            <li class="nav-item dropdown d-lg-none">
                                <a href="{{url('dashboard')}}" class="nav-link px-2 link-menu-mobile py-1">
                                    <div>
                                        <i class="bi bi-speedometer2 mr-2"></i>
                                        <span
                                            class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.dashboard'), config("app.locale")) }}</span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item dropdown d-lg-none">
                                <a href="{{url('my/posts')}}" class="nav-link px-2 link-menu-mobile py-1">
                                    <div>
                                        <i class="feather icon-feather mr-2"></i>
                                        <span
                                            class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.my_posts'), config("app.locale")) }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown d-lg-none border-bottom">
                            <a href="{{url('my/bookmarks')}}" class="nav-link px-2 link-menu-mobile py-1">
                                <div>
                                    <i class="feather icon-bookmark mr-2"></i>
                                    <span
                                        class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.bookmarks'), config("app.locale")) }}</span>
                                </div>
                            </a>
                        </li>

                        @if (auth()->user()->verified_id == 'yes' || $settings->referral_system == 'on' || auth()->user()->balance != 0.00)
                            <li class="nav-item dropdown d-lg-none">
                                <a class="nav-link px-2 link-menu-mobile py-1 balance">
                                    <div>
                                        <i class="iconmoon icon-Dollar mr-2"></i>
                                        <span
                                            class="d-lg-none balance">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.balance'), config("app.locale")) }}: {{Helper::amountFormatDecimal(auth()->user()->balance)}}</span>
                                    </div>
                                </a>
                            </li>
                        @endif

                        @if ($settings->disable_wallet == 'on' && auth()->user()->wallet != 0.00 || $settings->disable_wallet == 'off')
                            <li class="nav-item dropdown d-lg-none border-bottom">
                                <a @if ($settings->disable_wallet == 'off') href="{{url('my/wallet')}}"
                                   @endif class="nav-link px-2 link-menu-mobile py-1">
                                    <div>
                                        <i class="iconmoon icon-Wallet mr-2"></i>
                                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.wallet'), config("app.locale")) }}
                                        : <span
                                            class="balanceWallet">{{Helper::userWallet()}}</span>
                                    </div>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->verified_id == 'yes')
                            <li class="nav-item dropdown d-lg-none">
                                <a href="{{url('my/subscribers')}}" class="nav-link px-2 link-menu-mobile py-1">
                                    <div>
                                        <i class="feather icon-users mr-2"></i>
                                        <span
                                            class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscribers'), config("app.locale")) }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown d-lg-none">
                            <a href="{{url('my/subscriptions')}}" class="nav-link px-2 link-menu-mobile py-1">
                                <div>
                                    <i class="feather icon-user-check mr-2"></i>
                                    <span
                                        class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscriptions'), config("app.locale")) }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item dropdown d-lg-none border-bottom">
                            <a href="{{url('my/purchases')}}" class="nav-link px-2 link-menu-mobile py-1">
                                <div>
                                    <i class="bi bi-bag-check mr-2"></i>
                                    <span
                                        class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.purchased'), config("app.locale")) }}</span>
                                </div>
                            </a>
                        </li>

                        @if (auth()->user()->verified_id == 'no' && auth()->user()->verified_id != 'reject')
                            <li class="nav-item dropdown d-lg-none">
                                <a href="{{url('settings/verify/account')}}"
                                   class="nav-link px-2 link-menu-mobile py-1">
                                    <div>
                                        <i class="feather icon-star mr-2"></i>
                                        <span
                                            class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.become_creator'), config("app.locale")) }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown d-lg-none">
                            <a href="{{auth()->user()->dark_mode == 'off' ? url('mode/dark') : url('mode/light')}}"
                               class="nav-link px-2 link-menu-mobile py-1">
                                <div>
                                    <i class="feather icon-{{ auth()->user()->dark_mode == 'off' ? 'moon' : 'sun'  }} mr-2"></i>
                                    <span
                                        class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->dark_mode == 'off' ? trans('general.dark_mode') : trans('general.light_mode'), config("app.locale")) }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item dropdown d-lg-none mb-2">
                            <a href="{{ url('logout') }}" class="nav-link px-2 link-menu-mobile py-1">
                                <div>
                                    <i class="feather icon-log-out mr-2"></i>
                                    <span
                                        class="d-lg-none">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.logout'), config("app.locale")) }}</span>
                                </div>
                            </a>
                        </li>
                        <!-- =========== End Menu Mobile ============-->


                        <li class="nav-item dropdown d-lg-block d-none">
                            <a class="nav-link px-2" href="{{url('/')}}"
                               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.home'), config("app.locale"))}}">
                                <i class="feather icon-home icon-navbar"></i>
                                <span
                                    class="d-lg-none align-middle ml-1">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.home'), config("app.locale"))}}</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown d-lg-block d-none">
                            <a class="nav-link px-2" href="{{url('creators')}}"
                               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore_creators'), config("app.locale"))}}">
                                <i class="far	fa-compass icon-navbar"></i>
                                <span
                                    class="d-lg-none align-middle ml-1">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.explore'), config("app.locale"))}}</span>
                            </a>
                        </li>

                        @if ($settings->shop)
                            <li class="nav-item dropdown d-lg-block d-none">
                                <a class="nav-link px-2" href="{{url('shop')}}"
                                   title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.shop'), config("app.locale"))}}">
                                    <i class="feather icon-shopping-bag icon-navbar"></i>
                                    <span
                                        class="d-lg-none align-middle ml-1">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.shop'), config("app.locale"))}}</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown d-lg-block d-none">
                            <a href="{{url('messages')}}" class="nav-link px-2"
                               title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.messages'), config("app.locale")) }}">

						<span class="noti_msg notify @if (auth()->user()->messagesInbox() != 0) d-block @endif">
							{{ auth()->user()->messagesInbox() }}
							</span>

                                <i class="feather icon-send icon-navbar"></i>
                                <span
                                    class="d-lg-none align-middle ml-1">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.messages'), config("app.locale")) }}</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown d-lg-block d-none">
                            <a href="{{url('notifications')}}" class="nav-link px-2"
                               title="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.notifications'), config("app.locale")) }}">

						<span
                            class="noti_notifications notify @if (auth()->user()->notifications()->where('status', '0')->count()) d-block @endif">
							{{ auth()->user()->notifications()->where('status', '0')->count() }}
							</span>

                                <i class="far fa-bell icon-navbar"></i>
                                <span
                                    class="d-lg-none align-middle ml-1">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.notifications'), config("app.locale")) }}</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown d-lg-block d-none">
                            <a class="nav-link" href="#" id="nav-inner-success_dropdown_1" role="button"
                               data-toggle="dropdown">
                                <img src="{{Helper::getFile(config('path.avatar').auth()->user()->avatar)}}" alt="User"
                                     class="rounded-circle avatarUser mr-1" width="28" height="28">
                                <span class="d-lg-none">{{auth()->user()->first_name}}</span>
                                <i class="feather icon-chevron-down m-0 align-middle"></i>
                            </a>
                            <div class="dropdown-menu mb-1 dropdown-menu-right dd-menu-user"
                                 aria-labelledby="nav-inner-success_dropdown_1">
                                @if(auth()->user()->role == 'admin')
                                    <a class="dropdown-item dropdown-navbar" href="{{url('panel/admin')}}"><i
                                            class="bi bi-speedometer2 mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.admin'), config("app.locale"))}}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endif

                                @if (auth()->user()->verified_id == 'yes' || $settings->referral_system == 'on' || auth()->user()->balance != 0.00)
                                    <span class="dropdown-item dropdown-navbar balance">
							<i class="iconmoon icon-Dollar mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.balance'), config("app.locale"))}}: {{Helper::amountFormatDecimal(auth()->user()->balance)}}
						</span>
                                @endif

                                @if ($settings->disable_wallet == 'on' && auth()->user()->wallet != 0.00 || $settings->disable_wallet == 'off')
                                    @if ($settings->disable_wallet == 'off')
                                        <a class="dropdown-item dropdown-navbar" href="{{url('my/wallet')}}">
                                            <i class="iconmoon icon-Wallet mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.wallet'), config("app.locale"))}}
                                            :
                                            <span class="balanceWallet">{{Helper::userWallet()}}</span>
                                        </a>
                                    @else
                                        <span class="dropdown-item dropdown-navbar balance">
								<i class="iconmoon icon-Wallet mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.wallet'), config("app.locale"))}}:
								<span class="balanceWallet">{{Helper::userWallet()}}</span>
							</span>
                                    @endif

                                    <div class="dropdown-divider"></div>
                                @endif

                                @if ($settings->disable_wallet == 'on' && auth()->user()->verified_id == 'yes')
                                    <div class="dropdown-divider"></div>
                                @endif

                                <a class="dropdown-item dropdown-navbar url-user"
                                   href="{{url(auth()->User()->username)}}"><i
                                        class="feather icon-user mr-2"></i> {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.my_page') : trans('users.my_profile'), config("app.locale")) }}
                                </a>
                                @if (auth()->user()->verified_id == 'yes')
                                    <a class="dropdown-item dropdown-navbar" href="{{url('dashboard')}}"><i
                                            class="bi bi-speedometer2 mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.dashboard'), config("app.locale"))}}
                                    </a>
                                    <a class="dropdown-item dropdown-navbar" href="{{url('my/posts')}}"><i
                                            class="feather icon-feather mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.my_posts'), config("app.locale"))}}
                                    </a>
                                @endif

                                <div class="dropdown-divider"></div>
                                @if (auth()->user()->verified_id == 'yes')
                                    <a class="dropdown-item dropdown-navbar" href="{{url('my/subscribers')}}"><i
                                            class="feather icon-users mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscribers'), config("app.locale"))}}
                                    </a>
                                @endif
                                <a class="dropdown-item dropdown-navbar" href="{{url('my/subscriptions')}}"><i
                                        class="feather icon-user-check mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscriptions'), config("app.locale"))}}
                                </a>
                                <a class="dropdown-item dropdown-navbar" href="{{url('my/bookmarks')}}"><i
                                        class="feather icon-bookmark mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.bookmarks'), config("app.locale"))}}
                                </a>

                                @if (auth()->user()->verified_id == 'no'
                                            && auth()->user()->verified_id != 'reject'
                                            && $settings->requests_verify_account == 'on'
                                            )
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item dropdown-navbar"
                                       href="{{url('settings/verify/account')}}"><i
                                            class="feather icon-star mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.become_creator'), config("app.locale"))}}
                                    </a>
                                @endif

                                <div class="dropdown-divider"></div>

                                @if (auth()->user()->dark_mode == 'off')
                                    <!--a class="dropdown-item dropdown-navbar" href="{{url('mode/dark')}}"><i
                                            class="feather icon-moon mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.dark_mode'), config("app.locale"))}}
                                    </a-->
                                @else
                                    <!--a class="dropdown-item dropdown-navbar" href="{{url('mode/light')}}"><i
                                            class="feather icon-sun mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.light_mode'), config("app.locale"))}}
                                    </a-->
                                @endif

                                <div class="dropdown-divider dropdown-navbar"></div>
                                <a class="dropdown-item dropdown-navbar" href="{{url('logout')}}"><i
                                        class="feather icon-log-out mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.logout'), config("app.locale"))}}
                                </a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link btn-arrow btn-arrow-sm btn btn-main btn-primary pr-3 pl-3"
                               href="{{url('settings/page')}}">
                                {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile'), config("app.locale"))}}</a>
                        </li>

                    @endguest

                </ul>
            </div>
        </div>
    </nav>
</header>
