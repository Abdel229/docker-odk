<div class="w-100 p-3 border-bottom">
<<<<<<< HEAD
	<div class="w-100">
		<a href="{{url()->previous()}}" class="h4 mr-1 text-decoration-none">
			<i class="fa fa-arrow-left"></i>
		</a>

		<span class="h5 align-top font-weight-bold">{{trans('general.messages')}}</span>

		<span class="float-right">
			<a href="#" class="h4 text-decoration-none" data-toggle="modal" data-target="#newMessageForm" title="{{trans('general.new_message')}}">
				<i class="feather icon-edit"></i>
			</a>
		</span>
	</div>
=======
    <div class="w-100">
        <a href="{{url()->previous()}}" class="h4 mr-1 text-decoration-none">
            <i class="fa fa-arrow-left"></i>
        </a>

        <span
            class="h5 align-top font-weight-bold">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.messages'), config("app.locale"))}}</span>

        <span class="float-right">
			<a href="#" class="h4 text-decoration-none" data-toggle="modal" data-target="#newMessageForm"
               title="{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.new_message'), config("app.locale"))}}">
				<i class="feather icon-edit"></i>
			</a>
		</span>
    </div>
>>>>>>> main
</div>

@include('includes.messages-inbox')
