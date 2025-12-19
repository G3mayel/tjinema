<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TJINEMA - Cinema Booking')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .cinema-gradient {
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1);
        }

        .admin-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }

        .user-gradient {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 50%, #f0932b 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-glow {
            transition: all 0.3s ease;
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    @auth
        @if (auth()->user()->is_admin)
            <nav class="admin-gradient shadow-2xl sticky top-0 z-50 glass-effect">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-crown text-yellow-400 text-lg"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">TJINEMA</h1>
                                <p class="text-xs text-white/70 font-medium">Admin Panel</p>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden lg:flex items-center space-x-8">
                            <a href="{{ route('admin.dashboard') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-tachometer-alt text-sm"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            <a href="{{ route('admin.movies.index') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-film text-sm"></i>
                                <span class="font-medium">Movies</span>
                            </a>
                            <a href="{{ route('admin.theaters.index') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-building text-sm"></i>
                                <span class="font-medium">Theaters</span>
                            </a>
                            <a href="{{ route('admin.beverages.index') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-coffee text-sm"></i>
                                <span class="font-medium">Beverages</span>
                            </a>
                        </div>

                        <!-- Admin Profile Dropdown -->
                        <div class="hidden lg:flex items-center space-x-4">
                            <div class="flex items-center space-x-3 px-4 py-2 bg-white/10 rounded-xl backdrop-blur-sm">
                                <div class="relative group">
                                    <button
                                        class="flex items-center space-x-3 hover:bg-white/10 px-3 py-2 rounded-lg transition-all">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                                            <i class="fas fa-user-shield text-white text-xs"></i>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-white/70">Administrator</p>
                                        </div>
                                        <i
                                            class="fas fa-chevron-down text-xs text-white/70 group-hover:rotate-180 transition-transform"></i>
                                    </button>
                                    <div
                                        class="absolute right-0 mt-2 w-56 bg-white/10 text-white rounded-xl shadow-2xl backdrop-blur-lg border border-white/20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                        <div class="p-2">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-red-500/20 text-red-300 hover:text-red-200 rounded-lg transition-all">
                                                    <i class="fas fa-sign-out-alt text-sm"></i>
                                                    <span>Logout</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="lg:hidden text-white hover:text-yellow-400 transition-colors"
                            onclick="toggleMobileMenu()">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </nav>
        @else
            <nav class="user-gradient shadow-2xl sticky top-0 z-50 glass-effect">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-film text-yellow-400 text-lg"></i>
                            </div>
                            <div>
                                <h1 class="text-yellow-400 text-2xl font-bold">TJINEMA</h1>
                                <p class="text-xs text-white/70 font-medium">Cinema Experience</p>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden lg:flex items-center space-x-8">
                            <a href="{{ route('movies.index') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-film text-sm"></i>
                                <span class="font-medium">Movies</span>
                            </a>
                            <a href="{{ route('watchlist.index') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-heart text-sm"></i>
                                <span class="font-medium">Watchlist</span>
                            </a>
                            <a href="{{ route('activity.index') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-clock text-sm"></i>
                                <span class="font-medium">My Activities</span>
                            </a>
                        </div>

                        <!-- User Profile Section -->
                        <div class="hidden lg:flex items-center space-x-4">
                            <div class="flex items-center space-x-3 px-4 py-2 bg-white/10 rounded-xl backdrop-blur-sm">
                                <div class="relative group">
                                    <button
                                        class="flex items-center space-x-3 hover:bg-white/10 px-3 py-2 rounded-lg transition-all">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-white/70">Movie Lover</p>
                                        </div>
                                        <i
                                            class="fas fa-chevron-down text-xs text-white/70 group-hover:rotate-180 transition-transform"></i>
                                    </button>
                                    <div
                                        class="absolute right-0 mt-2 w-56 bg-white/10 text-white rounded-xl shadow-2xl backdrop-blur-lg border border-white/20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                        <div class="p-2">
                                            <a href="{{ route('profile.index') }}"
                                                class="flex items-center space-x-3 px-4 py-3 hover:bg-white/10 rounded-lg transition-all">
                                                <i class="fas fa-user-circle text-sm"></i>
                                                <span>My Profile</span>
                                            </a>
                                            <a href="{{ route('activity.index') }}"
                                                class="flex items-center space-x-3 px-4 py-3 hover:bg-white/10 rounded-lg transition-all">
                                                <i class="fas fa-history text-sm"></i>
                                                <span>Booking History</span>
                                            </a>
                                            <a href="{{ route('watchlist.index') }}"
                                                class="flex items-center space-x-3 px-4 py-3 hover:bg-white/10 rounded-lg transition-all">
                                                <i class="fas fa-heart text-sm"></i>
                                                <span>My Watchlist</span>
                                            </a>
                                            <div class="border-t border-white/10 my-2"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-red-500/20 text-red-300 hover:text-red-200 rounded-lg transition-all">
                                                    <i class="fas fa-sign-out-alt text-sm"></i>
                                                    <span>Logout</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Menu Button -->
                        <button class="lg:hidden text-white hover:text-red-400 transition-colors"
                            onclick="toggleMobileMenu()">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </nav>
        @endif

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu"
            class="mobile-menu fixed inset-y-0 left-0 w-80 bg-gray-900/95 backdrop-blur-lg z-50 lg:hidden border-r border-white/10">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-red-500 to-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-film text-white text-sm"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">TJINEMA</h2>
                    </div>
                    <button class="text-white hover:text-red-400 transition-colors" onclick="toggleMobileMenu()">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.movies.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                            <i class="fas fa-film"></i>
                            <span>Movies</span>
                        </a>
                        <a href="{{ route('admin.theaters.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                            <i class="fas fa-building"></i>
                            <span>Theaters</span>
                        </a>
                        <a href="{{ route('admin.beverages.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                            <i class="fas fa-coffee"></i>
                            <span>Beverages</span>
                        </a>
                    @else
                        <a href="{{ route('movies.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                            <i class="fas fa-film"></i>
                            <span>Movies</span>
                        </a>
                        <a href="{{ route('watchlist.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                            <i class="fas fa-heart"></i>
                            <span>Watchlist</span>
                        </a>
                        <a href="{{ route('activity.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                            <i class="fas fa-clock"></i>
                            <span>My Activities</span>
                        </a>
                    @endif

                    <div class="border-t border-white/10 my-4"></div>

                    <a href="{{ route('profile.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center space-x-3 px-4 py-3 text-red-300 hover:bg-red-500/20 rounded-lg transition-all">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- Guest Navigation -->
        <nav class="gradient-bg shadow-2xl sticky top-0 z-50 glass-effect">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo Section -->
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-film text-yellow-400 text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-yellow-400 text-2xl font-bold">TJINEMA</h1>
                            <p class="text-xs text-white/70 font-medium">Premium Cinema</p>
                        </div>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center space-x-8">
                        <a href="#"
                            class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                            <i class="fas fa-home text-sm"></i>
                            <span class="font-medium">Home</span>
                        </a>
                        <a href="#"
                            class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                            <i class="fas fa-film text-sm"></i>
                            <span class="font-medium">Movies</span>
                        </a>
                        <a href="#"
                            class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                            <i class="fas fa-info-circle text-sm"></i>
                            <span class="font-medium">About</span>
                        </a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="hidden lg:flex items-center space-x-4">
                        <div class="flex items-center space-x-3 px-4 py-2 bg-white/10 rounded-xl backdrop-blur-sm">
                            <a href="{{ route('login') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow text-white/90 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-sign-in-alt text-sm"></i>
                                <span class="font-medium">Login</span>
                            </a>
                            <div class="w-px h-6 bg-white/20"></div>
                            <a href="{{ route('register') }}"
                                class="group flex items-center space-x-2 px-4 py-2 rounded-xl hover-glow bg-gradient-to-r from-yellow-500 to-orange-500 text-white hover:from-yellow-400 hover:to-orange-400 transition-all shadow-lg">
                                <i class="fas fa-user-plus text-sm"></i>
                                <span class="font-medium">Register</span>
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden text-white hover:text-yellow-400 transition-colors"
                        onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu Overlay for Guests -->
        <div id="mobile-menu"
            class="mobile-menu fixed inset-y-0 left-0 w-80 bg-gray-900/95 backdrop-blur-lg z-50 lg:hidden border-r border-white/10">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-film text-white text-sm"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">TJINEMA</h2>
                    </div>
                    <button class="text-white hover:text-yellow-400 transition-colors" onclick="toggleMobileMenu()">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                        <i class="fas fa-film"></i>
                        <span>Movies</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                        <i class="fas fa-info-circle"></i>
                        <span>About</span>
                    </a>

                    <div class="border-t border-white/10 my-4"></div>

                    <a href="{{ route('login') }}"
                        class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-all">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:from-yellow-400 hover:to-orange-400 transition-all">
                        <i class="fas fa-user-plus"></i>
                        <span>Register</span>
                    </a>
                </div>
            </div>
        </div>
    @endauth

    <main class="min-h-screen">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 text-center animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 text-center animate-pulse">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-center py-8 mt-16">
        <div class="container mx-auto px-4">
            <h3 class="text-xl font-bold cinema-gradient bg-clip-text text-transparent mb-4">TJINEMA</h3>
            <p class="text-gray-400">Your Premium Cinema Experience</p>
            <div class="flex justify-center space-x-4 mt-4">
                <i
                    class="fab fa-facebook text-blue-500 text-xl hover:scale-110 transition-transform cursor-pointer"></i>
                <i
                    class="fab fa-instagram text-pink-500 text-xl hover:scale-110 transition-transform cursor-pointer"></i>
                <i
                    class="fab fa-twitter text-blue-400 text-xl hover:scale-110 transition-transform cursor-pointer"></i>
            </div>
        </div>
    </footer>

    <script>
        gsap.from("main", {
            duration: 1,
            opacity: 0,
            y: 50,
            delay: 0.3
        });

        document.addEventListener('DOMContentLoaded', function() {
            gsap.from(".animate-card", {
                duration: 0.8,
                y: 50,
                opacity: 0,
                stagger: 0.2,
                ease: "power2.out"
            });
        });

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = event.target.closest('button');

            if (!mobileMenu.contains(event.target) && !menuButton) {
                mobileMenu.classList.remove('active');
            }
        });

        // Smooth scrolling for navbar links
        document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
