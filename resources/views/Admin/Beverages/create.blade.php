@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-gray-800 rounded-lg shadow-xl p-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-white">Add New Beverage</h1>
                <a href="{{ route('admin.beverages.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    Back to Beverages
                </a>
            </div>

            <form action="{{ route('admin.beverages.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Beverage Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500"
                           placeholder="e.g. Coca Cola, Popcorn, etc." required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (IDR)</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500"
                           placeholder="e.g. 25000" min="0" required>
                    @error('price')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.beverages.index') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-300">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300">
                        Add Beverage
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
