@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header section -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('bookings.date', $movie) }}"
                   class="text-white/80 hover:text-white mr-6 transition-colors duration-300 group">
                    <svg class="w-8 h-8 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-4xl font-bold text-white">
                    <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        Select Theater & Time
                    </span>
                </h1>
            </div>
        </div>

        <!-- Movie info (without theater-specific info) -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
            <div class="flex items-center space-x-6">
                <img src="{{ $movie->poster_url ?? asset('storage/' . $movie->poster) }}"
                     alt="{{ $movie->title }}" class="w-16 h-24 object-cover rounded-lg shadow-lg">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $movie->title }}</h2>
                    <div class="flex items-center space-x-4 text-white/80">
                        <span>{{ $selectedDate->format('M j, Y') }}</span>
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">
                            {{ $movie->duration ?? 'N/A' }} min
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theater listings -->
        <div class="space-y-6">
            @forelse($theaters as $theater)
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-xl">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $theater->name }}</h3>
                        <p class="text-white/60 text-sm mb-4">{{ $theater->location ?? 'Location not specified' }}</p>
                        <p class="text-lg font-semibold text-green-400">
                            Rp {{ number_format($theater->seat_price ?? 50000, 0, ',', '.') }} per seat
                        </p>
                    </div>

                    <!-- Showtimes for this theater -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach($theater->showtimes as $showtime)
                            <form method="GET" action="{{ route('bookings.seats', $movie) }}">
                                <input type="hidden" name="theater_id" value="{{ $theater->id }}">
                                <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                                <input type="hidden" name="date" value="{{ $selectedDate->format('Y-m-d') }}">
                                <button type="submit"
                                        class="w-full bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/30 hover:border-white/50 text-white px-4 py-3 rounded-lg transition-all duration-300 transform hover:scale-105">
                                    <div class="text-lg font-bold">
                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                    </div>
                                    <div class="text-xs text-white/70">
                                        {{ \Carbon\Carbon::parse($showtime->end_time)->format('H:i') }}
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20">
                        <p class="text-xl text-white/80 mb-6">No theaters available for this date.</p>
                        <a href="{{ route('bookings.date', $movie) }}"
                           class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                            Choose Different Date
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
