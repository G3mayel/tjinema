@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 bg-gray-900">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 payment-header">
            <h1 class="text-4xl font-bold text-white mb-2">Complete Your Payment</h1>
            <p class="text-gray-400 text-lg">Secure checkout for your movie experience</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-5">
                <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden booking-summary">
                    <div class="p-6 border-b border-gray-700">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2H2V6zM2 10v6a2 2 0 002 2h12a2 2 0 002-2v-6H2z"/>
                            </svg>
                            Booking Summary
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400 font-medium">Movie</span>
                                <span class="text-white font-semibold">{{ $movie->title }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400 font-medium">Theater</span>
                                <span class="text-white font-semibold">{{ $theater->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400 font-medium">Date</span>
                                <span class="text-white font-semibold">{{ $bookingDate->format('l, d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400 font-medium">Time</span>
                                <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-700 pt-4 space-y-4">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400 font-medium">Selected Seats</span>
                                <span class="text-white font-semibold bg-gray-700 px-3 py-1 rounded-lg text-sm">{{ implode(', ', $selectedSeats) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400 font-medium">Number of Seats</span>
                                <span class="text-white font-semibold">{{ count($selectedSeats) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400 font-medium">Seat Price</span>
                                <span class="text-white font-semibold">Rp {{ number_format($seatPrice, 0, ',', '.') }} each</span>
                            </div>
                            <div class="flex justify-between items-center py-3 bg-blue-900/30 rounded-lg px-4 border border-blue-800/50">
                                <span class="text-blue-300 font-semibold">Subtotal</span>
                                <span class="text-blue-300 font-bold text-lg">Rp {{ number_format($ticketPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <form id="payment-form" method="POST" action="{{ route('bookings.process-payment') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                    <input type="hidden" name="theater_id" value="{{ $theater->id }}">
                    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                    <input type="hidden" name="booking_date" value="{{ $bookingDate->format('Y-m-d') }}">
                    <input type="hidden" name="selected_seats" value="{{ implode(',', $selectedSeats) }}">

                    @if(isset($beverages) && $beverages->count() > 0)
                    <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden beverages-section">
                        <div class="p-6 border-b border-gray-700">
                            <h3 class="text-xl font-semibold text-white flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                    </svg>
                                    Add Beverages
                                </div>
                                <span class="bg-amber-900/40 text-amber-300 text-xs font-medium px-2.5 py-0.5 rounded-full border border-amber-800/50">Optional</span>
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4" id="beverages-list">
                                @foreach($beverages as $beverage)
                                <div class="flex items-center justify-between p-4 border border-gray-600 rounded-xl hover:border-gray-500 hover:bg-gray-700/50 transition-all duration-200 beverage-item">
                                    <div>
                                        <h4 class="font-semibold text-white">{{ $beverage->name }}</h4>
                                        <p class="text-gray-400">Rp {{ number_format($beverage->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <button type="button" class="w-8 h-8 rounded-full bg-gray-700 hover:bg-gray-600 flex items-center justify-center transition-colors qty-btn minus-btn" data-target="beverage-{{ $beverage->id }}">
                                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" class="w-16 h-8 text-center border border-gray-600 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 beverage-quantity" id="beverage-{{ $beverage->id }}" data-beverage-id="{{ $beverage->id }}" data-price="{{ $beverage->price }}" min="0" max="10" value="0">
                                        <button type="button" class="w-8 h-8 rounded-full bg-gray-700 hover:bg-gray-600 flex items-center justify-center transition-colors qty-btn plus-btn" data-target="beverage-{{ $beverage->id }}">
                                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden payment-methods">
                        <div class="p-6 border-b border-gray-700">
                            <h3 class="text-xl font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                                </svg>
                                Payment Method
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="payment-method">
                                    <input class="sr-only" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                    <label class="flex items-center p-4 border-2 border-blue-500 bg-blue-900/20 rounded-xl cursor-pointer transition-all duration-200 hover:border-blue-400" for="credit_card">
                                        <div class="flex items-center justify-center w-10 h-10 bg-blue-900/50 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-semibold text-white">Credit Card</span>
                                        </div>
                                        <div class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </label>
                                </div>

                                <div class="payment-method">
                                    <input class="sr-only" type="radio" name="payment_method" id="debit_card" value="debit_card">
                                    <label class="flex items-center p-4 border-2 border-gray-600 rounded-xl cursor-pointer transition-all duration-200 hover:border-gray-500 hover:bg-gray-700/30 payment-option" for="debit_card">
                                        <div class="flex items-center justify-center w-10 h-10 bg-gray-700 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v2H4V6zm0 4h12v4H4v-4z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-semibold text-white">Debit Card</span>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-500 rounded-full payment-check"></div>
                                    </label>
                                </div>

                                <div class="payment-method">
                                    <input class="sr-only" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <label class="flex items-center p-4 border-2 border-gray-600 rounded-xl cursor-pointer transition-all duration-200 hover:border-gray-500 hover:bg-gray-700/30 payment-option" for="bank_transfer">
                                        <div class="flex items-center justify-center w-10 h-10 bg-gray-700 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v2H4V6zm0 4h12v4H4v-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-semibold text-white">Bank Transfer</span>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-500 rounded-full payment-check"></div>
                                    </label>
                                </div>

                                <div class="payment-method">
                                    <input class="sr-only" type="radio" name="payment_method" id="e_wallet" value="e_wallet">
                                    <label class="flex items-center p-4 border-2 border-gray-600 rounded-xl cursor-pointer transition-all duration-200 hover:border-gray-500 hover:bg-gray-700/30 payment-option" for="e_wallet">
                                        <div class="flex items-center justify-center w-10 h-10 bg-gray-700 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-semibold text-white">E-Wallet</span>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-500 rounded-full payment-check"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-6 text-white total-section">
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-semibold">Total Amount</span>
                            <span class="text-3xl font-bold" id="display-total">Rp {{ number_format($ticketPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('bookings.seats', ['movie' => $movie->id, 'theater_id' => $theater->id, 'showtime_id' => $showtime->id, 'date' => $bookingDate->format('Y-m-d')]) }}" class="flex items-center justify-center px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-200 font-semibold rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to Seats
                        </a>
                        <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 submit-btn">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Complete Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    gsap.from('.payment-header', {
        duration: 0.8,
        y: -30,
        opacity: 0,
        ease: 'power2.out'
    });

    gsap.from('.booking-summary', {
        duration: 0.8,
        x: -30,
        opacity: 0,
        ease: 'power2.out',
        delay: 0.2
    });

    gsap.from('.beverages-section, .payment-methods, .total-section', {
        duration: 0.8,
        x: 30,
        opacity: 0,
        ease: 'power2.out',
        delay: 0.4,
        stagger: 0.1
    });

    gsap.from('.beverage-item', {
        duration: 0.6,
        y: 20,
        opacity: 0,
        ease: 'power2.out',
        delay: 0.6,
        stagger: 0.1
    });

    const beverageInputs = document.querySelectorAll('.beverage-quantity');
    const displayTotal = document.getElementById('display-total');
    const form = document.getElementById('payment-form');
    const qtyBtns = document.querySelectorAll('.qty-btn');
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');

    let baseTotal = {{ $ticketPrice }};

    qtyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const isPlus = this.classList.contains('plus-btn');
            const currentValue = parseInt(input.value) || 0;

            if (isPlus && currentValue < 10) {
                input.value = currentValue + 1;
                gsap.to(this, { scale: 1.2, duration: 0.1, yoyo: true, repeat: 1 });
            } else if (!isPlus && currentValue > 0) {
                input.value = currentValue - 1;
                gsap.to(this, { scale: 1.2, duration: 0.1, yoyo: true, repeat: 1 });
            }

            updateTotal();
        });
    });

    beverageInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            paymentOptions.forEach(option => {
                const label = option.querySelector('label') || option;
                const check = label.querySelector('.payment-check');
                const icon = label.querySelector('.bg-gray-700');

                if (option.querySelector('input').checked) {
                    label.classList.remove('border-gray-600', 'hover:border-gray-500');
                    label.classList.add('border-blue-500', 'bg-blue-900/20');
                    if (icon) {
                        icon.classList.remove('bg-gray-700');
                        icon.classList.add('bg-blue-900/50');
                    }
                    check.classList.remove('border-gray-500');
                    check.classList.add('bg-blue-500', 'border-blue-500');
                    check.innerHTML = '<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                } else {
                    label.classList.add('border-gray-600', 'hover:border-gray-500');
                    label.classList.remove('border-blue-500', 'bg-blue-900/20');
                    if (icon) {
                        icon.classList.add('bg-gray-700');
                        icon.classList.remove('bg-blue-900/50');
                    }
                    check.classList.add('border-gray-500');
                    check.classList.remove('bg-blue-500', 'border-blue-500');
                    check.innerHTML = '';
                }
            });
        });
    });

    function updateTotal() {
        let beverageTotal = 0;

        beverageInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price) || 0;
            beverageTotal += quantity * price;
        });

        const finalTotal = baseTotal + beverageTotal;

        gsap.to(displayTotal, {
            duration: 0.3,
            scale: 1.1,
            ease: 'power2.out',
            onComplete: () => {
                displayTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalTotal);
                gsap.to(displayTotal, { duration: 0.3, scale: 1, ease: 'power2.out' });
            }
        });
    }

    form.addEventListener('submit', function(e) {
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedPaymentMethod) {
            e.preventDefault();
            alert('Please select a payment method.');
            return false;
        }

        beverageInputs.forEach(input => {
            if (parseInt(input.value) > 0) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `beverages[${input.dataset.beverageId}]`;
                hiddenInput.value = input.value;
                form.appendChild(hiddenInput);
            }
        });

        const submitBtn = this.querySelector('.submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path></svg>Processing Payment...';

        gsap.to(submitBtn, { scale: 0.95, duration: 0.1 });
    });
});
</script>
@endsection
