@extends('layouts.app')

@section('title') {{\Stichoza\GoogleTranslate\GoogleTranslate::trans($title, config("app.locale"))}} -@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-12 py-5">
                    <h2 class="mb-0 text-break">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans($title, config("app.locale"))}}</h2>
                    <p class="lead text-muted mt-0">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('users.the_best_creators_is_here'), config("app.locale"))}}
                        @guest
                            @if ($settings->registration_active == '1')
                                <a href="{{url('signup')}}"
                                   class="link-border">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.join_now'), config("app.locale")) }}</a>
                            @endif
                        @endguest</p>
                </div>
            </div>

            <div class="row">

                <div class="col-md-3 mb-4">

                    @if (! request()->get('q') || request()->get('q') && strlen(request()->get('q')) <= 2)

                        <button type="button" class="btn-menu-expand btn btn-primary btn-block mb-4 d-lg-none"
                                type="button" data-toggle="collapse" data-target="#navbarFilters"
                                aria-controls="navbarCollapse" aria-expanded="false">
                            <i class="bi bi-filter-right mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.filter_by'), config("app.locale"))}}
                        </button>

                        <div class="navbar-collapse collapse d-lg-block" id="navbarFilters">
                            <div class="btn-block mb-3">
  		<span>

        <span class="category-filter">
  			<i class="bi bi-filter-right mr-2"></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.filter_by'), config("app.locale"))}}
        </span>

    <a class="text-muted btn btn-sm bg-white border mb-2 e-none btn-category @if(request()->is('creators'))active-category @endif"
       href="{{url('creators')}}">
			<img src="{{url('img/popular.png')}}" class="mr-2" width="30" alt=""/> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.popular'), config("app.locale"))}}
		</a>

    <a class="text-muted btn btn-sm bg-white border mb-2 e-none btn-category @if(request()->is('creators/featured'))active-category @endif"
       href="{{url('creators/featured')}}">
			<img src="{{url('img/featured.png')}}" class="mr-2" width="30" alt=""/> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.featured_creators'), config("app.locale"))}}
		</a>

    <a class="text-muted btn btn-sm bg-white border mb-2 e-none btn-category @if(request()->is('creators/more-active'))active-category @endif"
       href="{{url('creators/more-active')}}">
			<img src="{{url('img/more-active.png')}}" class="mr-2" width="30" alt=""/> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.more_active'), config("app.locale"))}}
		</a>

    <a class="text-muted btn btn-sm bg-white border mb-2 e-none btn-category @if(request()->is('creators/new'))active-category @endif"
       href="{{url('creators/new')}}">
			<img src="{{url('img/creators.png')}}" class="mr-2" width="30" alt=""/>  {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.new_creators'), config("app.locale"))}}
		</a>

    <a class="text-muted btn btn-sm bg-white border mb-2 e-none btn-category @if(request()->is('creators/free'))active-category @endif"
       href="{{url('creators/free')}}">
			<img src="{{url('img/unlock.png')}}" class="mr-2" width="30" alt=""/> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.free_subscription'), config("app.locale"))}}
		</a>

    @if ($settings->live_streaming_status == 'on')
                <a class="text-muted btn btn-sm bg-white border mb-2 e-none btn-category @if(request()->is('explore/creators/live'))active-category @endif"
                   href="{{url('explore/creators/live')}}">
        <img src="{{url('img/live.png')}}" class="mr-2" width="30" alt=""/> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.live'), config("app.locale"))}}
      </a>
            @endif
  		</span>
                            </div>
                        </div>
                    @endif

                    @include('includes.listing-categories')
                </div><!-- end col-md-3 -->


                @if( $users->total() != 0 )
                    <div class="col-md-9 mb-4">
                        <div class="row">

                            @foreach ($users as $response)
                                <div class="col-md-6 mb-4">
                                    @include('includes.listing-creators')
                                </div><!-- end col-md-4 -->
                            @endforeach

                            @if($users->hasPages())
                                <div class="w-100 d-block">
                                    {{ $users->onEachSide(0)->appends(['q' => request('q')])->links() }}
                                </div>
                            @endif
                        </div><!-- row -->
                    </div><!-- col-md-9 -->

                @else
                    <div class="col-md-9">
                        <div class="my-5 text-center no-updates">
              <span class="btn-block mb-3">
                <i class="fa fa-user-slash ico-no-result"></i>
              </span>
                            <h4 class="font-weight-light">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.no_results_found'), config("app.locale"))}}</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
