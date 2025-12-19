@extends('layouts.app')

@section('title', 'Register - TJINEMA')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-2xl border border-white/20 animate-card">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold cinema-gradient bg-clip-text text-transparent">Join TJINEMA</h2>
                <p class="text-gray-300 mt-2">Create your cinema experience account</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-200">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    @error('name')
                        <p class="text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-200">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    @error('email')
                        <p class="text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-200">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                    @error('phone')
                        <p class="text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                        <button type="button" onclick="togglePassword('password', 'toggleIcon1')" class="absolute right-3 top-3 text-gray-400 hover:text-white">
                            <i class="fas fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-200">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300">
                        <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')" class="absolute right-3 top-3 text-gray-400 hover:text-white">
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-pink-600 bg-white/10 border-white/20 rounded focus:ring-pink-500">
                    <label for="terms" class="ml-2 text-sm text-gray-300">
                        I agree to the <a href="#" class="text-pink-400 hover:text-pink-300">Terms and Conditions</a>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    Create Account
                </button>

                <div class="text-center">
                    <p class="text-gray-300">Already have an account?
                        <a href="{{ route('login') }}" class="text-pink-400 hover:text-pink-300 font-semibold">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

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
