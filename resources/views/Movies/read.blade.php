@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <!-- Simple Header -->
        <div class="text-center mb-12">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-xl">
                <h1 class="text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        Now Showing
                    </span>
                </h1>
                <p class="text-xl text-white/80">Discover amazing movies at TJINEMA</p>
            </div>
        </div>

        <!-- Movies Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-16">
            @foreach($nowShowing as $movie)
            <div class="movie-card group">
                <div class="bg-white/10 backdrop-blur-lg rounded-xl overflow-hidden border border-white/20 shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <!-- Movie Poster -->
                    <div class="relative">
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                             class="w-full h-80 object-cover">

                        <!-- Watchlist Button -->
                        <div class="absolute top-4 right-4">
                            <form action="{{ route('movies.watchlist.toggle', $movie->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full p-2 transition-all duration-300">
                                    @if($movie->watchlists->where('user_id', auth()->id())->isNotEmpty())
                                        <svg class="w-5 h-5 text-red-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </div>

                        <!-- Rating -->
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                {{ $movie->rating }}
                            </span>
                        </div>
                    </div>

                    <!-- Movie Info -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $movie->title }}</h3>

                        <div class="flex items-center space-x-4 text-sm text-white/70 mb-3">
                            <span class="bg-white/10 px-2 py-1 rounded">{{ $movie->genre }}</span>
                            <span>{{ $movie->duration }} min</span>
                        </div>

                        <p class="text-white/80 text-sm mb-4 line-clamp-3">{{ $movie->description }}</p>

                        <!-- Price and Book Button -->
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-green-400">
                                Rp {{ number_format($movie->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('bookings.date', $movie->id) }}"
                               class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 hover:scale-105">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($nowShowing->isEmpty())
        <div class="text-center py-16">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-12 border border-white/20">
                <div class="text-6xl mb-4">🎬</div>
                <h3 class="text-2xl font-bold text-white mb-2">No Movies Currently Showing</h3>
                <p class="text-white/60">Check back later for new releases!</p>
            </div>
        </div>
        @endif

        <!-- Coming Soon Section -->
        @if($comingSoon->isNotEmpty())
        <div class="mb-8">
            <div class="text-center mb-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-xl">
                    <h2 class="text-4xl font-bold mb-2">
                        <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            Coming Soon
                        </span>
                    </h2>
                    <p class="text-lg text-white/80">Get ready for these upcoming releases</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($comingSoon as $movie)
                <div class="coming-soon-card">
                    <div class="bg-white/10 backdrop-blur-lg rounded-xl overflow-hidden border border-white/20 shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 opacity-80 hover:opacity-100">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                 class="w-full h-80 object-cover grayscale hover:grayscale-0 transition-all duration-300">

                            <!-- Coming Soon Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    Coming Soon
                                </span>
                            </div>

                            <!-- Rating -->
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $movie->rating }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $movie->title }}</h3>
                            <div class="flex items-center space-x-4 text-sm text-white/70 mb-3">
                                <span class="bg-white/10 px-2 py-1 rounded">{{ $movie->genre }}</span>
                                <span>{{ $movie->duration }} min</span>
                            </div>
                            <p class="text-white/80 text-sm mb-4 line-clamp-3">{{ $movie->description }}</p>
                            <p class="text-blue-400 font-semibold">
                                Available from: {{ $movie->showing_start->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.movie-card, .coming-soon-card {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

.movie-card:nth-child(1) { animation-delay: 0.1s; }
.movie-card:nth-child(2) { animation-delay: 0.2s; }
.movie-card:nth-child(3) { animation-delay: 0.3s; }
.movie-card:nth-child(4) { animation-delay: 0.4s; }
.movie-card:nth-child(5) { animation-delay: 0.5s; }
.movie-card:nth-child(6) { animation-delay: 0.6s; }
.movie-card:nth-child(7) { animation-delay: 0.7s; }
.movie-card:nth-child(8) { animation-delay: 0.8s; }

.coming-soon-card:nth-child(1) { animation-delay: 0.9s; }
.coming-soon-card:nth-child(2) { animation-delay: 1.0s; }
.coming-soon-card:nth-child(3) { animation-delay: 1.1s; }
.coming-soon-card:nth-child(4) { animation-delay: 1.2s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    // Simple GSAP animation
    gsap.from(".movie-card, .coming-soon-card", {
        duration: 0.8,
        y: 30,
        opacity: 0,
        stagger: 0.1,
        ease: "power2.out",
        delay: 0.2
    });
</script>
@endsection
