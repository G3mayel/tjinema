@extends('layouts.app')

@section('title', 'Edit Beverage')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700">
                <h1 class="text-2xl font-bold text-white">Edit Beverage</h1>
            </div>

            <form action="{{ route('admin.beverages.update', $beverage->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $beverage->name) }}"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (IDR)</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $beverage->price) }}"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               required min="0" step="1000">
                        @error('price')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.beverages.index') }}"
                       class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                        Update Beverage
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
