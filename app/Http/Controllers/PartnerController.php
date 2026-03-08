<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPartner;
use Illuminate\Http\Request;
use App\Models\SellerRequest;
use App\Models\Order;
use App\Mail\PartnerNotificationMail;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;

class PartnerController extends Controller
{
    // ========================
    // PARTNER REGISTRATION
    // ========================

    public function register()
    {
        $existing = DeliveryPartner::where('user_id', auth()->id())->first();
        if ($existing) {
            return redirect()->route('partner.status')
                ->with('info', 'You already submitted an application.');
        }
        
        return view('partner.register');
    }

    public function partnerStatus()
    {
        $partner = DeliveryPartner::where('user_id', auth()->id())->first();

        if ($partner && $partner->status == 'approved') {
            return redirect()->route('partner.dashboard');
        }

        return view('partner.status', compact('partner'));
    }

    // ========================
    // DASHBOARD
    // ========================

    public function dashboard()
    {
        $partner = DeliveryPartner::where('user_id', auth()->id())->first();

        return view('partner.dashboard', [
            'partner' => $partner,

            // ACTIVE ORDER (currently delivering)
            'activeOrders' => Order::where('partner_id', $partner->id)
                       ->whereIn('status', ['accepted','picked','on_the_way'])
                       
                       ->get(),

            // NEW ORDERS (waiting to be accepted)
            'newOrders' => Order::whereNull('partner_id')
    ->where('status', 'placed')
    ->whereDoesntHave('items', function ($q) {
        $q->whereNotNull('seller_id');
    })  
    ->get(),


            // COUNT COMPLETED
            'completedCount' => Order::where('partner_id', $partner->id)
                ->where('status', 'delivered')
                 
                ->count(),

            // TOTAL EARNINGS
            'totalEarnings' => Order::where('partner_id', $partner->id)
                ->where('status', 'delivered')
                ->sum('delivery_charges'),
        ]);
    }

    // ========================
    // GO ONLINE / OFFLINE
    // ========================

    public function toggleOnline()
    {
        $partner = DeliveryPartner::where('user_id', auth()->id())->first();
        $partner->online_status = 
    $partner->online_status == 'online' ? 'offline' : 'online';

$partner->save();


        return back();
    }
public function editProfile()
{
    $partner = DeliveryPartner::where('user_id', auth()->id())->firstOrFail();
    return view('partner.edit-profile', compact('partner'));
}
public function updateProfile(Request $request)
{
    $partner = DeliveryPartner::where('user_id', auth()->id())->firstOrFail();

    $request->validate([
        'full_name' => 'required|string|max:255',
        'father_name' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'address' => 'nullable|string|max:500',
        'vehicle_type' => 'required|string',
        'profile_photo' => 'nullable|image|max:2048',
    ]);

    // Upload image if updated
    if ($request->hasFile('profile_photo')) {
        $imagePath = $request->file('profile_photo')->store('partners', 'public');
        $partner->profile_photo = $imagePath;
    }

    // Update fields
    $partner->full_name = $request->full_name;
    $partner->father_name = $request->father_name;
    $partner->city = $request->city;
    $partner->state = $request->state;
    $partner->address = $request->address;
    $partner->vehicle_type = $request->vehicle_type;

    $partner->save();

    return back()->with('success', 'Profile updated successfully!');
}

    // ========================
    // DELIVERY PROCESS METHODS
    // ========================

    // 1️⃣ ACCEPT ORDER
    public function acceptOrder($id)
    {
    $partner = DeliveryPartner::where('user_id', auth()->id())->first();

    $order = Order::where('id', $id)
        ->whereNull('partner_id')
        ->where('status', 'placed')
        
        ->first();

    if (!$order) {
        return back()->with('error', 'Order already accepted by another partner.');
    }

    $order->update([
        'partner_id' => $partner->id,
        'status' => 'accepted',
        'delivery_otp' => rand(100000, 999999)
    ]);
        return redirect()->route('partner.dashboard');
    }
public function verifyOtp(Request $request, $id)
{
    $request->validate([
        'otp' => 'required|digits:6'
    ]);

    $order = Order::findOrFail($id);

    if ($order->delivery_otp == $request->otp) {

        // OTP MATCHED
        $order->status = 'delivered';
       
        $order->save();

        return back()->with('success', 'Order delivered successfully!');
    } else {
        return back()->with('error', 'Invalid OTP');
    }
}

    // 2️⃣ MARK PICKED
    public function pickedOrder($id)
    {
        Order::where('id', $id)->update([
            'status' => 'picked'
        ]);

        return back();
    }

    // 3️⃣ MARK ON THE WAY
    public function onTheWay($id)
    {
        Order::where('id', $id)->update([
            'status' => 'on_the_way'
        ]);

        return back();
    }

    // 4️⃣ MARK DELIVERED
    public function delivered($id)
    {
        Order::where('id', $id)->update([
            'status' => 'delivered'
        ]);

        return back();
    }

    // ========================
    // SUBMIT PARTNER FORM
    // ========================

    public function submit(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_photo' => 'nullable|image|max:2048',

            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'address' => 'nullable|string|max:1000',

            'vehicle_type' => 'required|in:bike,scooty,cycle',
            'driving_license_number' => 'required|string|max:100',
            'driving_license_front' => 'required|image|max:4096',
            'driving_license_back' => 'nullable|image|max:4096',

            'police_verification' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if (DeliveryPartner::where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already submitted an application.');
        }

        $store = function ($file, $folder = 'partners') {
            return $file ? $file->store($folder, 'public') : null;
        };

       $partner = DeliveryPartner::create([
    'user_id' => auth()->id(),
    'full_name' => $request->full_name,
    'father_name' => $request->father_name,
    'dob' => $request->dob,
    'gender' => $request->gender,
    'profile_photo' => $store($request->file('profile_photo')),
    'city' => $request->city,
    'state' => $request->state,
    'address' => $request->address,
    'vehicle_type' => $request->vehicle_type,
    'driving_license_number' => $request->driving_license_number,
    'driving_license_front' => $store($request->file('driving_license_front')),
    'driving_license_back' => $store($request->file('driving_license_back')),
    'police_verification' => $store($request->file('police_verification')),
    'status' => 'pending',
    'online_status' => 'offline',
]);

// ✅ ADMIN MAIL
Mail::to(env('ADMIN_EMAIL'))->send(
    new AdminNotificationMail(
        'New Delivery Partner Request',
        [
            'partner_name' => $partner->full_name,
            'phone' => auth()->user()->phone ?? 'N/A',
            'city'  => $partner->city
        ]
    )
);


        $partner->partner_code = 'DP-' . date('Y') . '-' . str_pad($partner->id, 5, '0', STR_PAD_LEFT);
        $partner->save();

        return redirect()->route('partner.status')
            ->with('success', 'Application submitted. Waiting for admin approval.');
    }
}
