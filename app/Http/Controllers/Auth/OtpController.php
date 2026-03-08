<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use App\Models\Otp;

class OtpController extends Controller
{
    /* =====================
       SHOW LOGIN / REGISTER
    ===================== */
    public function showForm()
    {
        return view('auth.auth');
    }

    /* =====================
       LOGIN
    ===================== */
    public function login(Request $request)
    {
        $request->validate([
            'login_email' => 'required|email',
            'login_password' => 'required'
        ]);

        if (!Auth::attempt([
            'email' => $request->login_email,
            'password' => $request->login_password
        ])) {
            return back()->withErrors(['login' => 'Invalid email or password']);
        }

        return $this->redirectByRole(Auth::user());
    }

    /* =====================
       SEND OTP (REGISTER)
    ===================== */
    public function sendOtp(Request $request)
    {
        $request->validate(['register_email' => 'required|email']);

        if (User::where('email', $request->register_email)->exists()) {
            return back()->withErrors(['register' => 'Email already registered']);
        }

        $otp = rand(100000,999999);

        Otp::create([
            'email' => $request->register_email,
            'code' => $otp,
            'expires_at' => now()->addMinutes(5),
            'used' => false
        ]);

        Mail::raw("Your OTP is $otp", function ($m) use ($request) {
            $m->to($request->register_email)->subject('Zapkart OTP');
        });

        session(['register_email' => $request->register_email]);

        return back()->with('otp_sent', true);
    }

    /* =====================
       VERIFY OTP + REGISTER
    ===================== */
    public function verifyOtpAndRegister(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'name' => 'required',
            'password' => 'required|min:6'
        ]);

        $email = session('register_email');

        $otp = Otp::where('email',$email)
            ->where('code',$request->otp)
            ->where('used',false)
            ->first();

        if (!$otp || $otp->expires_at < now()) {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

        $otp->update(['used'=>true]);

        $user = User::create([
            'email' => $email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    /* =====================
       ROLE REDIRECT
    ===================== */
    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'supplier' => redirect('/suppliers/dashboard'),
            'seller' => redirect('/seller/dashboard'),
             'driver' => redirect('/partner/dashboard'),
             'shopkeeper' =>redirect('/shopkeeper/dashboard'),
        default => redirect('/'),
        };
    }
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('auth.form');
}
    public function forgotPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return back()->with(
        'forgot_status',
        $status === Password::RESET_LINK_SENT
            ? 'Password reset link sent to your email'
            : 'Email not found'
    );
}

/* =====================
   RESET PASSWORD
===================== */
public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $status = Password::reset(
        $request->only('email','password','password_confirmation','token'),
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('auth.form')->with('login','Password reset successfully')
        : back()->withErrors(['email' => 'Invalid token']);
}
}
