<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model {

	protected $guarded = array();
	public $timestamps = false;

	public function products() {
		return $this->hasMany('App\Models\Products')->where('status',1);
	}
}
