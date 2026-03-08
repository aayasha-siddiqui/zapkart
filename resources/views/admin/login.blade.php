<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded shadow w-96">

        <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>

        {{-- Error Message --}}
        @if(session('error'))
            <p class="text-red-500 text-sm mb-3">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" autocomplete="off">
            @csrf

            {{-- Hidden dummy fields to prevent autofill --}}
            <input type="text" name="fakeusernameremembered" style="display:none">
            <input type="password" name="fakepasswordremembered" style="display:none">

            {{-- Email --}}
            <input name="email" type="email" placeholder="Email" required
                   class="w-full p-2 mb-3 border rounded" autocomplete="new-email">

            {{-- Password --}}
            <input name="password" type="password" placeholder="Password" required
                   class="w-full p-2 mb-3 border rounded" autocomplete="new-password">

            {{-- Submit Button --}}
            <button type="submit" class="w-full bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700 transition">
                Login
            </button>
        </form>

        {{-- Optional: Forgot password --}}
        <div class="mt-4 text-center text-sm text-gray-500">
            <a href="#" class="hover:underline">Forgot Password?</a>
        </div>

    </div>
</div>

</body>
</html>
