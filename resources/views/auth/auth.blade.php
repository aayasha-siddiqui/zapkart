@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center
            bg-gradient-to-br from-[#f5efe7] via-[#efe4d8] to-[#e6d3bd] px-4">

    <div class="bg-white w-full max-w-md rounded-3xl
                shadow-2xl p-8 border border-[#d2b48c]">

        {{-- LOGO / TITLE --}}
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto mb-3 rounded-full
                        bg-[#ede0d4] flex items-center justify-center text-2xl">
                🏺
            </div>
            <h2 class="text-2xl font-extrabold text-[#5a3e2b]">
                Welcome to Zapkart
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Desi • Trusted • Reliable
            </p>
        </div>

        {{-- ================= LOGIN ================= --}}
        <div id="loginBox" class="space-y-4 animate-fade">

            <h3 class="text-lg font-bold text-center text-[#5a3e2b]">
                Login
            </h3>

            @if($errors->has('login'))
                <p class="text-red-600 text-sm text-center">
                    {{ $errors->first('login') }}
                </p>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-3">
                @csrf

                {{-- EMAIL --}}
                <div class="relative">
                    <span class="absolute left-3 top-3 text-[#8b6f4e]">📧</span>
                    <input
                        name="login_email"
                        type="email"
                        placeholder="Email"
                        required
                        class="w-full pl-10 pr-4 py-3 border border-[#d2b48c]
                               rounded-xl focus:ring focus:ring-[#c07a35]
                               outline-none">
                </div>

                {{-- PASSWORD --}}
                <div class="relative">
                    <span class="absolute left-3 top-3 text-[#8b6f4e]">🔒</span>
                    <input
                        name="login_password"
                        type="password"
                        placeholder="Password"
                        required
                        class="w-full pl-10 pr-4 py-3 border border-[#d2b48c]
                               rounded-xl focus:ring focus:ring-[#c07a35]
                               outline-none">
                </div>

                <button
                    class="w-full bg-[#6b4f2c] hover:bg-[#5a3e22]
                           text-white py-3 rounded-xl font-semibold
                           transition transform hover:scale-[1.02]">
                    Login
                </button>
            </form>

            <div class="flex justify-between text-sm mt-2">
                <button onclick="showForgot()"
                        class="text-red-600 font-semibold hover:underline">
                    Forgot password?
                </button>

                <button onclick="showRegister()"
                        class="text-[#6b4f2c] font-semibold hover:underline">
                    Create account
                </button>
            </div>
        </div>

        {{-- ================= REGISTER ================= --}}
        <div id="registerBox" class="space-y-4 hidden animate-fade">

            <h3 class="text-lg font-bold text-center text-[#5a3e2b]">
                Create Account
            </h3>

            @if($errors->has('register'))
                <p class="text-red-600 text-sm text-center">
                    {{ $errors->first('register') }}
                </p>
            @endif

            {{-- SEND OTP --}}
            <form method="POST" action="{{ route('register.sendOtp') }}" class="space-y-3">
                @csrf

                <div class="relative">
                    <span class="absolute left-3 top-3 text-[#8b6f4e]">📧</span>
                    <input
                        name="register_email"
                        type="email"
                        placeholder="Email"
                        required
                        class="w-full pl-10 pr-4 py-3 border border-[#d2b48c]
                               rounded-xl focus:ring focus:ring-[#c07a35]
                               outline-none">
                </div>

                <button
                    class="w-full bg-[#8b6f4e] hover:bg-[#6b4f2c]
                           text-white py-3 rounded-xl font-semibold">
                    Send OTP
                </button>
            </form>

            {{-- OTP FORM --}}
            @if(session('otp_sent'))
            <form method="POST" action="{{ route('register.verify') }}" class="space-y-3">
                @csrf

                <input name="otp" placeholder="Enter OTP"
                       required class="w-full border border-[#d2b48c]
                       rounded-xl p-3">

                <input name="name" placeholder="Full Name"
                       required class="w-full border border-[#d2b48c]
                       rounded-xl p-3">

                <input name="password" type="password"
                       placeholder="Create Password"
                       required class="w-full border border-[#d2b48c]
                       rounded-xl p-3">

                <button
                    class="w-full bg-[#6b4f2c] hover:bg-[#5a3e22]
                           text-white py-3 rounded-xl font-semibold">
                    Register & Login
                </button>
            </form>
            @endif

            <p class="text-center text-sm mt-2">
                Already have an account?
                <button onclick="showLogin()"
                        class="text-[#6b4f2c] font-semibold hover:underline">
                    Login
                </button>
            </p>
        </div>

        {{-- ================= FORGOT ================= --}}
        <div id="forgotBox" class="space-y-4 hidden animate-fade">

            <h3 class="text-lg font-bold text-center text-[#5a3e2b]">
                Reset Password
            </h3>

            @if(session('forgot_status'))
                <p class="text-green-700 text-sm text-center">
                    {{ session('forgot_status') }}
                </p>
            @endif

            <form method="POST" action="{{ route('password.forgot') }}" class="space-y-3">
                @csrf

                <div class="relative">
                    <span class="absolute left-3 top-3 text-[#8b6f4e]">📧</span>
                    <input
                        name="email"
                        type="email"
                        placeholder="Registered Email"
                        required
                        class="w-full pl-10 pr-4 py-3 border border-[#d2b48c]
                               rounded-xl focus:ring focus:ring-[#c07a35]
                               outline-none">
                </div>

                <button
                    class="w-full bg-[#a0522d] hover:bg-[#8b4513]
                           text-white py-3 rounded-xl font-semibold">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center text-sm mt-2">
                Remember password?
                <button onclick="showLogin()"
                        class="text-[#6b4f2c] font-semibold hover:underline">
                    Login
                </button>
            </p>
        </div>

    </div>
</div>

{{-- ================= JS ================= --}}
<script>
const loginBox = document.getElementById('loginBox');
const registerBox = document.getElementById('registerBox');
const forgotBox = document.getElementById('forgotBox');

function showRegister(){
    loginBox.classList.add('hidden');
    forgotBox.classList.add('hidden');
    registerBox.classList.remove('hidden');
}
function showLogin(){
    registerBox.classList.add('hidden');
    forgotBox.classList.add('hidden');
    loginBox.classList.remove('hidden');
}
function showForgot(){
    loginBox.classList.add('hidden');
    registerBox.classList.add('hidden');
    forgotBox.classList.remove('hidden');
}
</script>

<style>
@keyframes fadeIn {
    from { opacity:0; transform: translateY(10px); }
    to { opacity:1; transform: translateY(0); }
}
.animate-fade {
    animation: fadeIn .35s ease-in-out;
}
</style>
@endsection
