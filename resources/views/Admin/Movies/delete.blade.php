@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-gray-800 rounded-lg shadow-xl p-8">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-white mb-2">Delete Movie</h1>
                <p class="text-gray-300 mb-6">Are you sure you want to delete this movie? This action cannot be undone.</p>

                <div class="bg-gray-700 rounded-lg p-6 mb-6">
                    <div class="flex items-center space-x-4">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-16 h-24 object-cover rounded">
                        @else
                            <div class="w-16 h-24 bg-gray-600 rounded flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        <div class="text-left">
                            <h3 class="text-lg font-semibold text-white">{{ $movie->title }}</h3>
                            <p class="text-gray-300 text-sm">{{ $movie->genre }} • {{ $movie->rating }}</p>
                            <p class="text-gray-300 text-sm">{{ $movie->duration }} minutes</p>
                            <p class="text-gray-300 text-sm">IDR {{ number_format($movie->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('admin.movies.index') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-300">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300"
                                onclick="return confirm('Are you absolutely sure you want to delete this movie?')">
                            Delete Movie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
