<!-- Start Modal payPerViewForm -->
<div class="modal fade" id="productDeliveryContentForm{{$sale->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-white shadow border-0">

                    <div class="card-body px-lg-5 py-lg-5 position-relative">

                        <div class="mb-4">
                            <i class="bi bi-boxes mr-1"></i> <strong> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.delivery_content'), config("app.locale"))}}  </strong>
                        </div>

                        <form method="post" action="{{url('delivered/product', $sale->id)}}">
                               
                            @csrf

                            <div class="custom-control custom-radio mb-3">
                                <input class="" type="radio" name="partner"  checked  value="me" id="radio0" >
                                <label class="" for="radio0">
									<span>
										<strong>
                                          
                                        {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.myself'), config("app.locale"))}} 
                                            
									    </strong>
									</span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input  class="" type="radio" name="partner" value="partner" id="radio11"  >
                                <label class="" for="radio11">
                                    <span><strong> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.partner'), config("app.locale"))}} </strong></span>
                                </label>
                            </div>
            
                            <div class="text-center">
                                <button type="submit"  
                                        id="shopProductBtn" class="btn btn-primary mt-4 BuyNowBtn">
                                    <i></i> {{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('general.delivery'), config("app.locale"))}} 
                                    
                                </button>

                                <div class="w-100 mt-2">
                                    <a href="#" class="btn e-none p-0"
                                       data-dismiss="modal">{{\Stichoza\GoogleTranslate\GoogleTranslate::trans(trans('admin.cancel'), config("app.locale"))}}</a>
                                </div>
                            </div>

                            

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Modal BuyNow -->
