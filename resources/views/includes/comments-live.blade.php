  @foreach ($comments as $comment)
  <li class="chatlist mb-1" data="{{ $comment->id }}">
    <img src="{{Helper::getFile(config('path.avatar').$comment->user()->avatar)}}" alt="User" class="rounded-circle mr-1" width="20" height="20">
    <strong>{{ $comment->user()->username }}</strong>

    @if ($comment->user()->verified_id == 'yes')
      <small class="verified">
           <i class="bi bi-patch-check-fill"></i>
         </small>
    @endif

    <p class="d-inline">
      {{ $comment->comment }}

      @if ($comment->joined)

        @if ($comment->user_id == auth()->id())
<<<<<<< HEAD
          {{ trans('general.you_have_joined') }}
        @else
          {{ trans('general.has_joined') }}
=======
          {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.you_have_joined'), config("app.locale")) }}
        @else
          {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.has_joined'), config("app.locale")) }}
>>>>>>> main
        @endif

      @endif

      @if ($comment->tip)
<<<<<<< HEAD
        {{ trans('general.tipped') }} <span class="badge badge-pill badge-success tipped-live px-3"><i class="bi bi-coin mr-1"></i> {{ Helper::amountWithoutFormat($comment->tip_amount) }}</span>
=======
        {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.tipped'), config("app.locale")) }} <span class="badge badge-pill badge-success tipped-live px-3"><i class="bi bi-coin mr-1"></i> {{ Helper::amountWithoutFormat($comment->tip_amount) }}</span>
>>>>>>> main
      @endif
    </p>
  </li>
  @endforeach
