@extends('layouts.app')

@section('title') {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($response->title, config("app.locale")) }} -@endsection

@section('description_custom'){{$response->description ? $response->description : trans('seo.description')}}@endsection
@section('keywords_custom'){{$response->keywords ? $response->keywords.',' : null}}@endsection

@section('content')
    <section class="section section-sm">
        <div class="container">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-12 py-5">
                    <h2 class="mb-0 font-montserrat">
                        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans($response->title, config("app.locale")) }}
                    </h2>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12 col-lg-12 mb-5 mb-lg-0">
                    <div class="content-p">
                        {!! \Stichoza\GoogleTranslate\GoogleTranslate::trans($response->content, config("app.locale")) !!}
                    </div>
                </div><!-- end col-md-12 -->
            </div>
        </div>
    </section>
@endsection
