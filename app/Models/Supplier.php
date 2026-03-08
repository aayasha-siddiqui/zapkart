<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_code',
        'user_id',
        'name',
        'business_name',
        'phone',
        'email',
        'address',
        'gst',
        'status',
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
