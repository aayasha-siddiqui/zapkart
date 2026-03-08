<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
    ];

    // ======================
    // RELATIONS
    // ======================

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    // ✅ SHOPKEEPER → ASSIGNED PRODUCTS
    public function assignedProducts()
    {
        return $this->hasMany(
            \App\Models\ShopkeeperProduct::class,
            'shopkeeper_id'
        );
    }
}
