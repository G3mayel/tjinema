@extends('layouts.app')

@section('title', 'Login - TJINEMA')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-2xl border border-white/20 animate-card">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold cinema-gradient bg-clip-text text-transparent">Welcome Back</h2>
                <p class="text-gray-300 mt-2">Sign in to your TJINEMA account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-200">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    @error('email')
                        <p class="text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-gray-400 hover:text-white">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-purple-600 bg-white/10 border-white/20 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-300">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-purple-400 hover:text-purple-300">Forgot password?</a>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    Sign In
                </button>

                <div class="text-center">
                    <p class="text-gray-300">Don't have an account?
                        <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 font-semibold">Sign up</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    gsap.from(".animate-card", {
        duration: 1,
        scale: 0.8,
        opacity: 0,
        ease: "back.out(1.7)"
    });
</script>
@endsection
