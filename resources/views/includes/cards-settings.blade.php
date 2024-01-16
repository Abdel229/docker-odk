<div class="col-md-6 col-lg-3 mb-3">

    <button type="button" class="btn-menu-expand btn btn-primary btn-block mb-2 d-lg-none" type="button"
            data-toggle="collapse" data-target="#navbarUserHome" aria-controls="navbarCollapse" aria-expanded="false">
        <i class="fa fa-bars mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.menu'), config("app.locale"))}}
    </button>

    <div class="navbar-collapse collapse d-lg-block" id="navbarUserHome">

        <!-- Start Account -->
        <div class="card shadow-sm card-settings mb-3">
            <div class="list-group list-group-sm list-group-flush">

                <small
                    class="text-muted px-4 pt-3 text-uppercase mb-1 font-weight-bold">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.account'), config("app.locale")) }}</small>

                @if (auth()->user()->verified_id == 'yes')
                    <a href="{{url('dashboard')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('dashboard')) active @endif">
                        <div>
                            <i class="bi bi-speedometer2 mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.dashboard'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                <a href="{{url(auth()->user()->username)}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between url-user">
                    <div>
                        <i class="feather icon-user mr-2"></i>
                        <span>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.my_page') : trans('users.my_profile'), config("app.locale")) }}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

                <a href="{{url('settings/page')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('settings/page')) active @endif">
                    <div>
                        <i class="bi bi-pencil mr-2"></i>
                        <span>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile'), config("app.locale"))}}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

                @if ($settings->disable_wallet == 'off')
                    <a href="{{url('my/wallet')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/wallet')) active @endif">
                        <div>
                            <i class="iconmoon icon-Wallet mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.wallet'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                @if ($settings->referral_system == 'on' || auth()->user()->referrals()->count() != 0)
                    <a href="{{url('my/referrals')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/referrals')) active @endif">
                        <div>
                            <i class="bi-person-plus mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.referrals'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                <a href="{{url('settings/verify/account')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('settings/verify/account')) active @endif">
                    <div>
                        <i class="@if (auth()->user()->verified_id == 'yes') feather icon-check-circle @else bi-star @endif mr-2"></i>
                        <span>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(auth()->user()->verified_id == 'yes' ? trans('general.verified_account') : trans('general.become_creator'), config("app.locale"))}}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

            </div>
        </div><!-- End Account -->

        <!-- Start Subscription -->
        <div class="card shadow-sm card-settings mb-3">
            <div class="list-group list-group-sm list-group-flush">

                <small
                    class="text-muted px-4 pt-3 text-uppercase mb-1 font-weight-bold">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription'), config("app.locale")) }}</small>

                @if (auth()->user()->verified_id == 'yes')
                    <a href="{{url('settings/subscription')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('settings/subscription')) active @endif">
                        <div>
                            <i class="bi bi-cash-stack mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.subscription_price'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                @if (auth()->user()->verified_id == 'yes')
                    <a href="{{url('my/subscribers')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/subscribers')) active @endif">
                        <div>
                            <i class="feather icon-users mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscribers'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                <a href="{{url('my/subscriptions')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/subscriptions')) active @endif">
                    <div>
                        <i class="feather icon-user-check mr-2"></i>
                        <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.my_subscriptions'), config("app.locale"))}}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

            </div>
        </div><!-- End Subscription -->

        <!-- Start Privacy and security -->
        <div class="card shadow-sm card-settings mb-3">
            <div class="list-group list-group-sm list-group-flush">

                <small
                    class="text-muted px-4 pt-3 text-uppercase mb-1 font-weight-bold">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy_security'), config("app.locale")) }}</small>

                <a href="{{url('privacy/security')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('privacy/security')) active @endif">
                    <div>
                        <i class="bi bi-shield-check mr-2"></i>
                        <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.privacy_security'), config("app.locale"))}}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

                <a href="{{url('settings/password')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('settings/password')) active @endif">
                    <div>
                        <i class="iconmoon icon-Key mr-2"></i>
                        <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.password'), config("app.locale"))}}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

                @if (auth()->user()->verified_id == 'yes')
                    <a href="{{url('block/countries')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('block/countries')) active @endif">
                        <div>
                            <i class="bi bi-eye-slash mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.block_countries'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                <a href="{{url('settings/restrictions')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('settings/restrictions')) active @endif">
                    <div>
                        <i class="feather icon-slash mr-2"></i>
                        <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.restricted_users'), config("app.locale"))}}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

            </div>
        </div><!-- End Privacy and security -->

        <!-- Start Payments -->
        <div class="card shadow-sm card-settings mb-3">
            <div class="list-group list-group-sm list-group-flush">

                <small
                    class="text-muted px-4 pt-3 text-uppercase mb-1 font-weight-bold">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payments'), config("app.locale")) }}</small>

                <a href="{{url('my/payments')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/payments')) active @endif">
                    <div>
                        <i class="bi bi-receipt mr-2"></i>
                        <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payments'), config("app.locale"))}}</span>
                    </div>
                    <div>
                        <i class="feather icon-chevron-right"></i>
                    </div>
                </a>

                @if (auth()->user()->verified_id == 'yes')
                    <a href="{{url('my/payments/received')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/payments/received')) active @endif">
                        <div>
                            <i class="bi bi-receipt mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.payments_received'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                @if (Helper::showSectionMyCards())
                    <a href="{{url('my/cards')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/cards')) active @endif">
                        <div>
                            <i class="feather icon-credit-card mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.my_cards'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

                @if (auth()->user()->verified_id == 'yes' || $settings->referral_system == 'on' || auth()->user()->balance != 0.00)
                    <a href="{{url('settings/payout/method')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('settings/payout/method')) active @endif">
                        <div>
                            <i class="bi bi-credit-card mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.payout_method'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{url('settings/withdrawals')}}"
                       class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('settings/withdrawals')) active @endif">
                        <div>
                            <i class="bi bi-arrow-left-right mr-2"></i>
                            <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.withdrawals'), config("app.locale"))}}</span>
                        </div>
                        <div>
                            <i class="feather icon-chevron-right"></i>
                        </div>
                    </a>
                @endif

            </div>
        </div><!-- End Payments -->

    @if ($settings->shop
            || auth()->user()->sales()->count() != 0 && auth()->user()->verified_id == 'yes'
            || auth()->user()->sales()->count() != 0 && auth()->user()->verified_id == 'yes'
            || auth()->user()->purchasedItems()->count() != 0)
        <!-- Start Shop -->
            <div class="card shadow-sm card-settings">
                <div class="list-group list-group-sm list-group-flush">

                    <small
                        class="text-muted px-4 pt-3 text-uppercase mb-1 font-weight-bold">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.shop'), config("app.locale")) }}</small>

                    @if ($settings->shop && auth()->user()->verified_id == 'yes' || auth()->user()->sales()->count() != 0 && auth()->user()->verified_id == 'yes')
                        <a href="{{url('my/sales')}}"
                           class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/sales')) active @endif">
                            <div>
                                <i class="bi-cart2 mr-2"></i>
                                <span
                                    class="mr-1">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.sales'), config("app.locale"))}}</span>

                                @if (auth()->user()->sales()->whereDeliveryStatus('pending')->count() != 0)
                                    <span
                                        class="badge badge-warning">{{ auth()->user()->sales()->whereDeliveryStatus('pending')->count() }}</span>
                                @endif
                            </div>
                            <div>
                                <i class="feather icon-chevron-right"></i>
                            </div>
                        </a>
                    @endif

                    @if ($settings->shop && auth()->user()->verified_id == 'yes' || auth()->user()->products()->count() != 0 && auth()->user()->verified_id == 'yes')
                        <a href="{{url('my/products')}}"
                           class="list-group-item list-group-item-action d-flex justify-content-between">
                            <div>
                                <i class="bi-tag mr-2"></i>
                                <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.products'), config("app.locale"))}}</span>
                            </div>
                            <div>
                                <i class="feather icon-chevron-right"></i>
                            </div>
                        </a>
                    @endif

                    @if ($settings->shop || auth()->user()->purchasedItems()->count() != 0)
                        <a href="{{url('my/purchased/items')}}"
                           class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->is('my/purchased/items')) active @endif">
                            <div>
                                <i class="bi-bag-check mr-2"></i>
                                <span>{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.purchased_items'), config("app.locale"))}}</span>
                            </div>
                            <div>
                                <i class="feather icon-chevron-right"></i>
                            </div>
                        </a>
                    @endif
                </div>
            </div><!-- End Shop -->
        @endif

    </div>
</div>
