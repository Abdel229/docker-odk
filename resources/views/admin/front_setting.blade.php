@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>
            {{ trans('admin.admin') }}
            <i class="fa fa-angle-right margin-separator"></i>
            {{ trans('admin.general_settings') }}

            <i class="fa fa-angle-right margin-separator"></i>
            Front Setting
        </h4>

    </section>

    <!-- Main content -->
    <section class="content">

        @if(Session::has('success_message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check margin-separator"></i> {{ Session::get('success_message') }}
        </div>
        @endif

        <div class="content">

            <div class="row">

                <div class="box">
                    <!-- /.box-header -->

                    <!-- form start -->
                    <form class="form-horizontal" method="POST" action="{{ url('panel/admin/settings/saveFrontSettings') }}" enctype="multipart/form-data">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @include('errors.errors-forms')
                        <div class="box-header">
                            <h3 class="box-title">Slider Section</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="slider_title" value="{{ $getData->slider_title }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="slider_description" id="" class="form-control">{{ $getData->slider_description }}</textarea>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <hr>

                        <div class="box-header">
                            <h3 class="box-title">Start earning</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="earning_title" value="{{ $getData->earning_title }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="earning_description" id="" class="form-control">{{ $getData->earning_description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title 1 </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="earning_title1" value="{{ $getData->earning_title1 }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description 1</label>
                                <div class="col-sm-10">
                                    <textarea name="earning_description1" id="" class="form-control">{{ $getData->earning_description1 }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="earning_title2" value="{{ $getData->earning_title2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description 2</label>
                                <div class="col-sm-10">
                                    <textarea name="earning_description2" id="" class="form-control">{{ $getData->earning_description2 }}</textarea>
                                </div>
                            </div>
                        </div>


                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title 3</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="earning_title3" value="{{ $getData->earning_title3 }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description 3</label>
                                <div class="col-sm-10">
                                    <textarea name="earning_description3" id="" class="form-control">{{ $getData->earning_description3 }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="box-header">
                            <h3 class="box-title">Create Your Profile</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="profile_title" value="{{ $getData->profile_title }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="profile_description" id="" class="form-control">{{ $getData->profile_description }}</textarea>
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                        <hr>

                        <div class="box-header">
                            <h3 class="box-title">Creators Features</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="creators_title" value="{{ $getData->creators_title }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="creators_description" id="" class="form-control">{{ $getData->creators_description }}</textarea>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <hr>

                        <div class="box-header">
                            <h3 class="box-title">Creators Earning</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="creators_earning_title" value="{{ $getData->creators_earning_title }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="creators_earning_description" id="" class="form-control">{{ $getData->creators_earning_description }}</textarea>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-header">
                            <h3 class="box-title">Followers</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.number_followers_title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" autocomplete="off" value="{{ $getData->number_followers_title }}" name="number_followers_title" class="form-control" placeholder="{{ trans('admin.number_followers_title') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.min_number_followers') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" autocomplete="off" value="{{ $getData->min_number_followers }}" name="min_number_followers" class="form-control onlyNumber" placeholder="{{ trans('admin.min_number_followers') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.max_number_followers') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" autocomplete="off" value="{{ $getData->max_number_followers }}" name="max_number_followers" class="form-control onlyNumber" placeholder="{{ trans('admin.max_number_followers') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-header">
                            <h3 class="box-title">Monthly Subscription</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.monthly_subscription_title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" autocomplete="off" value="{{ $getData->monthly_subscription_title }}" name="monthly_subscription_title" class="form-control" placeholder="{{ trans('admin.monthly_subscription_title') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.min_subscription_amount') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" autocomplete="off" value="{{ $getData->min_subscription_amount }}" name="min_subscription_amount" class="form-control onlyNumber" placeholder="{{ trans('admin.min_subscription_amount') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.max_subscription_amount') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" autocomplete="off" value="{{ $getData->max_subscription_amount }}" name="max_subscription_amount" class="form-control onlyNumber" placeholder="{{ trans('admin.max_subscription_amount') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-header">
                            <h3 class="box-title">Creators Earning Description</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.earnings_simulator_subtitle_2') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->earnings_simulator_subtitle_2 }}" name="earnings_simulator_subtitle_2" class="form-control" placeholder="{{ trans('admin.earnings_simulator_subtitle_2') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.per_month') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->per_month }}" name="per_month" class="form-control" placeholder="{{ trans('admin.per_month') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.earnings_simulator_subtitle_4') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->earnings_simulator_subtitle_4 }}" name="earnings_simulator_subtitle_4" class="form-control" placeholder="{{ trans('admin.earnings_simulator_subtitle_4') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.earnings_simulator_subtitle_5') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->earnings_simulator_subtitle_5 }}" name="earnings_simulator_subtitle_5" class="form-control" placeholder="{{ trans('admin.earnings_simulator_subtitle_5') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.earnings_simulator_subtitle_6') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->earnings_simulator_subtitle_6 }}" name="earnings_simulator_subtitle_6" class="form-control" placeholder="{{ trans('admin.earnings_simulator_subtitle_6') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.earnings_simulator_subtitle_7') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->earnings_simulator_subtitle_7 }}" name="earnings_simulator_subtitle_7" class="form-control" placeholder="{{ trans('admin.earnings_simulator_subtitle_7') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.earnings_simulator_subtitle_8') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->earnings_simulator_subtitle_8 }}" name="earnings_simulator_subtitle_8" class="form-control" placeholder="{{ trans('admin.earnings_simulator_subtitle_8') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">{{ trans('admin.earnings_simulator_subtitle_9') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $getData->earnings_simulator_subtitle_9 }}" name="earnings_simulator_subtitle_9" class="form-control" placeholder="{{ trans('admin.earnings_simulator_subtitle_9') }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <hr>
                        <div class="box-header">
                            <h3 class="box-title">Waiting For</h3>
                        </div>
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="waiting_title" value="{{ $getData->waiting_title }}">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group margin-zero">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="waiting_description" id="" class="form-control">{{ $getData->waiting_description }}</textarea>
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div>
            </div><!-- /.row -->
        </div><!-- /.content -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection