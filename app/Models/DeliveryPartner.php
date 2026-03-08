<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'father_name',
        'dob',
        'gender',
        'profile_photo',
        'city',
        'state',
        'address',
        'vehicle_type',
        'driving_license_number',
        'driving_license_front',
        'driving_license_back',
        'police_verification',
        'partner_code',
        'status',
        'online_status',
        'latitude',
        'longitude',
        'location_updated_at',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function orders()
    {
        return $this->hasMany(Order::class, 'partner_id');
    }

    public function currentOrder()
    {
        return $this->hasOne(Order::class, 'partner_id')
            ->whereIn('status', ['accepted', 'picked', 'on_the_way'])
            ->latest();
    }

    public function activeOrders()
    {
        return $this->hasMany(Order::class, 'partner_id')
            ->whereIn('status', ['placed', 'accepted', 'picked', 'on_the_way']);
    }

    public function completedOrders()
    {
        return $this->hasMany(Order::class, 'partner_id')
            ->where('status', 'delivered');
    }
}
