<!-- Start Modal payPerViewForm -->
<div class="modal fade" id="editForm{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-white shadow border-0">

                    <div class="card-body px-lg-5 py-lg-5 position-relative">

                        <div class="mb-4">
                            {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.edit'), config("app.locale")) }}
                            <i class="bi-arrow-right ml-1 mr-1"></i>
                            <strong>{{ $product->name }}</strong>
                        </div>

                        <form method="post" action="{{url('edits/product', $product->id)}}" id="shopProductForm{{$product->id}}">

                            <input type="hidden" name="id" value="{{ $product->id }}"/>
                            @csrf

                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $product->name }}" name="name"
                                       placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('admin.name'), config("app.locale")) }}">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control isNumber" value="{{ $product->price }}"
                                       autocomplete="off" name="price"
                                       placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.price'), config("app.locale")) }}">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="tags" value="{{ $product->tags }}"
                                       placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.tags'), config("app.locale")) }}">
                            </div>
                            


                            @if ($product->type == 'custom')
                                <div class="form-group">
                                    <select name="delivery_time" class="form-control custom-select">
                                        <option value=""
                                                selected>{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.delivery_time'), config("app.locale")) }}</option>
                                        @for ($i=1; $i <= 30; ++$i)
                                            <option @if ($product->delivery_time == $i) selected
                                                    @endif value="{{$i}}">{{$i}} {{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(trans_choice('general.days', $i), config("app.locale")) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            @endif
                            
                            


                            <div class="form-group">
                                <textarea class="form-control" name="description"
                                          placeholder="{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.description'), config("app.locale")) }}"
                                          rows="5">{{ $product->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-lg">
                                    <input type="checkbox" class="custom-control-input" name="status" value="1"
                                           @if ($product->status) checked @endif id="customSwitch2{{ $product->id }}">
                                    <label class="custom-control-label switch"
                                           for="customSwitch2{{ $product->id }}">{{ \Stichoza\GoogleTranslate\GoogleTranslate::trans(__('general.status'), config("app.locale")) }}</label>
                                </div>
                            </div>

                          <div class="alert alert-danger display-none mb-0" id="errorShopProduct{{$product->id}}">
                                <ul class="list-unstyled m-0" id="showErrorsShopProduct{{$product->id}}"></ul>
                            </div>

                            <div class="text-center">
                                <a href="#" class="btn e-none mt-4"
                                   data-dismiss="modal">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.cancel'), config("app.locale"))}}</a>

                                <button type="submit" id="shopProductBtn{{$product->id}}" class="btn btn-primary mt-4">
                                    <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.save'), config("app.locale"))}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Modal BuyNow -->










