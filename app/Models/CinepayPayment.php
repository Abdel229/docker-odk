<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinepayPayment extends Model
{
    use HasFactory;
    protected $fillable  = [
        'transaction_id',
        'amount',
        'user_id',
        'id_update',
        'origin_url',
        'id_subscribe',
        'type_operation',
        'id_product',
        'plan_interval',
        'delivery_status',
        'description_custom_content',
    ];
}
