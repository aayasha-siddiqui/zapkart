<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 🔥 Only admin can login here
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin'
        ])) {
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid admin credentials!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.form');
    }
}

