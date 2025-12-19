@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-gray-800 rounded-lg shadow-xl p-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-white">Edit Movie</h1>
                <a href="{{ route('admin.movies.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    Back to Movies
                </a>
            </div>

            <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Movie Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $movie->title) }}"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        @error('title')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-300 mb-2">Genre</label>
                        <input type="text" id="genre" name="genre" value="{{ old('genre', $movie->genre) }}"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        @error('genre')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>{{ old('description', $movie->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                        <select id="rating" name="rating" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                            <option value="G" {{ old('rating', $movie->rating) == 'G' ? 'selected' : '' }}>G</option>
                            <option value="PG" {{ old('rating', $movie->rating) == 'PG' ? 'selected' : '' }}>PG</option>
                            <option value="13+" {{ old('rating', $movie->rating) == '13+' ? 'selected' : '' }}>13+</option>
                            <option value="17+" {{ old('rating', $movie->rating) == '17+' ? 'selected' : '' }}>17+</option>
                            <option value="21+" {{ old('rating', $movie->rating) == '21+' ? 'selected' : '' }}>21+</option>
                        </select>
                        @error('rating')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-300 mb-2">Duration (minutes)</label>
                        <input type="number" id="duration" name="duration" value="{{ old('duration', $movie->duration) }}"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        @error('duration')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (IDR)</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $movie->price) }}"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        @error('price')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="showing_start" class="block text-sm font-medium text-gray-300 mb-2">Showing Start</label>
                        <input type="date" id="showing_start" name="showing_start" value="{{ old('showing_start', $movie->showing_start) }}"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        @error('showing_start')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="showing_end" class="block text-sm font-medium text-gray-300 mb-2">Showing End</label>
                        <input type="date" id="showing_end" name="showing_end" value="{{ old('showing_end', $movie->showing_end) }}"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        @error('showing_end')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="poster" class="block text-sm font-medium text-gray-300 mb-2">Movie Poster</label>
                    @if($movie->poster)
                        <div class="mb-4">
                            <p class="text-gray-400 text-sm mb-2">Current poster:</p>
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-32 h-48 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" id="poster" name="poster" accept="image/*"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    <p class="text-gray-400 text-sm mt-1">Leave empty to keep current poster</p>
                    @error('poster')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.movies.index') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-300">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300">
                        Update Movie
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
