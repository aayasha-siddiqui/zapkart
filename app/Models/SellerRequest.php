<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerRequest extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'gst',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
    public function categories(){
    return $this->hasMany(SupplierCategory::class);
}

public function products(){
    return $this->hasMany(SupplierProduct::class);
}
}

