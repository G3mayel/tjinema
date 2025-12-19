@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <!-- Header with Glassmorphism -->
        <div class="text-center mb-12">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-xl">
                <h1 class="text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        My Watchlist
                    </span>
                </h1>
                <p class="text-xl text-white/80">
                    {{ $watchlist->count() }} movie{{ $watchlist->count() !== 1 ? 's' : '' }} in your watchlist
                </p>
            </div>
        </div>

        @if($watchlist->isEmpty())
            <!-- Empty State with Glassmorphism -->
            <div class="text-center py-16">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-12 border border-white/20 shadow-xl">
                    <div class="text-6xl mb-4">🎬</div>
                    <h3 class="text-2xl font-bold text-white mb-4">Your watchlist is empty</h3>
                    <p class="text-white/60 text-lg mb-8">Start adding movies you want to watch to your watchlist</p>
                    <a href="{{ route('movies.index') }}" class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 hover:scale-105 shadow-lg">
                        Browse Movies
                    </a>
                </div>
            </div>
        @else
            <!-- Movies Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($watchlist as $item)
                    <div class="movie-card group watchlist-item" data-movie-id="{{ $item->movie->id }}">
                        <div class="bg-white/10 backdrop-blur-lg rounded-xl overflow-hidden border border-white/20 shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <!-- Movie Poster -->
                            <div class="relative">
                                <img src="{{ Storage::url($item->movie->poster) }}" alt="{{ $item->movie->title }}" class="w-full h-80 object-cover">

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('movies.show', $item->movie->id) }}"
                                           class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white p-3 rounded-full transition-all duration-300 hover:scale-110">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <button class="remove-from-watchlist bg-red-500/80 backdrop-blur-sm hover:bg-red-600/90 text-white p-3 rounded-full transition-all duration-300 hover:scale-110" data-movie-id="{{ $item->movie->id }}">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                @if($item->movie->isExpired())
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-red-500/90 backdrop-blur-sm text-white text-sm px-3 py-1 rounded-full font-semibold">
                                            No Longer Showing
                                        </span>
                                    </div>
                                @endif

                                <!-- Rating Badge -->
                                <div class="absolute bottom-4 left-4">
                                    <span class="bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                        {{ $item->movie->rating }}
                                    </span>
                                </div>
                            </div>

                            <!-- Movie Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-3 line-clamp-2">{{ $item->movie->title }}</h3>

                                <div class="flex items-center justify-between text-sm text-white/70 mb-3">
                                    <span class="bg-white/10 px-3 py-1 rounded-full">{{ $item->movie->genre }}</span>
                                    <span class="font-medium">{{ $item->movie->duration }} min</span>
                                </div>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-green-400">
                                        Rp {{ number_format($item->movie->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                @if(!$item->movie->isExpired())
                                    <a href="{{ route('bookings.date', $item->movie->id) }}"
                                       class="block w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-center py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 shadow-lg mb-3">
                                        Book Now
                                    </a>
                                @endif

                                <div class="text-center text-sm text-white/50">
                                    Added {{ $item->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Expired Movies Notice -->
            @if($expiredMovies > 0)
                <div class="mb-8">
                    <div class="bg-yellow-500/10 backdrop-blur-lg border border-yellow-500/30 rounded-xl p-6 shadow-xl">
                        <div class="flex items-center">
                            <div class="bg-yellow-500/20 backdrop-blur-sm rounded-full p-2 mr-4">
                                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-yellow-400 text-lg mb-1">Notice</h4>
                                <p class="text-yellow-300">
                                    {{ $expiredMovies }} movie{{ $expiredMovies !== 1 ? 's' : '' }} in your watchlist {{ $expiredMovies === 1 ? 'is' : 'are' }} no longer showing and will be automatically removed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.movie-card {
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

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-from-watchlist').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const movieId = this.dataset.movieId;

            if (confirm('Remove this movie from your watchlist?')) {
                fetch(`/watchlist/${movieId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const movieItem = document.querySelector(`.watchlist-item[data-movie-id="${movieId}"]`);
                        movieItem.style.transform = 'scale(0)';
                        movieItem.style.opacity = '0';
                        setTimeout(() => {
                            movieItem.remove();
                            location.reload();
                        }, 300);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove from watchlist');
                });
            }
        });
    });
});
</script>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    // GSAP animation
    gsap.from(".movie-card", {
        duration: 0.8,
        y: 30,
        opacity: 0,
        stagger: 0.1,
        ease: "power2.out",
        delay: 0.2
    });
</script>
@endsection
