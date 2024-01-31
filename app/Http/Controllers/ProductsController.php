<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\User;
use Omnipay\Omnipay;
use App\Models\Products;
use App\Models\TaxRates;
use App\Models\Purchases;
use Illuminate\Http\File;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use App\Models\AdminSettings;
use App\Models\MediaProducts;
use App\Models\Notifications;
use App\Notifications\NewSale;
use App\Models\PaymentGateways;
use Illuminate\Validation\Rule;
use App\Models\ProductCategories;
use App\Models\ReferralTransactions;
use Fahim\PaypalIPN\PaypalIPNListener;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\cinetpay\CinetPayService;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class ProductsController extends Controller
{
  use Traits\Functions;

  public function __construct(AdminSettings $settings, Request $request)
  {
		$this->settings = $settings::first();
		$this->request = $request;
	}

 public function index()
 {
   if (! $this->settings->shop) {
     abort(404);
   }

   $tags = request('tags');
   $sort = request('sort');

   $products = Products::with('seller:name,username,avatar')->whereStatus('1');

   // Filter by tags
   $products->when(strlen($tags) > 2, function($q) use ($tags) {
     $q->where('tags', 'LIKE', '%'.$tags.'%');
   });

   // Filter by oldest
   $products->when($sort == 'oldest', function($q) {
     $q->orderBy('id', 'asc');
   });

   // Filter by lowest price
   $products->when($sort == 'priceMin', function($q) {
     $q->orderBy('price', 'asc');
   });

   // Filter by Highest price
   $products->when($sort == 'priceMax', function($q) {
     $q->orderBy('price', 'desc');
   });

   // Filter by Digital Products
   $products->when($sort == 'digital', function($q) {
     $q->where('type', 'digital');
   });

   // Filter by Custom Content
   $products->when($sort == 'custom', function($q) {
     $q->where('type', 'custom');
   });

   // Filter by Product Content
   $products->when($sort == 'product', function($q) {
     $q->where('type', 'product');
   });

   $products = $products->orderBy('id', 'desc')
   ->paginate(15);

  return view('shop.products')->withProducts($products);
 }

 public function create()
 {
   if (auth()->check()
      && auth()->user()->verified_id != 'yes'
      || ! $this->settings->shop
      || ! $this->settings->digital_product_sale
    ) {
     abort(404);
   }

   return view('shop.add-product');
 }// End method create

 public function store()
 {
   $path = config('path.shop');

   // Currency Position
   if ($this->settings->currency_position == 'right') {
     $currencyPosition =  2;
   } else {
     $currencyPosition =  null;
   }

   $messages = [
   'description.required' => trans('validation.required', ['attribute' => __('general.description')]),
   'description.min' => trans('validation.min', ['attribute' => __('general.description')]),
   'price.min' => trans('general.amount_minimum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
   'price.max' => trans('general.amount_maximum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
   ];

   // Media Files Preview
   $fileuploaderPreview = $this->request->input('fileuploader-list-preview');
   $fileuploaderPreview = json_decode($fileuploaderPreview, TRUE);

   // Media File
   $fileuploaderFile = $this->request->input('fileuploader-list-file');
   $fileuploaderFile = json_decode($fileuploaderFile, TRUE);

   if (! $fileuploaderPreview) {
     return response()->json([
         'success' => false,
         'errors' => ['error' => __('general.image_preview_required')],
     ]);
   }

   if (! $fileuploaderFile) {
     return response()->json([
         'success' => false,
         'errors' => ['error' => __('general.file_required')],
     ]);
   }

   $input = $this->request->all();



    $validator = Validator::make($input, [
      'name'     => 'required|min:5|max:100',

      'description' => 'required|min:10',
      'price'       => 'required|numeric|min:'.$this->settings->min_price_product.'|max:'.$this->settings->max_price_product,
    ], $messages);




    if ($validator->fails()) {
         return response()->json([
             'success' => false,
             'errors' => $validator->getMessageBag()->toArray(),
         ]);
     } //<-- Validator

     // Validate length tags
     $tagsLength = explode(',', $this->request->tags);

     	foreach ($tagsLength as $tag) {
     		if (strlen($tag) < 2) {
          return response()->json([
              'success' => false,
              'errors' => ['error' => trans('general.error_length_tags')],
          ]);
     	}
    }

     $product              = new Products();
     $product->user_id     = auth()->id();
     $product->name        = $this->request->name;
     $product->price       = $this->request->price;
     $product->tags        = $this->request->tags;
     $product->description = trim(Helper::checkTextDb($this->request->description));
     $product->save();

     // Insert Images Preview
     if ($fileuploaderPreview) {
       foreach ($fileuploaderPreview as $key => $media) {
         MediaProducts::create([
           'products_id' => $product->id,
           'name' => $media['file'],
           'products_id' => $product->id
         ]);

         // Move file to Storage
				 $this->moveFileStorage($media['file'], $path);

       }
     }// Insert Images Previews

     // Update File
     if ($fileuploaderFile) {

       $local = 'temp/';

       foreach ($fileuploaderFile as $key => $media) {

         $uploaderfile = $media['file'];
         $img = public_path($local.$uploaderfile);
         $ext = explode('.', $uploaderfile);
         $mime = mime_content_type($img);

         Products::whereId($product->id)->update([
           'file' => $media['file'],
           'mime' => $mime,
           'extension' => $ext[1],
           'size' => Helper::formatBytes(filesize($img), 1)
         ]);

         // Move file to Storage
				 $this->moveFileStorage($media['file'], $path);

       }
     }// Update File

     return response()->json([
         'success' => true,
         'url' => url('shop/product', $product->id)
     ]);

 }// End method store

 public function createCustomContent()
 {
   if (auth()->check()
      && auth()->user()->verified_id != 'yes'
      || ! $this->settings->shop
      || ! $this->settings->custom_content
    ) {
     abort(404);
   }
  // $categories = ProductCategories::orderBy('name')->where('mode','on')->get();
   return view('shop.add-custom-content');

 }// End method create

 public function createCustomProductContent()
 {
   if (auth()->check()
      && auth()->user()->verified_id != 'yes'
      || ! $this->settings->shop
      || ! $this->settings->product_content
    ) {
     abort(404);
   }
   $categories = ProductCategories::orderBy('name')->where('mode','on')->get();
   return view('shop.add-product-content', compact( 'categories'));

 }// End method create

 public function storeCustomContent()
 {
   $path = config('path.shop');

   // Currency Position
   if ($this->settings->currency_position == 'right') {
     $currencyPosition =  2;
   } else {
     $currencyPosition =  null;
   }

   $messages = [
   'description.required' => trans('validation.required', ['attribute' => __('general.description')]),
   'tags.required' => trans('validation.required', ['attribute' => __('general.tags')]),
   'description.min' => trans('validation.min', ['attribute' => __('general.description')]),
   'price.min' => trans('general.amount_minimum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
   'price.max' => trans('general.amount_maximum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
   'delivery_time.required' => trans('validation.required', ['attribute' => __('general.delivery_time')]),
   ];

   // Media Files Preview
   $fileuploaderPreview = $this->request->input('fileuploader-list-preview');
   $fileuploaderPreview = json_decode($fileuploaderPreview, TRUE);

   if (! $fileuploaderPreview) {
     return response()->json([
         'success' => false,
         'errors' => ['error' => __('general.image_preview_required')],
     ]);
   }

   $input = $this->request->all();

    $validator = Validator::make($input, [
      'name'     => 'required|min:5|max:100',
      'description' => 'required|min:10',
      'price'       => 'required|numeric|min:'.$this->settings->min_price_product.'|max:'.$this->settings->max_price_product,
      'delivery_time' => 'required',
    ], $messages);



    if ($validator->fails()) {
         return response()->json([
             'success' => false,
             'errors' => $validator->getMessageBag()->toArray(),
         ]);
     } //<-- Validator

     // Validate length tags
     $tagsLength = explode(',', $this->request->tags);

     	foreach ($tagsLength as $tag) {
     		if (strlen($tag) < 2) {
          return response()->json([
              'success' => false,
              'errors' => ['error' => trans('general.error_length_tags')],
          ]);
     	}
    }

     $product              = new Products();
     $product->user_id     = auth()->id();
     $product->name        = $this->request->name;
     $product->type        = 'custom';
     $product->price       = $this->request->price;
     $product->delivery_time = $this->request->delivery_time;
     $product->tags        = $this->request->tags;
     $product->description = trim(Helper::checkTextDb($this->request->description));
     $product->save();

     // Insert Images Preview
     if ($fileuploaderPreview) {
       foreach ($fileuploaderPreview as $key => $media) {
         MediaProducts::create([
           'products_id' => $product->id,
           'name' => $media['file'],
           'products_id' => $product->id
         ]);

         // Move file to Storage
				 $this->moveFileStorage($media['file'], $path);

       }
     }// Insert Images Previews

     return response()->json([
         'success' => true,
         'url' => url('shop/product', $product->id)
     ]);

 }// End method storeCustomContent


 public function storeCustomProductContent()
 {
   $path = config('path.shop');

   // Currency Position
   if ($this->settings->currency_position == 'right') {
     $currencyPosition =  2;
   } else {
     $currencyPosition =  null;
   }


   $messages = [
   'description.required' => trans('validation.required', ['attribute' => __('general.description')]),
   'tags.required' => trans('validation.required', ['attribute' => __('general.tags')]),
   'description.min' => trans('validation.min', ['attribute' => __('general.description')]),
   'price.min' => trans('general.amount_minimum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
   'price.max' => trans('general.amount_maximum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
   'delivery_time.required' => trans('validation.required', ['attribute' => __('general.delivery_time')]),
   ];

   // Media Files Preview
   $fileuploaderPreview = $this->request->input('fileuploader-list-preview');
   $fileuploaderPreview = json_decode($fileuploaderPreview, TRUE);

   if (! $fileuploaderPreview) {
     return response()->json([
         'success' => false,
         'errors' => ['error' => __('general.image_preview_required')],
     ]);
   }

   $input = $this->request->all();

    $validator = Validator::make($input, [
      'name'     => 'required|min:5|max:100',
      'description' => 'required|min:10',
      'delivery_time' => 'required',
      'price'       => 'required|numeric|min:'.$this->settings->min_price_product.'|max:'.$this->settings->max_price_product,
      'stock'       => 'numeric|min:1',
      'dim'         => 'numeric|min:0',
      'promo'       => 'numeric|min:0|max:100',
      'kg'          => 'numeric|min:0',
      'categorie'   => 'required|numeric'
    ], $messages);


    if ($validator->fails()) {
         return response()->json([
             'success' => false,
             'errors' => $validator->getMessageBag()->toArray(),
         ]);
     } //<-- Validator

     // Validate length tags
     $tagsLength = explode(',', $this->request->tags);

     	foreach ($tagsLength as $tag) {
     		if (strlen($tag) < 2) {
          return response()->json([
              'success' => false,
              'errors' => ['error' => trans('general.error_length_tags')],
          ]);
     	}
    }
      $product  = new Products();
      $product->user_id     = auth()->id();
      $product->name        = $this->request->name;
      $product->price       = $this->request->price ;
      $product->delivery_time = $this->request->delivery_time;
      $product->tags        = $this->request->tags;
      $product->product_promo = $this->request->promo;
      $product->isproduct = 1;
      $product->type        = 'product';
      $product->product_stock = $this->request->stock;
      $product->product_size = $this->request->kg != 0 ?$this->request->kg:0;
      $product->product_categories_id = $this->request->categorie;
      $product->product_dim = $this->request->dim != 0 ?$this->request->dim:0;
      $product->description = trim(Helper::checkTextDb($this->request->description));
      $product->save();
     // Insert Images Preview
     if ($fileuploaderPreview) {
       foreach ($fileuploaderPreview as $key => $media) {
         MediaProducts::create([
           'products_id' => $product->id,
           'name' => $media['file'],
           'products_id' => $product->id
         ]);
         // Move file to Storage
				 $this->moveFileStorage($media['file'], $path);

       }
     }// Insert Images Previews

     return response()->json([
         'success' => true,
         'url' => url('shop/product', $product->id)
     ]);

 }// End method storeCustomContent

 /**
    * Move file to Storage
    */
  protected function moveFileStorage($file, $path)
  {
    $localFile = public_path('temp/'.$file);

     // Move the file...
     Storage::putFileAs($path, new File($localFile), $file);

     // Delete temp file
    unlink($localFile);
  } // end method moveFileStorage

  public function update()
  {
    $product = Products::whereId($this->request->id)->whereUserId(auth()->id())->firstOrFail();

    // Currency Position
    if ($this->settings->currency_position == 'right') {
      $currencyPosition =  2;
    } else {
      $currencyPosition =  null;
    }

    $messages = [
    'description.required' => trans('validation.required', ['attribute' => __('general.description')]),
    'tags.required' => trans('validation.required', ['attribute' => __('general.tags')]),
    'description.min' => trans('validation.min', ['attribute' => __('general.description')]),
    'price.min' => trans('general.amount_minimum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
    'price.max' => trans('general.amount_maximum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
    'delivery_time.required' => trans('validation.required', ['attribute' => __('general.delivery_time')]),
    ];

    $input = $this->request->all();

    $validator = Validator::make($input, [
      'name'     => 'required|min:5|max:100',
      'description' => 'required|min:10',
      'price'       => 'required|numeric|min:'.$this->settings->min_price_product.'|max:'.$this->settings->max_price_product,
      'delivery_time' => Rule::requiredIf($product->type == 'custom')
    ], $messages);

     if ($validator->fails()) {
          return response()->json([
              'success' => false,
              'errors' => $validator->getMessageBag()->toArray(),
          ]);
      } //<-- Validator

      // Validate length tags
      $tagsLength = explode(',', $this->request->tags);

      	foreach ($tagsLength as $tag) {
      		if (strlen($tag) < 2) {
           return response()->json([
               'success' => false,
               'errors' => ['error' => trans('general.error_length_tags')],
           ]);
      	}
     }

      $product->name        = $this->request->name;
      $product->price       = $this->request->price;
      $product->tags        = $this->request->tags;
      $product->description = trim(Helper::checkTextDb($this->request->description));
      $product->delivery_time = $this->request->delivery_time ?? false;
      $product->status      = $this->request->status ?? '0';
      $product->save();

      return response()->json([
          'success' => true,
          'url' => url('shop/product', $product->id)
      ]);

  }// End method store
public function updates()
  {
    $product = Products::whereId($this->request->id)->whereUserId(auth()->id())->firstOrFail();

    // Currency Position
    if ($this->settings->currency_position == 'right') {
      $currencyPosition =  2;
    } else {
      $currencyPosition =  null;
    }

    $messages = [
    'description.required' => trans('validation.required', ['attribute' => __('general.description')]),
    'tags.required' => trans('validation.required', ['attribute' => __('general.tags')]),
    'description.min' => trans('validation.min', ['attribute' => __('general.description')]),
    'price.min' => trans('general.amount_minimum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
    'price.max' => trans('general.amount_maximum'.$currencyPosition, ['symbol' => $this->settings->currency_symbol, 'code' => $this->settings->currency_code]),
    'delivery_time.required' => trans('validation.required', ['attribute' => __('general.delivery_time')]),
    ];

    $input = $this->request->all();

    $validator = Validator::make($input, [
      'name'     => 'required|min:5|max:100',
      'description' => 'required|min:10',
      'price'       => 'required|numeric|min:'.$this->settings->min_price_product.'|max:'.$this->settings->max_price_product,
      'delivery_time' => Rule::requiredIf($product->type == 'custom')
    ], $messages);

     if ($validator->fails()) {
          /*return response()->json([
              'success' => false,
              'errors' => $validator->getMessageBag()->toArray(),
          ]);*/
           return redirect('my/products');
      } //<-- Validator

      // Validate length tags
      $tagsLength = explode(',', $this->request->tags);

      	foreach ($tagsLength as $tag) {
      		if (strlen($tag) < 2) {
          /* return response()->json([
               'success' => false,
               'errors' => ['error' => trans('general.error_length_tags')],
           ]);*/
            return redirect('my/products');
      	}
     }

      $product->name        = $this->request->name;
      $product->price       = $this->request->price;
      $product->tags        = $this->request->tags;
      $product->description = trim(Helper::checkTextDb($this->request->description));
      $product->delivery_time = $this->request->delivery_time ?? false;
      $product->status      = $this->request->status ?? '0';
      $product->save();

      /*return response()->json([
          'success' => true,
          'url' => url('shop/product', $product->id)
      ]);*/

      return redirect('my/products');

  }// End method store

  public function show($id)
  {
    if (! $this->settings->shop) {
      abort(404);
    }

    $product = Products::findOrFail($id);

    if (! $product->status && auth()->id() != $product->user()->id || ! $product->status && auth()->check() && auth()->user()->role == 'normal') {
      abort(404);
    }

    $uri = $this->request->path();

		if (str_slug($product->name) == '') {
				$slugUrl  = '';
			} else {
				$slugUrl  = '/'.str_slug($product->name);
			}

			$urlImage = 'shop/product/'.$product->id.$slugUrl;

			//<<<-- * Redirect the user real page * -->>>
			$uriImage     =  $this->request->path();
			$uriCanonical = $urlImage;

			if ($uriImage != $uriCanonical) {
				return redirect($uriCanonical);
			}

      // Tags
      $tags = explode(',', $product->tags);

      // Previews
      $previews = count($product->previews);

      if (auth()->check()) {
        $verifyPurchaseUser = $product->purchases()
          ->whereUserId(auth()->id())
            ->first();
      }

      // Total Items of User
      $userProducts = $product->user()->products()->whereStatus('1');

    return view('shop.show')->with([
      'product' => $product,
      'userProducts' => $userProducts,
      'tags' => $tags,
      'previews' => $previews,
      'verifyPurchaseUser' => $verifyPurchaseUser ?? null,
      'totalProducts' => $userProducts->count()
    ]);
  }// End method show

  public function buy()
  {
    // Find item exists
    $item = Products::findOrFail($this->request->id);

    // Verify that the user has not buy
    if (Purchases::whereUserId(auth()->id())
        ->whereProductsId($this->request->id)
        ->first()
        && $item->type == 'digital')
        {
          return response()->json([
            "success" => true,
            'url' => url('product/download', $item->id)
          ]);
        }

        // if (auth()->user()->wallet < $item->price) {
        //   return response()->json([
        //     "success" => false,
        //     "errors" => ['error' => __('general.not_enough_funds'),]
        //   ]);
        // }

        $messages = [
        'description_custom_content.required' => trans('validation.required', ['attribute' => __('general.details_custom_content')]),
        'city_custom_content.required' => trans('validation.required', ['attribute' => __('general.city_custom_content')]),
        'number_custom_content.required' => trans('validation.required', ['attribute' => __('general.number_custom_content')])
        ];

        $validator = Validator::make($this->request->all(), [
          'description_custom_content' => Rule::requiredIf($item->type == 'custom'),
          'number_product_content' => Rule::requiredIf($item->type == 'product'),
          'city_product_content' => Rule::requiredIf($item->type == 'product'),
        ], $messages);

         if ($validator->fails()) {
              return response()->json([
                  'success' => false,
                  'errors' => $validator->getMessageBag()->toArray(),
              ]);
          } //<-- Validator


        if($this->request->payment_gateway_ppv == "11"){
          try {

            $data = [];
            $data["customer_name"] = auth()->user()->name;
            $data["customer_surname"] = auth()->user()->username;
            $data["description"] = "Achat sdk";
            $data["amount"] = $item->product_promo!=0?$item->price-($item->product_promo*$item->price/100):$item->price;
            $data["type_operation"] = 4;
            $data["id_product"] = $this->request->id;
            $data["id_update"] = null;
            $data["description_custom_content"] = ''.json_encode($this->request->description_custom_content).'';
            $data["delivery_status"] = $item->type == 'digital' ? 'delivered' : 'pending';
            $data["id_subscribe"] = null;
            $data["currency"] = "XOF";
            $cinetPay = new CinetPayService();
            $result = $cinetPay->payment($data);

            if ($result["code"] == '201') {
                $url = $result["data"]["payment_url"];

                return response()->json([
                    "success" => true,
                    "payment" => "CinetPay",
                    "data" => $result["data"]
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => $result,
                ]);
            }
          } catch (\Throwable $th) {
            return response()->json([
              'success' => false,
              'errors' => "$th",
          ]);
          }

        }
        if($this->request->payment_gateway_ppv == "40"){
            try{
                $payment = PaymentGateways::whereId(1)->whereName('PayPal')->firstOrFail();
                $gateway = Omnipay::create('PayPal_Rest');
                $gateway->initialize(array(
                    'clientId' => env('PAYPAL_SANDBOX_CLIENT_ID'),
                    'secret'   => env('PAYPAL_SANDBOX_SECRET'),
                    'testMode' => $payment->sandbox?true:false, // Or false when you are ready for live transactions
                ));


                $response = $gateway->purchase(array(
                    'amount'        => $item->product_promo!=0?$item->price-($item->product_promo*$item->price/100):$item->price,
                    'currency'      => "EUR",
                    'description'   => "Achat sdk",
                    'transactionId' => $this->request->id,
                    'returnUrl'     => url('paypal/add/funds/ipn'),
                    'cancelUrl'     => url('my/wallet')
                ))->send();
               // Get Payment Gateway

               if ($response->isSuccessful()) {
                $transaction_id = $response->getTransactionReference();
                return response()->json([
                    'success'=>true,
                    'payment'=>"PayPal",
                    'payment_url'=>$response->getRedirectUrl()
                ]);
            } elseif ($response->isRedirect()) {
                // Redirect to offsite payment gateway
                $response->redirect();

            } else {
                // Payment failed
                echo $response->getMessage();
            }
            }catch (\Throwable $th) {
                return response()->json([
                  'success' => false,
                  'errors' => "$th",
              ]);
              }

        }

          if (auth()->user()->wallet < ($item->product_promo!=0?$item->price-($item->product_promo*$item->price/100):$item->price)) {
           return response()->json([
             "success" => false,
            "errors" => ['error' => __('general.not_enough_funds'),]
          ]);
        }
       /* return response()->json([
          "success" => false,
          "data" => "saut",
        ]);*/


        // Admin and user earnings calculation
        $earnings = $this->earningsAdminUser($item->user()->custom_fee, $item->product_promo!=0?$item->price-($item->product_promo*$item->price/100):$item->price, null, null);

        //== Insert Transaction
        $txn = $this->transaction(
          'purchase_'.str_random(25),
          auth()->id(),
          false,
          $item->user()->id,
          $item->product_promo!=0?$item->price-($item->product_promo*$item->price/100):$item->price,
          $earnings['user'],
          $earnings['admin'],
          'Wallet',
          'purchase',
          $earnings['percentageApplied'],
          auth()->user()->taxesPayable()
        );

        // Subtract user funds
        auth()->user()->decrement('wallet', Helper::amountGross($item->product_promo!=0?$item->price-($item->product_promo*$item->price/100):$item->price));

        // Add Earnings to User
        $item->user()->increment('balance', $earnings['user']);

        // Insert Purchase
        $purchase = new Purchases();
        $purchase->transactions_id = $txn->id;
        $purchase->user_id = auth()->id();
        $purchase->products_id = $item->id;
        $purchase->delivery_status = $item->type == 'digital' ? 'delivered' : 'pending';
        $purchase->description_custom_content = $this->request->description_custom_content;

        if($item->type == 'product'){

          $purchase->phone_number = $this->request->number_product_content;
          $purchase->city = $this->request->city_product_content;
        }

        $purchase->save();

        // Send Notification to Creator
        Notifications::send($item->user()->id, auth()->id(), 15, $item->id);

        // Send Email to Creator
        try {
  				$item->user()->notify(new NewSale($purchase));
  			} catch (\Exception $e) {
  				\Log::info('Error send email to creator on sale - '.$e->getMessage());
  			}

        if ($item->type == 'digital') {

          return response()->json([
            'success' => true,
            'URL' => url('shop/product', $item->id)
          ]);
        } else {
          return response()->json([
            'success' => true,
            'buyCustomContent' => true,
            'wallet' => Helper::userWallet()
          ]);

        }

  }// End method buy

  public function download($id)
  {
    $item = Products::whereId($id)
    ->whereType('digital')
    ->firstOrFail();

    $file = $item->purchases()
      ->where('user_id', auth()->id())
        ->first();

        if (! $file && auth()->user()->role != 'admin') {
          abort(404);
        }

        $pathFile = config('path.shop').$item->file;

        $headers = [
  				'Content-Type:' => $item->mime,
  				'Cache-Control' => 'no-cache, no-store, must-revalidate',
  				'Pragma' => 'no-cache',
  				'Expires' => '0'
  			];

        return Storage::download($pathFile, $item->name.'.'.$item->extension, $headers);

  }// End method download

  public function destroy($id)
  {
    $item = Products::whereId($id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $path = config('path.shop');

    // Delete Notifications
    Notifications::whereType(15)->whereTarget($item->id)->delete();

    // Delete Preview
    foreach ($item->previews as $previews) {
      Storage::delete($path.$previews->name);
    }

    // Delete file
    Storage::delete($path.$item->file);

    // Delete purchases
    $item->purchases()->delete();

    // Delete item
    $item->delete();

    return response()->json([
      'success' => true,
      'url' => url(auth()->user()->username)
    ]);
  }// End method download

  public function deliveredProduct($id)
  {
    $purchase = auth()->user()->sales()
        ->whereDeliveryStatus('pending')
        ->where('purchases.id', $id)
        ->firstOrFail();

        $purchase->delivery_status = 'delivered';
        if($purchase->products()->type == 'product' &&  $this->request->partner != "" ){

          $purchase->delivery_type = $this->request->partner == "me"? "seller":"partner";
          $purchase->save();
          return redirect('my/sales');
        }else{

          return redirect('my/sales');


        }
        $purchase->save();

        return response()->json([
          'success' => true
        ]);
  }// end deliveredProduct

  public function rejectOrder($id)
  {
    $purchase = auth()->user()->sales()
        ->whereDeliveryStatus('pending')
        ->where('purchases.id', $id)
        ->firstOrFail();

        if ($purchase) {

          $amount = $purchase->transactions()->amount;

          $taxes = TaxRates::whereIn('id', collect(explode('_', $purchase->transactions()->taxes)))->get();
          $totalTaxes = ($amount * $taxes->sum('percentage') / 100);

          // Total paid by buyer
          $amountRefund = number_format($amount + $purchase->transactions()->transaction_fee + $totalTaxes, 2, '.', '');

          // Get amount referral (if exist)
          $referralTransaction = ReferralTransactions::whereTransactionsId($purchase->transactions()->id)->first();

          if ($purchase->transactions()->referred_commission && $referralTransaction) {
            User::find($referralTransaction->referred_by)->decrement('balance', $referralTransaction->earnings);

            // Delete $referralTransaction
            $referralTransaction->delete();
          }

          // Add funds to wallet buyer
          $purchase->user()->increment('wallet', $amountRefund);

          // Remove creator funds
          if (auth()->user()->balance <> 0.00) {
            auth()->user()->decrement('balance', $purchase->transactions()->earning_net_user);
          } else {
            // If the creator has withdrawn their entire balance remove from withdrawal
            $withdrawalPending = Withdrawals::whereUserId(auth()->id())->whereStatus('pending')->first();

            if ($withdrawalPending) {
              $withdrawalPending->decrement('amount', $amountRefund);
            }
          }

          // Delete transaction
          $purchase->transactions()->delete();

          // Delete purchase
          $purchase->delete();

        }

        return response()->json([
          'success' => true
        ]);
  }// end rejectOrder

}
