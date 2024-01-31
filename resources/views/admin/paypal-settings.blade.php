@extends('admin.layout')

@section('css')
    <link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h4>
                {{ trans('admin.admin') }}
                <i class="fa fa-angle-right margin-separator"></i>
                {{ trans('admin.payment_settings') }} <i class="fa fa-angle-right margin-separator"></i>
                PayPal
            </h4>

        </section>

        <!-- Main content -->
        <section class="content">

            @if (Session::has('success_message'))
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

                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{ url()->current() }}"
                            enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('errors.errors-forms')

                            <hr />

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.fee') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $data->fee }}" name="fee"
                                            class="form-control" placeholder="{{ trans('admin.fee') }}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.fee_cents') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $data->fee_cents }}" name="fee_cents"
                                            class="form-control" placeholder="{{ trans('admin.fee_cents') }}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.paypal_account') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $data->email }}" name="email"
                                            class="form-control" placeholder="{{ trans('admin.paypal_account') }}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.client_id') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $data->key }}" name="key"
                                            class="form-control" placeholder="{{ trans('admin.client_id') }}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.key_secret') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $data->key_secret }}" name="key_secret"
                                            class="form-control" placeholder="{{ trans('admin.key_secret') }}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.status') }}</label>
                                    <div class="col-sm-10">
                                        <div class="radio">
                                            <label class="padding-zero">
                                                <input type="radio" value="1" name="enabled"
                                                    @if ($data->enabled == 1) checked="checked" @endif checked>
                                                {{ trans('admin.active') }}
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label class="padding-zero">
                                                <input type="radio" value="0" name="enabled"
                                                    @if ($data->enabled == 0) checked="checked" @endif>
                                                {{ trans('admin.disabled') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">PayPal Sandbox</label>
                                    <div class="col-sm-10">
                                        <div class="radio">
                                            <label class="padding-zero">
                                                <input type="radio" value="true" name="sandbox"
                                                    @if ($data->sandbox == 'true') checked="checked" @endif checked>
                                                On
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label class="padding-zero">
                                                <input type="radio" value="false" name="sandbox"
                                                    @if ($data->sandbox == 'false') checked="checked" @endif>
                                                Off
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.subscription') }}</label>
                                    <div class="col-sm-10">
                                        <div class="radio">
                                            <label class="padding-zero">
                                                <input type="radio" value="yes" name="subscription"
                                                    @if ($data->subscription == 'yes') checked="checked" @endif checked>
                                                {{ trans('admin.active') }}
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label class="padding-zero">
                                                <input type="radio" value="no" name="subscription"
                                                    @if ($data->subscription == 'no') checked="checked" @endif>
                                                {{ trans('admin.disabled') }}
                                            </label>
                                        </div>

                                        <p class="help-block">{{ trans('general.note_disable_subs_payment') }}</p>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
                            </div><!-- /.box-footer -->
                        </form>

                    </div><!-- /.row -->
                </div><!-- /.content -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
