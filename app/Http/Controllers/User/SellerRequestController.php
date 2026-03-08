<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerRequest;

class SellerRequestController extends Controller
{
    /**
     * Show Become Seller form
     */
    public function create()
    {
        // Agar user already supplier hai
        if (auth()->user()->role === 'supplier') {
            return redirect()->back()->with('error', 'You are already a seller.');
        }

        // Agar request already pending ho
        $alreadyRequested = SellerRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($alreadyRequested) {
            return redirect()->back()->with('info', 'Your seller request is already under review.');
        }

        return view('user.seller_request.create');
    }

    /**
     * Store seller request
     */
    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'gst' => 'nullable|string|max:50',
        ]);

        SellerRequest::create([
            'user_id'       => auth()->id(),
            'business_name' => $request->business_name,
            'gst'           => $request->gst,
            'status'        => 'pending',
        ]);

        return redirect()->back()->with('success', 'Seller request sent successfully. Please wait for admin approval.');
    }
}
