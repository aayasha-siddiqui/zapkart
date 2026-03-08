<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
  
public function supplierLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        if ($user->role !== 'supplier') {
            Auth::logout();
            return back()->withErrors(['email' => 'Not a supplier account']);
        }

        return redirect('/suppliers/dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}

}

