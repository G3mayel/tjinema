@extends('layouts.app')

@section('title', 'Choose Date - ' . $movie->title)

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8 mb-8 border border-white/20">
                <div class="flex items-center space-x-8">
                    <div class="movie-poster">
                        <img src="{{ $movie->poster_url ?? '/images/default-poster.jpg' }}"
                             alt="{{ $movie->title }}"
                             class="w-28 h-40 object-cover rounded-xl shadow-lg">
                    </div>
                    <div class="movie-info">
                        <h1 class="text-4xl font-bold text-white mb-4">{{ $movie->title }}</h1>
                        <div class="flex items-center space-x-4 text-white/80">
                            <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm">{{ $movie->genre }}</span>
                            <span class="text-lg">{{ $movie->duration }} min</span>
                            <span class="bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold">{{ $movie->rating }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8 mb-8 border border-white/20">
                <div class="flex items-center justify-between step-container">
                    <div class="flex items-center space-x-3 bg-gradient-to-r from-purple-500/30 to-pink-500/30 backdrop-blur-sm text-white px-6 py-3 rounded-full border border-purple-400/50">
                        <span class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">1</span>
                        <span class="font-semibold">Choose Date</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white/50">
                        <span class="w-8 h-8 bg-white/20 text-white/70 rounded-full flex items-center justify-center text-sm border border-white/30">2</span>
                        <span>Choose Theater & Time</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white/50">
                        <span class="w-8 h-8 bg-white/20 text-white/70 rounded-full flex items-center justify-center text-sm border border-white/30">3</span>
                        <span>Choose Seats</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white/50">
                        <span class="w-8 h-8 bg-white/20 text-white/70 rounded-full flex items-center justify-center text-sm border border-white/30">4</span>
                        <span>Payment</span>
                    </div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-white/20">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">
                    <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        Select Show Date
                    </span>
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-6 date-grid">
                    @foreach($availableDates as $date)
                        <a href="{{ route('bookings.theater', ['movie' => $movie->id, 'date' => $date->format('Y-m-d')]) }}"
                           class="date-card block p-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl hover:bg-gradient-to-br hover:from-purple-500/20 hover:to-pink-500/20 hover:border-purple-400/50 transition-all duration-300 text-center group transform hover:scale-105 hover:shadow-xl">
                            <div class="text-sm font-medium text-white/70 group-hover:text-purple-300 mb-2">
                                {{ $date->format('D') }}
                            </div>
                            <div class="text-3xl font-bold text-white group-hover:text-white mb-1">
                                {{ $date->format('j') }}
                            </div>
                            <div class="text-sm text-white/60 group-hover:text-pink-300">
                                {{ $date->format('M') }}
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($availableDates->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-12 border border-white/10">
                            <div class="text-white/50 mb-6">
                                <svg class="w-20 h-20 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl text-white/80 mb-6 font-semibold">No show dates available for this movie.</p>
                            <a href="{{ route('movies.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 border border-transparent rounded-xl font-semibold text-white tracking-wide hover:from-purple-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Browse Other Movies
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="mt-8">
                <a href="{{ route('movies.show', $movie->id) }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors duration-300 group">
                    <svg class="w-6 h-6 mr-3 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="text-lg font-medium">Back to Movie Details</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.date-card {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

.date-card:nth-child(1) { animation-delay: 0.1s; }
.date-card:nth-child(2) { animation-delay: 0.2s; }
.date-card:nth-child(3) { animation-delay: 0.3s; }
.date-card:nth-child(4) { animation-delay: 0.4s; }
.date-card:nth-child(5) { animation-delay: 0.5s; }
.date-card:nth-child(6) { animation-delay: 0.6s; }
.date-card:nth-child(7) { animation-delay: 0.7s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.movie-poster {
    animation: scaleIn 0.8s ease-out;
}

.movie-info {
    animation: slideInRight 0.8s ease-out;
}

.step-container > div {
    animation: slideInDown 0.6s ease-out forwards;
    opacity: 0;
}

.step-container > div:nth-child(1) { animation-delay: 0.2s; }
.step-container > div:nth-child(2) { animation-delay: 0.3s; }
.step-container > div:nth-child(3) { animation-delay: 0.4s; }
.step-container > div:nth-child(4) { animation-delay: 0.5s; }

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
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
document.addEventListener('DOMContentLoaded', () => {
    gsap.timeline()
        .from(".movie-poster img", {
            duration: 0.8,
            scale: 0.8,
            opacity: 0,
            ease: "power2.out"
        })
        .from(".movie-info", {
            duration: 0.8,
            x: -50,
            opacity: 0,
            ease: "power2.out"
        }, "-=0.4")
        .from(".step-container > div", {
            duration: 0.6,
            y: -20,
            opacity: 0,
            stagger: 0.1,
            ease: "power2.out"
        }, "-=0.4")
        .from(".date-card", {
            duration: 0.8,
            y: 30,
            opacity: 0,
            stagger: 0.1,
            ease: "back.out(1.7)"
        }, "-=0.2");
    document.querySelectorAll('.date-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                duration: 0.3,
                scale: 1.05,
                y: -5,
                ease: "power2.out"
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                duration: 0.3,
                scale: 1,
                y: 0,
                ease: "power2.out"
            });
        });
    });
});
</script>
@endsection
