@extends('layouts.app')

@section('title', 'Manage Movies - TJINEMA')

@section('content')
    <div class="min-h-screen">

        <div class="relative z-10 container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-4 lg:mb-0">
                        <h1
                            class="text-4xl font-bold bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-3 leading-tight py-1">
                            Movie Library
                        </h1>
                        <p class="text-slate-300 text-lg">Curate your cinematic universe</p>
                    </div>
                    <a href="{{ route('admin.movies.create') }}"
                        class="group relative overflow-hidden bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div class="relative flex items-center space-x-3">
                            <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-plus text-sm"></i>
                            </div>
                            <span>Add New Movie</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-xl mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex flex-col sm:flex-row gap-4 flex-1">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fas fa-search text-slate-400 group-focus-within:text-purple-400 transition-colors"></i>
                            </div>
                            <input type="text" id="searchMovies" placeholder="Search movies by title..."
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300">
                        </div>

                        <div class="relative">
                            <select id="filterGenre"
                                class="appearance-none bg-white/5 border border-white/10 rounded-xl py-3 px-4 pr-10 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300">
                                <option value="">All Genres</option>
                                <option value="Action">Action</option>
                                <option value="Comedy">Comedy</option>
                                <option value="Drama">Drama</option>
                                <option value="Horror">Horror</option>
                                <option value="Romance">Romance</option>
                                <option value="Sci-Fi">Sci-Fi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-white/5 rounded-lg border border-white/10">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-slate-300 text-sm font-medium">{{ $movies->count() }} Movies</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movies Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @forelse($movies as $movie)
                    <div class="group movie-card relative">
                        <!-- Hover Glow Effect -->
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500 blur">
                        </div>

                        <div
                            class="relative bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform group-hover:scale-[1.02]">
                            <!-- Movie Poster -->
                            <div class="relative overflow-hidden">
                                @php
                                    // Debug: Let's see what poster fields are available
$posterUrl = null;
$debugInfo = [];

// Check common poster field names
if (isset($movie->poster_url) && !empty($movie->poster_url)) {
    $posterUrl = $movie->poster_url;
    $debugInfo[] = 'poster_url: ' . $movie->poster_url;
} elseif (isset($movie->poster) && !empty($movie->poster)) {
    $posterUrl = $movie->poster;
    $debugInfo[] = 'poster: ' . $movie->poster;
} elseif (isset($movie->image) && !empty($movie->image)) {
    $posterUrl = $movie->image;
    $debugInfo[] = 'image: ' . $movie->image;
} elseif (isset($movie->poster_path) && !empty($movie->poster_path)) {
    $posterUrl = $movie->poster_path;
    $debugInfo[] = 'poster_path: ' . $movie->poster_path;
}

