<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
          'qty',    
        'category_id',
        'source',     // admin / seller
        'seller_id',        // (agar hai)
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function isInWishlist()
{
    if (!auth()->check()) return false;

    return \App\Models\Wishlist::where('user_id', auth()->id())
                               ->where('product_id', $this->id)
                               ->exists();
}

public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class);
    }
    public function seller()
{
    return $this->belongsTo(User::class, 'seller_id');
}


}
