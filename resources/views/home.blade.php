@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 text-white">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-900 via-gray-900 to-black opacity-90"></div>
        <div class="relative container mx-auto px-4 py-20">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">
                    TJINEMA
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                    Experience the magic of cinema with the latest blockbusters and timeless classics
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('movies.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                        Browse Movies
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                            Join Now
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <section class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Now Showing</h2>
                <a href="{{ route('movies.index') }}" class="text-red-500 hover:text-red-400 font-medium">
                    View All →
                </a>
            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($nowShowingMovies as $movie)
                    <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300 group">
                        <div class="relative">
                            <img src="{{ Storage::url($movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <div class="flex space-x-2">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @auth
                                        <button class="add-to-watchlist bg-gray-600 hover:bg-gray-700 text-white p-2 rounded-full" data-movie-id="{{ $movie->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded">
                                {{ $movie->rating }}
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-sm mb-2 line-clamp-2">{{ $movie->title }}</h3>
                            <div class="flex items-center justify-between text-xs text-gray-400 mb-2">
                                <span>{{ $movie->genre }}</span>
                                <span>{{ $movie->duration }}min</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-red-500 font-bold">Rp {{ number_format($movie->price, 0, ',', '.') }}</span>
                                <a href="{{ route('bookings.date', $movie->id) }}" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded transition duration-200">
                                    Book
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-3xl font-bold mb-8">Coming Soon</h2>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($comingSoonMovies as $movie)
                    <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300 group">
                        <div class="relative">
                            <img src="{{ Storage::url($movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <a href="{{ route('movies.show', $movie->id) }}" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                Coming Soon
                            </div>
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded">
                                {{ $movie->rating }}
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-sm mb-2 line-clamp-2">{{ $movie->title }}</h3>
                            <div class="flex items-center justify-between text-xs text-gray-400 mb-2">
                                <span>{{ $movie->genre }}</span>
                                <span>{{ $movie->duration }}min</span>
                            </div>
                            <div class="text-center">
                                <span class="text-blue-500 font-medium text-sm">
                                    Starts {{ \Carbon\Carbon::parse($movie->showing_start)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-gray-800 rounded-lg p-8 mb-16">
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-4">Why Choose TJINEMA?</h2>
                <div class="grid md:grid-cols-3 gap-8 mt-8">
                    <div class="text-center">
                        <div class="text-4xl mb-4">🎬</div>
                        <h3 class="text-xl font-semibold mb-2">Latest Movies</h3>
                        <p class="text-gray-400">Watch the newest blockbusters and indie films</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-4">🎫</div>
                        <h3 class="text-xl font-semibold mb-2">Easy Booking</h3>
                        <p class="text-gray-400">Simple and quick online ticket booking</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-4">🍿</div>
                        <h3 class="text-xl font-semibold mb-2">Premium Experience</h3>
                        <p class="text-gray-400">Comfortable seats and quality snacks</p>
                    </div>
                </div>
            </div>
        </section>

        @auth
            @if($userStats)
                <section class="bg-gradient-to-r from-red-900 to-orange-900 rounded-lg p-8">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold mb-6">Your TJINEMA Journey</h2>
                        <div class="grid sm:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-red-300">{{ $userStats['movies_watched'] }}</div>
                                <div class="text-gray-300">Movies Watched</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-red-300">{{ $userStats['total_bookings'] }}</div>
                                <div class="text-gray-300">Total Bookings</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-red-300">{{ $userStats['watchlist_count'] }}</div>
                                <div class="text-gray-300">Watchlist Items</div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('activity.index') }}" class="bg-white text-red-900 font-bold py-2 px-6 rounded-lg hover:bg-gray-100 transition duration-200">
                                View Activity
                            </a>
                        </div>
                    </div>
                </section>
            @endif
        @endauth
    </div>
</div>

@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-watchlist').forEach(button => {
        button.addEventListener('click', function() {
            const movieId = this.dataset.movieId;

            fetch('/watchlist', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    movie_id: movieId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                    this.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                    this.classList.add('bg-red-600', 'hover:bg-red-700');
                } else {
                    alert(data.message || 'Failed to add to watchlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add to watchlist');
            });
        });
    });
});
</script>
@endauth
@endsection
