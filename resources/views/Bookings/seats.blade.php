@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('bookings.theater', ['movie' => $movie->id, 'date' => $selectedDate->format('Y-m-d')]) }}"
                        class="text-gray-400 hover:text-white mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold">Select Your Seats</h1>
                </div>

                <div class="bg-gray-800 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $movie->poster_url ?? asset('storage/' . $movie->poster) }}"
                                alt="{{ $movie->title }}" class="w-12 h-18 object-cover rounded">
                            <div>
                                <h2 class="text-lg font-bold">{{ $movie->title }}</h2>
                                <p class="text-gray-400">{{ $theater->name }} • {{ $selectedDate->format('M j, Y') }} •
                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-yellow-500 font-bold text-lg">Rp
                                {{ number_format($theater->seat_price ?? 50000, 0, ',', '.') }}</p>
                            <p class="text-gray-400 text-sm">per seat</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="mb-8">
                    <div class="bg-gradient-to-b from-gray-600 to-gray-700 rounded-lg p-4 mb-6">
                        <div class="text-center text-white font-bold">SCREEN</div>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-center space-x-8 text-sm">
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-gray-600 rounded border border-gray-500"></div>
                                <span>Available</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-red-600 rounded"></div>
                                <span>Selected</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-gray-800 rounded border border-gray-700"></div>
                                <span>Occupied</span>
                            </div>
                        </div>
                    </div>

                    <div class="seat-map space-y-3">
                        @if (isset($seatLayout) && count($seatLayout) > 0)
                            @foreach ($seatLayout as $rowLetter => $row)
                                <div class="flex justify-center items-center space-x-2">
                                    <div class="w-8 text-center font-bold text-gray-400">{{ $rowLetter }}</div>
                                    <div class="flex space-x-2">
                                        @foreach ($row as $seat)
                                            <button
                                                class="seat w-8 h-8 rounded border-2 transition-all duration-200 {{ $seat->is_occupied ? 'bg-gray-800 border-gray-700 cursor-not-allowed' : 'bg-gray-600 border-gray-500 hover:bg-gray-500' }}"
                                                data-seat-id="{{ $seat->identifier }}" data-row="{{ $seat->row }}"
                                                data-number="{{ $seat->number }}"
                                                {{ $seat->is_occupied ? 'disabled' : '' }}>
                                                <span class="text-xs">{{ $seat->number }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-400">No seat layout available for this theater.</p>
                                <a href="{{ route('bookings.theater', ['movie' => $movie->id, 'date' => $selectedDate->format('Y-m-d')]) }}"
                                    class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                                    Choose Different Theater
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Booking Summary</h3>
                        <div id="selected-seats" class="text-gray-400">No seats selected</div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg">Total:</span>
                        <span id="total-price" class="text-2xl font-bold text-yellow-500">Rp 0</span>
                    </div>

                    <form id='booking-form' method="POST" action="{{ route('bookings.payment') }}">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        <input type="hidden" name="theater_id" value="{{ $theater->id }}">
                        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                        <input type="hidden" name="booking_date" value="{{ $selectedDate->format('Y-m-d') }}">
                        <input type="hidden" name="selected_seats" id="selected-seats-input" value="">
                        <button type="submit" id="continue-btn"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-bold transition-colors duration-200 disabled:bg-gray-700 disabled:cursor-not-allowed"
                            disabled>
                            Continue to Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let selectedSeats = [];
    const seatPrice = {{ $theater->seat_price ?? 50000 }};
    const seatsInput = document.getElementById('selected-seats-input');
    const continueBtn = document.getElementById('continue-btn');
    const selectedSeatsDiv = document.getElementById('selected-seats');
    const totalPriceDiv = document.getElementById('total-price');
    const bookingForm = document.getElementById('booking-form');

    gsap.from(".seat-map > div", {
        duration: 0.5, y: 20, opacity: 0, stagger: 0.05, ease: "power2.out"
    });

    document.querySelectorAll('.seat').forEach(button => {
        if (!button.disabled) {
            button.addEventListener('click', () => {
                const id = button.dataset.seatId;
                if (selectedSeats.includes(id)) {
                    selectedSeats = selectedSeats.filter(x => x !== id);
                    button.classList.replace('bg-red-600', 'bg-gray-600');
                    button.classList.replace('border-red-600', 'border-gray-500');
                } else {
                    selectedSeats.push(id);
                    button.classList.replace('bg-gray-600', 'bg-red-600');
                    button.classList.replace('border-gray-500', 'border-red-600');
                }
                updateBookingSummary();
            });
        }
    });

    function updateBookingSummary() {
        if (selectedSeats.length === 0) {
            selectedSeatsDiv.textContent = 'No seats selected';
            totalPriceDiv.textContent = 'Rp 0';
            continueBtn.disabled = true;
            seatsInput.value = '';
        } else {
            selectedSeatsDiv.textContent = selectedSeats.join(', ');
            totalPriceDiv.textContent = 'Rp ' + (selectedSeats.length * seatPrice).toLocaleString('id-ID');
            continueBtn.disabled = false;
            seatsInput.value = selectedSeats.join(',');
        }

        gsap.fromTo(totalPriceDiv,
            { scale: 1.2, color: '#fff' },
            { scale: 1, color: '#eab308', duration: 0.3, ease: "power2.out" }
        );
    }

    bookingForm.addEventListener('submit', e => {
        if (selectedSeats.length === 0) {
            e.preventDefault();
            alert('Please select at least one seat before continuing.');
        }
    });
});
</script>
@endsection
