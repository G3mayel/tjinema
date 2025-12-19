<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $booking->booking_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-red-600">TJINEMA</h1>
                <p class="text-gray-600">Booking Receipt</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Booking Details</h3>
                    <p><strong>Booking #:</strong> {{ $booking->booking_number }}</p>
                    <p><strong>Date:</strong> {{ $booking->created_at->format('d M Y, H:i') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Customer</h3>
                    <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">Show Details</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <img src="{{ Storage::url($booking->movie->poster) }}" alt="{{ $booking->movie->title }}" class="w-16 h-20 object-cover rounded">
                        <div>
                            <h4 class="font-semibold">{{ $booking->movie->title }}</h4>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($booking->show_date)->format('d M Y') }} at {{ \Carbon\Carbon::parse($booking->showtime)->format('H:i') }}</p>
                            <p class="text-gray-600">{{ $booking->theater->name }}</p>
                            <p class="text-gray-600">Seats: {{ implode(', ', json_decode($booking->seats ?? '[]')) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($booking->beverages && count(json_decode($booking->beverages, true)) > 0)
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Food & Beverages</h3>
                    @php
                        $beverageData = json_decode($booking->beverages, true);
                        $beverageTotal = 0;
                    @endphp
                    <div class="space-y-2">
                        @foreach($beverageData as $beverageId => $qty)
                            @php
                                $beverage = \App\Models\Beverage::find($beverageId);
                                if($beverage) {
                                    $subtotal = $beverage->price * $qty;
                                    $beverageTotal += $subtotal;
                                }
                            @endphp
                            @if($beverage)
                                <div class="flex justify-between">
                                    <span>{{ $beverage->name }} ({{ $qty }}x)</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold">Total Amount:</span>
                    <span class="text-xl font-bold text-red-600">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="text-center mt-8 text-gray-500 text-sm">
                <p>Thank you for choosing TJINEMA!</p>
                <p>Enjoy your movie experience</p>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
