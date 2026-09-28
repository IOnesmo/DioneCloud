<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DioneCloud</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #0d2d5e 0%, #1e7a3a 100%);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-2xl mb-4">
                <svg class="w-12 h-12 text-[#0d2d5e]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Dione<span class="text-[#e8a020]">Cloud</span></h1>
            <p class="text-white/80">Create your account</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-[#0d2d5e] mb-2">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#0d2d5e] focus:outline-none transition">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-[#0d2d5e] mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#0d2d5e] focus:outline-none transition">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-[#0d2d5e] mb-2">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#0d2d5e] focus:outline-none transition">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-[#0d2d5e] mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#0d2d5e] focus:outline-none transition">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#0d2d5e] text-white py-3 rounded-lg font-bold hover:bg-[#1a3a6b] transition shadow-lg">
                    Register
                </button>

                <!-- Login Link -->
                <p class="mt-6 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-[#e8a020] font-bold hover:text-[#0d2d5e]">Sign in here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
