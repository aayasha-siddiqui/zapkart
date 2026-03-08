<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class SupplierProduct extends Model
{
    protected $fillable = [
        'supplier_id',
        'supplier_category_id',
        'name',
        'image',
        
        'price',
        'qty',
        'payment_status',
        'status'
    ];
   public function supplierCategory()
{
    return $this->belongsTo(
        SupplierCategory::class,
        'supplier_category_id'
    );
}

    public function category()
{
    return $this->belongsTo(SupplierCategory::class, 'supplier_category_id');
}

public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id');
}

}

