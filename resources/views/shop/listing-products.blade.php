<a href="{{ url('shop/product', $product->id) }}" class="link-shop">
<<<<<<< HEAD
	<div class="card card-updates h-100 card-user-profile shadow-sm">
	<div class="card-cover position-relative" style="background: url({{ Helper::getFile(config('path.shop').$product->previews[0]->name) }}) #efefef center center; background-size: cover; height:300px;">
=======
    <div class="card card-updates h-100 card-user-profile shadow-sm">
        <div class="card-cover position-relative"
             style="background: url({{ Helper::getFile(config('path.shop').$product->previews[0]->name) }}) #efefef center center; background-size: cover; height:300px;">
>>>>>>> main

		<span class="price-shop">
			{{ Helper::amountFormatDecimal($product->price) }}
		</span>
<<<<<<< HEAD
	</div>

	<div class="card-body">
			<h5 class="card-title mb-2 text-truncate-2">{{$product->name }}</h5>

			<p class="my-2 text-muted card-text text-truncate-2">{{ Str::limit($product->description, 100, '...') }}</p>

			<hr />

			<div class="d-flex justify-content-between align-items-center">
        <span class="text-truncate">
          <img src="{{ Helper::getFile(config('path.avatar').$product->user()->avatar) }}" width="25" height="25" class="rounded-circle">
            <small><strong>{{ '@'.$product->user()->username }}</strong></small>
          </span>

					<small class="text-truncate">{{ Helper::formatDate($product->created_at) }}</small>
				</div>

	</div>
</div><!-- End Card -->
=======
        </div>

        <div class="card-body">
            <h5 class="card-title mb-2 text-truncate-2">{{$product->name }}</h5>

            <p class="my-2 text-muted card-text text-truncate-2">{{ Str::limit($product->description, 100, '...') }}</p>

            <hr/>

            <div class="d-flex justify-content-between align-items-center">
        <span class="text-truncate">
          <img src="{{ Helper::getFile(config('path.avatar').$product->user()->avatar) }}" width="25" height="25"
               class="rounded-circle" alt="">
            <small><strong>{{ '@'.$product->user()->username }}</strong></small>
          </span>

                <small class="text-truncate">{{ Helper::formatDate($product->created_at) }}</small>
            </div>

        </div>
    </div><!-- End Card -->
>>>>>>> main
</a>
