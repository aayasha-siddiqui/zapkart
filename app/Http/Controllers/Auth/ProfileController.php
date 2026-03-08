<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showCompleteForm()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login.phone');
        return view('auth.profile_complete', compact('user'));
    }

    public function complete(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return redirect()->route('dashboard')->with('status','Profile completed');
    }
}

