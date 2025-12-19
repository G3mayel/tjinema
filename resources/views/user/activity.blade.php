@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <!-- Header with Glassmorphism -->
        <div class="text-center mb-12">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-xl">
                <h1 class="text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        My Activity
                    </span>
                </h1>
                <p class="text-xl text-white/80">Track your booking history and manage your tickets</p>
            </div>
        </div>

        <!-- Main Content Container -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl overflow-hidden border border-white/20 shadow-xl">
            <!-- Filter and Sort Controls -->
            <div class="p-6 border-b border-white/20">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap gap-3">
                        <button class="filter-btn active bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 px-6 py-2 rounded-full font-semibold transition-all duration-300 hover:scale-105 text-white shadow-lg" data-filter="all">
                            All
                        </button>
                        <button class="filter-btn bg-white/20 backdrop-blur-sm hover:bg-white/30 px-6 py-2 rounded-full font-semibold transition-all duration-300 hover:scale-105 text-white border border-white/30" data-filter="completed">
                            Completed
                        </button>
                        <button class="filter-btn bg-white/20 backdrop-blur-sm hover:bg-white/30 px-6 py-2 rounded-full font-semibold transition-all duration-300 hover:scale-105 text-white border border-white/30" data-filter="upcoming">
                            Upcoming
                        </button>
                        <button class="filter-btn bg-white/20 backdrop-blur-sm hover:bg-white/30 px-6 py-2 rounded-full font-semibold transition-all duration-300 hover:scale-105 text-white border border-white/30" data-filter="cancelled">
                            Cancelled
                        </button>
                    </div>

                    <div class="flex space-x-3">
                        <select id="sort-by" class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-full px-4 py-2 text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="date_desc" class="bg-gray-800">Latest First</option>
                            <option value="date_asc" class="bg-gray-800">Oldest First</option>
                            <option value="amount_desc" class="bg-gray-800">Highest Amount</option>
                            <option value="amount_asc" class="bg-gray-800">Lowest Amount</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($bookings->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">🎫</div>
                    <h3 class="text-2xl font-bold text-white mb-4">No bookings yet</h3>
                    <p class="text-white/60 text-lg mb-8">Start booking your first movie to see your activity here</p>
                    <a href="{{ route('movies.index') }}" class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 hover:scale-105 shadow-lg">
                        Browse Movies
                    </a>
                </div>
            @else
                <!-- Bookings List -->
                <div class="divide-y divide-white/10" id="bookings-container">
                    @foreach($bookings as $booking)
                        <div class="p-6 booking-item hover:bg-white/5 transition-all duration-300" data-status="{{ $booking->status }}" data-date="{{ $booking->show_date }}" data-amount="{{ $booking->total_amount }}">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                                <div class="flex items-start space-x-4">
                                    <!-- Movie Poster -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ Storage::url($booking->movie->poster) }}" alt="{{ $booking->movie->title }}" class="w-20 h-28 object-cover rounded-xl shadow-lg">
                                    </div>

                                    <!-- Booking Details -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-3">
                                            <h3 class="text-xl font-bold text-white">{{ $booking->movie->title }}</h3>
                                            <span class="px-3 py-1 text-sm rounded-full font-semibold
                                                @if($booking->status === 'completed') bg-green-500/20 text-green-300 border border-green-500/30
                                                @elseif($booking->status === 'upcoming') bg-blue-500/20 text-blue-300 border border-blue-500/30
                                                @elseif($booking->status === 'cancelled') bg-red-500/20 text-red-300 border border-red-500/30
                                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>

                                        <!-- Booking Info Grid -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                                <span class="font-semibold text-white/70 block mb-1">Date</span>
                                                <div class="text-white font-medium">{{ \Carbon\Carbon::parse($booking->show_date)->format('d M Y') }}</div>
                                            </div>
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                                <span class="font-semibold text-white/70 block mb-1">Time</span>
                                                <div class="text-white font-medium">{{ \Carbon\Carbon::parse($booking->showtime)->format('H:i') }}</div>
                                            </div>
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                                <span class="font-semibold text-white/70 block mb-1">Theater</span>
                                                <div class="text-white font-medium">{{ $booking->theater->name }}</div>
                                            </div>
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                                <span class="font-semibold text-white/70 block mb-1">Seats</span>
                                                <div class="text-white font-medium">
                                                    @php
                                                        $seats = $booking->seats;
                                                        if (is_string($seats)) {
                                                            $seatsArray = json_decode($seats, true) ?? [];
                                                        } elseif (is_array($seats)) {
                                                            $seatsArray = $seats;
                                                        } else {
                                                            $seatsArray = [];
                                                        }
                                                    @endphp
                                                    {{ !empty($seatsArray) ? implode(', ', $seatsArray) : 'No seats selected' }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Food & Beverages -->
                                        @php
                                            $beverages = $booking->beverages;
                                            $hasBeverages = false;

                                            if (is_string($beverages)) {
                                                $beverageData = json_decode($beverages, true) ?? [];
                                            } elseif (is_array($beverages)) {
                                                $beverageData = $beverages;
                                            } else {
                                                $beverageData = [];
                                            }

                                            $hasBeverages = !empty($beverageData);
                                        @endphp

                                        @if($hasBeverages)
                                            <div class="mt-4 bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                                                <span class="font-semibold text-white/70 block mb-2">Food & Beverages</span>
                                                <div class="text-white">
                                                    @php
                                                        $beverageItems = [];
                                                        foreach($beverageData as $beverageId => $qty) {
                                                            $beverage = \App\Models\Beverage::find($beverageId);
                                                            if($beverage) {
                                                                $beverageItems[] = $beverage->name . ' (' . $qty . 'x)';
                                                            }
                                                        }
                                                    @endphp
                                                    {{ !empty($beverageItems) ? implode(', ', $beverageItems) : 'No beverages' }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Price and Actions -->
                                <div class="flex flex-col lg:items-end space-y-4">
                                    <!-- Price Info -->
                                    <div class="text-right bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                        <div class="text-2xl font-bold text-green-400 mb-1">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </div>
                                        <div class="text-sm text-white/70 mb-1">Booking #{{ $booking->booking_number }}</div>
                                        <div class="text-sm text-white/70">{{ $booking->created_at->format('d M Y, H:i') }}</div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-wrap gap-2 justify-end">
                                        @if($booking->status === 'completed' || $booking->status === 'upcoming')
                                            <button class="view-ticket bg-blue-500/80 backdrop-blur-sm hover:bg-blue-600/90 text-white px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:scale-105 border border-blue-500/30" data-booking-id="{{ $booking->id }}">
                                                View Ticket
                                            </button>
                                        @endif

                                        @if($booking->status === 'upcoming' && \Carbon\Carbon::parse($booking->show_date . ' ' . $booking->showtime)->gt(now()->addHours(2)))
                                            <button class="cancel-booking bg-red-500/80 backdrop-blur-sm hover:bg-red-600/90 text-white px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:scale-105 border border-red-500/30" data-booking-id="{{ $booking->id }}">
                                                Cancel
                                            </button>
                                        @endif

                                        <button class="download-receipt bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:scale-105 border border-white/30" data-booking-id="{{ $booking->id }}">
                                            Receipt
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
                    <div class="p-6 border-t border-white/20">
                        {{ $bookings->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Ticket Modal -->
<div id="ticket-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center z-50">
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 max-w-md w-full mx-4 border border-white/20 shadow-2xl">
        <div class="text-center">
            <h3 class="text-2xl font-bold text-white mb-6">Your Ticket</h3>
            <div id="ticket-content" class="mb-6"></div>
            <div class="flex justify-center space-x-3">
                <button type="button" id="close-ticket-modal" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:scale-105 border border-white/30">
                    Close
                </button>
                <button type="button" id="download-ticket" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                    Download
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const bookingItems = document.querySelectorAll('.booking-item');
    const sortSelect = document.getElementById('sort-by');
    const bookingsContainer = document.getElementById('bookings-container');

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-gradient-to-r', 'from-purple-500', 'to-pink-500');
                btn.classList.add('bg-white/20', 'backdrop-blur-sm', 'border', 'border-white/30');
            });

            this.classList.add('active', 'bg-gradient-to-r', 'from-purple-500', 'to-pink-500');
            this.classList.remove('bg-white/20', 'backdrop-blur-sm', 'border', 'border-white/30');

            const filter = this.dataset.filter;

            bookingItems.forEach(item => {
                if (filter === 'all' || item.dataset.status === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Sort functionality
    sortSelect.addEventListener('change', function() {
        const sortBy = this.value;
        const items = Array.from(bookingItems);

        items.sort((a, b) => {
            if (sortBy === 'date_desc') {
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            } else if (sortBy === 'date_asc') {
                return new Date(a.dataset.date) - new Date(b.dataset.date);
            } else if (sortBy === 'amount_desc') {
                return parseInt(b.dataset.amount) - parseInt(a.dataset.amount);
            } else if (sortBy === 'amount_asc') {
                return parseInt(a.dataset.amount) - parseInt(b.dataset.amount);
            }
        });

        items.forEach(item => {
            bookingsContainer.appendChild(item);
        });
    });

    // View ticket functionality
    document.querySelectorAll('.view-ticket').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;

            fetch(`/bookings/${bookingId}/ticket`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('ticket-content').innerHTML = data.html;
                    document.getElementById('ticket-modal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load ticket');
                });
        });
    });

    // Cancel booking functionality
    document.querySelectorAll('.cancel-booking').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;

            if (confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
                fetch(`/bookings/${bookingId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to cancel booking');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to cancel booking');
                });
            }
        });
    });

    // Download receipt functionality
    document.querySelectorAll('.download-receipt').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            window.open(`/bookings/${bookingId}/receipt`, '_blank');
        });
    });

    // Close ticket modal
    document.getElementById('close-ticket-modal').addEventListener('click', function() {
        document.getElementById('ticket-modal').classList.add('hidden');
    });

    // Download ticket functionality
    document.getElementById('download-ticket').addEventListener('click', function() {
        const ticketContent = document.getElementById('ticket-content').innerHTML;
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Movie Ticket</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .ticket { border: 2px dashed #333; padding: 20px; margin: 20px 0; }
                        .text-center { text-align: center; }
                        .font-bold { font-weight: bold; }
                        .text-2xl { font-size: 1.5rem; }
                        .text-lg { font-size: 1.125rem; }
                        .mb-4 { margin-bottom: 1rem; }
                        .mb-2 { margin-bottom: 0.5rem; }
                        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
                        .border { border: 1px solid #ddd; padding: 10px; }
                    </style>
                </head>
                <body>
                    ${ticketContent}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });

    // Close modal when clicking outside
    document.getElementById('ticket-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
});
</script>
@endsection
