<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopkeeperProduct extends Model
{
    protected $table = 'shopkeeper_products';

    protected $fillable = [
        'shopkeeper_id',
        'product_id',
        'qty',
    ];

    // relation with product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // relation with shopkeeper (user)
    public function shopkeeper()
    {
        return $this->belongsTo(User::class, 'shopkeeper_id');
    }
}