// If we have a poster URL, make sure it's a full URL
                                    if ($posterUrl && !str_starts_with($posterUrl, 'http')) {
                                        // Remove any leading 'storage/' if it already exists to avoid duplication
                                        $cleanPath = ltrim($posterUrl, '/');
                                        if (str_starts_with($cleanPath, 'storage/')) {
                                            $cleanPath = substr($cleanPath, 8); // Remove 'storage/' prefix
                                        }
                                        $posterUrl = asset('storage/' . $cleanPath);
                                    }
                                @endphp

                                @if ($posterUrl)
                                    <img src="{{ $posterUrl }}" alt="{{ $movie->title }}"
                                        class="w-full h-80 object-cover transition-transform duration-700 group-hover:scale-110"
                                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-80 bg-gradient-to-br from-red-700 to-red-900 flex items-center justify-center\'><div class=\'text-center\'><i class=\'fas fa-exclamation-triangle text-6xl text-red-400 mb-4\'></i><p class=\'text-red-200 font-semibold text-sm px-4\'>Image failed to load<br>{{ $posterUrl }}</p></div></div>';">
                                @else
                                    <!-- Debug + Fallback poster design -->
                                    <div
                                        class="w-full h-80 bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                                        <div class="text-center px-4">
                                            <i class="fas fa-film text-6xl text-slate-500 mb-4"></i>
                                            <p class="text-slate-400 font-semibold mb-2">No Poster Found</p>
                                            @if (config('app.debug'))
                                                <div class="text-xs text-slate-500 max-w-xs">
                                                    <p class="mb-1">Available fields:</p>
                                                    @foreach (array_keys($movie->getAttributes()) as $field)
                                                        @if (str_contains($field, 'poster') || str_contains($field, 'image'))
                                                            <p>{{ $field }}: {{ $movie->$field ?? 'null' }}</p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Overlay Gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>

                                <!-- Status Badges -->
                                <div class="absolute top-4 left-4">
                                    @if ($movie->showing_start <= now() && $movie->showing_end >= now())
                                        <div
                                            class="flex items-center space-x-2 bg-green-500/90 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                            <span>NOW SHOWING</span>
                                        </div>
                                    @else
                                        <div
                                            class="flex items-center space-x-2 bg-red-500/90 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                            <span>NOT SHOWING</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Rating Badge -->
                                <div class="absolute top-4 right-4">
                                    <div
                                        class="flex items-center space-x-1 bg-yellow-400/90 backdrop-blur-sm text-black px-3 py-1 rounded-full font-bold text-sm">
                                        <i class="fas fa-star text-xs"></i>
                                        <span>{{ $movie->rating }}</span>
                                    </div>
                                </div>

                                <!-- Play Button Overlay -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div
                                        class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30">
                                        <i class="fas fa-play text-white text-xl ml-1"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Movie Info -->
                            <div class="p-6">
                                <h3
                                    class="text-white font-bold text-xl mb-2 line-clamp-1 group-hover:text-purple-300 transition-colors">
                                    {{ $movie->title }}</h3>
                                <p class="text-slate-300 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($movie->description, 80) }}</p>

                                <!-- Movie Details -->
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="text-slate-400">
                                            <i class="fas fa-calendar text-pink-400 mr-2"></i>
                                            @if ($movie->showing_start && $movie->showing_end)
                                                {{ \Carbon\Carbon::parse($movie->showing_start)->format('M d') }} -
                                                {{ \Carbon\Carbon::parse($movie->showing_end)->format('M d') }}
                                            @else
                                                Not scheduled
                                            @endif
                                        </div>

                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <div class="text-slate-400">
                                            <i class="fas fa-calendar text-pink-400 mr-2"></i>
                                            @if ($movie->showing_start && $movie->showing_end)
                                                {{ \Carbon\Carbon::parse($movie->showing_start)->format('M d') }} -
                                                {{ \Carbon\Carbon::parse($movie->showing_end)->format('M d') }}
                                            @else
                                                Not scheduled
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.movies.edit', $movie->id) }}"
                                        class="group/btn flex-1 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white py-3 px-4 rounded-xl font-semibold text-center transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-edit mr-2 group-hover/btn:rotate-12 transition-transform"></i>
                                        Edit
                                    </a>
                                    <button onclick="deleteMovie({{ $movie->id }}, '{{ $movie->title }}')"
                                        class="group/btn flex-1 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-trash mr-2 group-hover/btn:rotate-12 transition-transform"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-16 text-center">
                            <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-film text-4xl text-slate-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-4">No Movies Found</h3>
                            <p class="text-slate-400 text-lg mb-8">Start building your movie collection</p>
                            <a href="{{ route('admin.movies.create') }}"
                                class="inline-flex items-center space-x-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-plus"></i>
                                <span>Add Your First Movie</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                <div>
                    {{ $movies->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 max-w-md w-full shadow-2xl">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Delete Movie</h3>
                <p class="text-slate-300">Are you sure you want to delete "<span id="movieTitle"
                        class="font-semibold text-white"></span>"?</p>
                <p class="text-slate-400 text-sm mt-2">This action cannot be undone.</p>
            </div>

            <div class="flex space-x-4">
                <button onclick="closeDeleteModal()"
                    class="flex-1 bg-white/10 hover:bg-white/20 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 border border-white/20">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Delete Movie
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

@section('scripts')
    <script>
        let deleteMovieId = null;

        function deleteMovie(id, title) {
            deleteMovieId = id;
            document.getElementById('movieTitle').textContent = title;
            document.getElementById('deleteForm').action = `/admin/movies/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            deleteMovieId = null;
        }

        // Search functionality
        document.getElementById('searchMovies').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const movieCards = document.querySelectorAll('.movie-card');

            movieCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Genre filter functionality
        document.getElementById('filterGenre').addEventListener('change', function() {
            const selectedGenre = this.value;
            const movieCards = document.querySelectorAll('.movie-card');

            movieCards.forEach(card => {
                const genreElement = card.querySelector('.fa-theater-masks').parentElement.querySelector(
                    'span');
                const genre = genreElement.textContent.trim();

                if (selectedGenre === '' || genre === selectedGenre) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                closeDeleteModal();
            }
        });

        // Close modal on backdrop click
        document.getElementById('deleteModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
