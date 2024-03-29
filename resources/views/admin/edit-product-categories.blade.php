@extends('admin.layout')

@section('css')
<link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
            {{ trans('admin.admin') }}
            	<i class="fa fa-angle-right margin-separator"></i>
            		{{ trans('general.categories') }}
            			<i class="fa fa-angle-right margin-separator"></i>
            				{{ trans('admin.edit') }}
                  </h4>
                </section>

        <!-- Main content -->
        <section class="content">
        	<div class="content">
        		<div class="row">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('admin.edit') }}</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{ url('panel/admin/productcategories/update') }}" enctype="multipart/form-data">

                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<input type="hidden" name="id" value="{{ $categories->id }}">

					@include('errors.errors-forms')

                 <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.name') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $categories->name }}" name="name" class="form-control" placeholder="{{ trans('admin.name') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.keywords') }} (SEO)</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $categories->keywords }}" id="tagInput" name="keywords" placeholder="{{ trans('admin.keywords') }}" class="form-control">
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.description') }}</label>
                      <div class="col-sm-10">
                      	<textarea name="description" rows="4" id="description" class="form-control" placeholder="{{ trans('admin.description') }}">{{ $categories->description }}</textarea>
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
                          <input type="radio" name="mode" value="on" @if( $categories->mode == 'on' ) checked @endif>
                          {{ trans('admin.active') }}
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="mode" value="off" @if( $categories->mode == 'off' ) checked @endif>
                          {{ trans('admin.disabled') }}
                        </label>
                      </div>

                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.thumbnail') }} ({{trans('general.optional')}})</label>
                      <div class="col-sm-10">
                      	<div class="btn btn-info box-file">
                      		<input type="file" accept="image/*" name="thumbnail" />
                      		<i class="glyphicon glyphicon-cloud-upload myicon-right"></i> {{ trans('general.replace_image') }}
                      		</div>

                          <p class="help-block">{{ trans('admin.thumbnail_desc') }}</p>

                      <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
					     	<i class="glyphicon glyphicon-paperclip myicon-right"></i>
					     	<small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle delete-attach-file-2 pull-right" title="{{ trans('general.delete') }}"></i>
					     </div>
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="{{ url('panel/admin/productcategories') }}" class="btn btn-default">{{ trans('admin.cancel') }}</a>
                    <button type="submit" class="btn btn-success pull-right">{{ trans('admin.save') }}</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
        		</div><!-- /.row -->
        	</div><!-- /.content -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection
