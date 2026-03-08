<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $table = 'orders';
   protected $fillable = [
    'user_id',
    'partner_id',
    'order_number',
    'name',
    'phone',
    'address_line',
    'city',
    'pincode',
    'subtotal',
    'delivery_charges',
    'total',
    'payment_method',
    'payment_status',
    'status',
    'awb',
     'delivery_otp' 
];


    public function items(){
        return $this->hasMany(OrderItem::class);
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function partner()
{
    return $this->belongsTo(DeliveryPartner::class, 'partner_id');
}


}
