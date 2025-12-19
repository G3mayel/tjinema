@extends('layouts.app')

@section('title', 'Create Theater')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700">
                <h1 class="text-2xl font-bold text-white">Create New Theater</h1>
            </div>

            <form action="{{ route('admin.theaters.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Theater Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               required placeholder="e.g., Theater 1, IMAX, VIP">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-300 mb-2">Capacity</label>
                        <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               required min="1" max="500" placeholder="e.g., 100">
                        @error('capacity')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Theater Type</label>
                        <select id="type" name="type"
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                required>
                            <option value="">Select Type</option>
                            <option value="regular" {{ old('type') == 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="premium" {{ old('type') == 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="imax" {{ old('type') == 'imax' ? 'selected' : '' }}>IMAX</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rows" class="block text-sm font-medium text-gray-300 mb-2">Number of Rows</label>
                        <input type="number" id="rows" name="rows" value="{{ old('rows') }}"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               required min="1" max="26" placeholder="e.g., 10">
                        @error('rows')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="seats_per_row" class="block text-sm font-medium text-gray-300 mb-2">Seats per Row</label>
                        <input type="number" id="seats_per_row" name="seats_per_row" value="{{ old('seats_per_row') }}"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               required min="1" max="50" placeholder="e.g., 10">
                        @error('seats_per_row')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>



                <div class="flex justify-end space-x-4 mt-24">
                    <a href="{{ route('admin.theaters.index') }}"
                       class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                        Create Theater
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
