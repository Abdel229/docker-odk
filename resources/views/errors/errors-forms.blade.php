@if (count($errors) > 0)
<<<<<<< HEAD
	<!-- Start Box Body -->
  <div class="box-body">
	<div class="alert alert-danger" id="dangerAlert">

		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
			</button>

		{{trans('auth.error_desc')}} <br><br>
		<ul class="list-unstyled">
			@foreach ($errors->all() as $error)
				<li><i class="far fa-times-circle"></i> {{$error}}</li>
			@endforeach
		</ul>
	</div>
</div><!-- /.box-body -->
=======
    <!-- Start Box Body -->
    <div class="box-body">
        <div class="alert alert-danger" id="dangerAlert">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
            </button>

            {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('auth.error_desc'), config('app.locale'))}}
            <br><br>
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                    <li><i class="far fa-times-circle"></i> {{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div><!-- /.box-body -->
>>>>>>> main
@endif
