@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 text-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-red-900/20 via-purple-900/20 to-blue-900/20 py-16">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-900/80"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-red-400 via-purple-400 to-blue-400 bg-clip-text text-transparent">
                    My Profile
                </h1>
                <p class="text-xl text-gray-300">Manage your cinema experience</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-lg rounded-2xl p-8 border border-gray-700/50 shadow-2xl hover:shadow-red-500/10 transition-all duration-300">
                        <div class="text-center">
                            <!-- Avatar Section -->
                            <div class="relative mb-6">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Profile Picture" class="w-32 h-32 rounded-full mx-auto object-cover ring-4 ring-gradient-to-r from-red-500 to-purple-500 shadow-lg">
                                @else
                                    <div class="w-32 h-32 rounded-full mx-auto bg-gradient-to-br from-red-500 to-purple-600 flex items-center justify-center text-4xl font-bold text-white shadow-lg ring-4 ring-red-500/30">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-gray-800 flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>

                            <!-- User Info -->
                            <h3 class="text-2xl font-bold mb-2 text-white">{{ auth()->user()->name }}</h3>
                            <p class="text-gray-400 mb-1 flex items-center justify-center">
                                <i class="fas fa-envelope mr-2 text-red-400"></i>
                                {{ auth()->user()->email }}
                            </p>
                            <p class="text-sm text-gray-500 flex items-center justify-center">
                                <i class="fas fa-calendar-alt mr-2 text-purple-400"></i>
                                Member since {{ auth()->user()->created_at->format('M Y') }}
                            </p>

                            <!-- Member Badge -->
                            <div class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500/20 to-orange-500/20 border border-yellow-500/30 rounded-full">
                                <i class="fas fa-star text-yellow-400 mr-2"></i>
                                <span class="text-yellow-400 font-medium">Premium Member</span>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Card -->
                    <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-lg rounded-2xl p-6 border border-gray-700/50 shadow-2xl mt-6">
                        <h4 class="font-bold text-lg mb-6 flex items-center">
                            <i class="fas fa-chart-bar mr-3 text-blue-400"></i>
                            Your Statistics
                        </h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-red-500/10 to-red-600/10 rounded-xl border border-red-500/20">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-film text-red-400"></i>
                                    </div>
                                    <span class="text-gray-300">Movies Watched</span>
                                </div>
                                <span class="font-bold text-white text-xl">{{ $moviesWatched }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-500/10 to-purple-600/10 rounded-xl border border-purple-500/20">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-ticket-alt text-purple-400"></i>
                                    </div>
                                    <span class="text-gray-300">Total Bookings</span>
                                </div>
                                <span class="font-bold text-white text-xl">{{ $totalBookings }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-500/10 to-blue-600/10 rounded-xl border border-blue-500/20">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-heart text-blue-400"></i>
                                    </div>
                                    <span class="text-gray-300">Watchlist Items</span>
                                </div>
                                <span class="font-bold text-white text-xl">{{ $watchlistCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forms Section -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Profile Edit Form -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-lg rounded-2xl p-8 border border-gray-700/50 shadow-2xl">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-user-edit text-white text-lg"></i>
                                </div>
                                <h4 class="text-2xl font-bold text-white">Edit Profile</h4>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Full Name -->
                                <div>
                                    <label class="block text-sm font-medium mb-3 text-gray-300 flex items-center">
                                        <i class="fas fa-user mr-2 text-purple-400"></i>
                                        Full Name
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-white backdrop-blur-sm placeholder-gray-400" required>
                                    @error('name')
                                        <p class="text-red-400 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium mb-3 text-gray-300 flex items-center">
                                        <i class="fas fa-envelope mr-2 text-blue-400"></i>
                                        Email Address
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-white backdrop-blur-sm placeholder-gray-400" required>
                                    @error('email')
                                        <p class="text-red-400 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="group relative px-8 py-3 bg-gradient-to-r from-red-600 to-purple-600 hover:from-red-700 hover:to-purple-700 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-red-500/25 transform hover:scale-105">
                                    <span class="flex items-center">
                                        <i class="fas fa-save mr-2"></i>
                                        Update Profile
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Change Password Form -->
                    <form action="{{ route('profile.change-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-lg rounded-2xl p-8 border border-gray-700/50 shadow-2xl">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-lock text-white text-lg"></i>
                                </div>
                                <h4 class="text-2xl font-bold text-white">Change Password</h4>
                            </div>

                            <div class="space-y-6">
                                <!-- Current Password -->
                                <div>
                                    <label class="block text-sm font-medium mb-3 text-gray-300 flex items-center">
                                        <i class="fas fa-key mr-2 text-orange-400"></i>
                                        Current Password
                                    </label>
                                    <input type="password" name="current_password" class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-white backdrop-blur-sm placeholder-gray-400" required>
                                    @error('current_password')
                                        <p class="text-red-400 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <!-- New Password -->
                                    <div>
                                        <label class="block text-sm font-medium mb-3 text-gray-300 flex items-center">
                                            <i class="fas fa-unlock-alt mr-2 text-green-400"></i>
                                            New Password
                                        </label>
                                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all text-white backdrop-blur-sm placeholder-gray-400" required>
                                        @error('password')
                                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label class="block text-sm font-medium mb-3 text-gray-300 flex items-center">
                                            <i class="fas fa-check-circle mr-2 text-blue-400"></i>
                                            Confirm New Password
                                        </label>
                                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-white backdrop-blur-sm placeholder-gray-400" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="group relative px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-orange-500/25 transform hover:scale-105">
                                    <span class="flex items-center">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        Change Password
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Add smooth animations
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards on scroll
        const cards = document.querySelectorAll('.bg-gradient-to-br');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });

        // Add hover effects for input fields
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection
@endsection
