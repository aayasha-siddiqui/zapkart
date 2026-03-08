<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierCategory extends Model
{
    protected $fillable = [
        'supplier_id',
        'name',
        'image',
        'status',        // ✅ ADD THIS
        'category_id',   // ✅ ADD THIS
    ];

    // Supplier category ke products
    public function products()
    {
        return $this->hasMany(
            SupplierProduct::class,
            'supplier_category_id'
        );
    }

    // Main approved category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
