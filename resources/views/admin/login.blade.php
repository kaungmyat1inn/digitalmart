<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - DigitalMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-600 to-blue-800 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">DigitalMart Admin</h1>
                <p class="text-gray-600">Admin Dashboard Login</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="admin@example.com">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="••••••••">
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition transform hover:scale-105 active:scale-95">
                    Login to Admin Dashboard
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-sm font-semibold text-gray-700 mb-2">Demo Credentials:</p>
                <p class="text-sm text-gray-600">
                    <span class="font-mono bg-white px-2 py-1 rounded">digitalmart.mag@gmail.com</span>
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-mono bg-white px-2 py-1 rounded">123456</span>
                </p>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    ← Back to Home
                </a>
            </div>
        </div>

        <!-- Footer Text -->
        <div class="text-center mt-8 text-white">
            <p class="text-sm opacity-75">© 2026 DigitalMart. All rights reserved.</p>
        </div>
    </div>
</body>

</html>