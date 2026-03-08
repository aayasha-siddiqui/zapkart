<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

   class SellerEarning extends Model
{
    protected $fillable = [
        'seller_id',
        'order_id',
        'order_item_id',
        'total',
        'admin_commission',
        'seller_amount',
        'status'
    ];

}
