<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\Beverage;
use App\Models\BookingBeverage;

class BookingController extends Controller
{
    public function selectDate(Movie $movie)
    {
        $availableDates = collect();
        for ($i = 0; $i < 7; $i++) {
            $availableDates->push(Carbon::now()->addDays($i));
        }
        return view('bookings.date', compact('movie', 'availableDates'));
    }

    public function selectTheater(Movie $movie, $date)
    {
        $selectedDate = Carbon::parse($date);

        if ($selectedDate->isPast()) {
            return redirect()->route('bookings.date', $movie)
                ->with('error', 'Selected date has passed.');
        }

        $theaters = Theater::whereHas('showtimes', function ($query) use ($movie, $selectedDate) {
            $query->where('movie_id', $movie->id)
                ->whereDate('start_time', $selectedDate->toDateString())
                ->where('start_time', '>', now());
        })->with(['showtimes' => function ($query) use ($movie, $selectedDate) {
            $query->where('movie_id', $movie->id)
                ->whereDate('start_time', $selectedDate->toDateString())
                ->where('start_time', '>', now())
                ->orderBy('start_time');
        }])->get();

        if ($theaters->isEmpty()) {
            return redirect()->route('bookings.date', $movie)
                ->with('error', 'No showtimes available for selected date.');
        }

        return view('bookings.theater', compact('movie', 'selectedDate', 'theaters'));
    }

    public function selectSeats(Request $request, Movie $movie)
    {
        $theaterId = $request->input('theater_id');
        $showtimeId = $request->input('showtime_id');
        $date = $request->input('date');

        if (!$theaterId || !$showtimeId || !$date) {
            return redirect()->route('bookings.date', $movie)
                ->with('error', 'Missing booking information.');
        }

        $selectedDate = Carbon::parse($date);
        $theater = Theater::findOrFail($theaterId);
        $showtime = Showtime::findOrFail($showtimeId);

        if ($selectedDate->isPast() || Carbon::parse($showtime->start_time)->isPast()) {
            return redirect()->route('bookings.date', $movie)
                ->with('error', 'Selected showtime has passed.');
        }

        if ($showtime->theater_id != $theater->id || $showtime->movie_id != $movie->id) {
            return redirect()->route('bookings.date', $movie)
                ->with('error', 'Invalid booking selection.');
        }

        $bookedSeats = $this->getBookedSeats($showtime->id, $selectedDate);
        $seatLayout = $this->createSeatLayout($theater, $bookedSeats);

        return view('bookings.seats', compact(
            'movie', 'theater', 'showtime', 'selectedDate', 'bookedSeats', 'seatLayout'
        ));
    }

    public function payment(Request $request)
    {
        $movieId = $request->input('movie_id');
        $theaterId = $request->input('theater_id');
        $showtimeId = $request->input('showtime_id');
        $bookingDate = $request->input('booking_date');
        $selectedSeatsInput = $request->input('selected_seats');

        // Validate selected seats input with debugging
        $selectedSeatsInput = $request->input('selected_seats');

        Log::info('Payment page - Selected seats input: ' . var_export($selectedSeatsInput, true));

        if (empty($selectedSeatsInput) || $selectedSeatsInput === null) {
            return redirect()->route('movies.index')
                ->with('error', 'Please select seats before proceeding.');
        }

        // Ensure it's a string before exploding
        $selectedSeatsInput = (string) $selectedSeatsInput;
        $selectedSeats = explode(',', $selectedSeatsInput);

        // Filter and clean the array
        $selectedSeats = array_filter($selectedSeats, function($seat) {
            return !empty(trim($seat));
        });
        $selectedSeats = array_map('trim', $selectedSeats);

        if (empty($selectedSeats) || !is_array($selectedSeats)) {
            Log::error('Payment page - Invalid seats after processing: ' . var_export($selectedSeats, true));
            return redirect()->route('movies.index')
                ->with('error', 'Invalid seat selection.');
        }

        if (!$movieId || !$theaterId || !$showtimeId || empty($selectedSeats) || !$bookingDate) {
            return redirect()->route('movies.index')
                ->with('error', 'Missing booking information.');
        }

        try {
            $movie = Movie::findOrFail($movieId);
            $theater = Theater::findOrFail($theaterId);
            $showtime = Showtime::findOrFail($showtimeId);
            $bookingDate = Carbon::parse($bookingDate);

            if ($showtime->theater_id != $theater->id || $showtime->movie_id != $movie->id) {
                return redirect()->route('movies.index')
                    ->with('error', 'Invalid booking selection.');
            }

            if (Carbon::parse($showtime->start_time)->isPast() || $bookingDate->isPast()) {
                return redirect()->route('movies.index')
                    ->with('error', 'Selected showtime is no longer available.');
            }

            $bookedSeats = $this->getBookedSeats($showtime->id, $bookingDate);
            $conflictingSeats = array_intersect($selectedSeats, $bookedSeats);

            if (!empty($conflictingSeats)) {
                return redirect()->route('movies.index')
                    ->with('error', 'Some seats are no longer available.');
            }

            $seatPrice = $theater->seat_price ?? 50000;
            $ticketPrice = count($selectedSeats) * $seatPrice;
            $beverages = Beverage::all();

            return view('bookings.payment', compact(
                'movie', 'theater', 'showtime', 'bookingDate',
                'selectedSeats', 'seatPrice', 'ticketPrice', 'beverages'
            ));

        } catch (\Exception $e) {
            Log::error('Payment page error: ' . $e->getMessage());
            return redirect()->route('movies.index')
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function processPayment(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Please login to complete booking.');
            }

            $requiredFields = ['movie_id', 'theater_id', 'showtime_id', 'selected_seats', 'booking_date', 'payment_method'];
            foreach ($requiredFields as $field) {
                if (!$request->has($field) || empty($request->input($field))) {
                    return redirect()->back()
                        ->with('error', 'Missing required information.')
                        ->withInput();
                }
            }

            // Validate and process selected seats with detailed debugging
            $selectedSeatsString = $request->input('selected_seats');

            // Debug logging
            Log::info('Selected seats input: ' . var_export($selectedSeatsString, true));

            if (empty($selectedSeatsString) || $selectedSeatsString === null) {
                return redirect()->back()
                    ->with('error', 'Please select at least one seat.')
                    ->withInput();
            }

            // Ensure it's a string before exploding
            $selectedSeatsString = (string) $selectedSeatsString;
            $selectedSeats = explode(',', $selectedSeatsString);

            // Filter out empty values and trim whitespace
            $selectedSeats = array_filter($selectedSeats, function($seat) {
                return !empty(trim($seat));
            });
            $selectedSeats = array_map('trim', $selectedSeats);

            // Final validation
            if (empty($selectedSeats) || !is_array($selectedSeats)) {
                Log::error('Invalid selected seats after processing: ' . var_export($selectedSeats, true));
                return redirect()->back()
                    ->with('error', 'Please select at least one seat.')
                    ->withInput();
            }

            $movie = Movie::findOrFail($request->movie_id);
            $theater = Theater::findOrFail($request->theater_id);
            $showtime = Showtime::findOrFail($request->showtime_id);
            $bookingDate = Carbon::parse($request->booking_date);

            $bookedSeats = $this->getBookedSeats($showtime->id, $bookingDate);
            $conflictingSeats = array_intersect($selectedSeats, $bookedSeats);

            if (!empty($conflictingSeats)) {
                return redirect()->back()
                    ->with('error', 'Some seats are no longer available.')
                    ->withInput();
            }

            $seatPrice = $theater->seat_price ?? 50000;
            $ticketPrice = count($selectedSeats) * $seatPrice;
            $beveragePrice = 0;

            DB::beginTransaction();

            // Store seats as comma-separated string with extra safety
            $seatsString = '';
            if (is_array($selectedSeats) && !empty($selectedSeats)) {
                $seatsString = implode(',', $selectedSeats);
            } else {
                Log::error('Cannot create seats string - selectedSeats is not a valid array: ' . var_export($selectedSeats, true));
                return redirect()->back()
                    ->with('error', 'Invalid seat selection. Please try again.')
                    ->withInput();
            }

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'movie_id' => $request->movie_id,
                'theater_id' => $request->theater_id,
                'showtime_id' => $request->showtime_id,
                'booking_date' => $request->booking_date,
                'seats' => $seatsString,
                'ticket_price' => $ticketPrice,
                'beverage_price' => 0,
                'total_amount' => $ticketPrice,
                'payment_method' => $request->payment_method
            ]);

            if ($request->has('beverages') && is_array($request->beverages)) {
                foreach ($request->beverages as $beverageId => $quantity) {
                    $quantity = intval($quantity);
                    if ($quantity > 0) {
                        $beverage = Beverage::find($beverageId);
                        if ($beverage) {
                            BookingBeverage::create([
                                'booking_id' => $booking->id,
                                'beverage_id' => $beverageId,
                                'quantity' => $quantity
                            ]);
                            $beveragePrice += $beverage->price * $quantity;
                        }
                    }
                }
            }

            $booking->update([
                'beverage_price' => $beveragePrice,
                'total_amount' => $ticketPrice + $beveragePrice
            ]);

            DB::commit();

            return redirect()->route('bookings.ticket', $booking->id)
                ->with('success', 'Booking confirmed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Payment failed. Please try again.')
                ->withInput();
        }
    }

    public function getTicket(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $booking->load(['movie', 'theater', 'showtime', 'beverages.beverage']);
        return view('bookings.ticket', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $showtime = Carbon::parse($booking->showtime->start_time);
        if ($showtime->diffInHours(now()) < 2) {
            return redirect()->back()
                ->with('error', 'Cannot cancel within 2 hours of showtime.');
        }

        $booking->delete();
        return redirect()->back()->with('success', 'Booking cancelled successfully.');
    }

    private function getBookedSeats($showtimeId, $date)
    {
        $bookings = Booking::where('showtime_id', $showtimeId)
            ->where('booking_date', $date->format('Y-m-d'))
            ->get();

        $bookedSeats = [];
        foreach ($bookings as $booking) {
            // Handle both string and array formats for seats
            if (!empty($booking->seats)) {
                if (is_string($booking->seats)) {
                    $seats = explode(',', $booking->seats);
                    $seats = array_filter($seats);
                    $seats = array_map('trim', $seats);
                    $bookedSeats = array_merge($bookedSeats, $seats);
                } elseif (is_array($booking->seats)) {
                    $bookedSeats = array_merge($bookedSeats, $booking->seats);
                }
            }
        }

        return array_unique(array_filter($bookedSeats));
    }

    private function createSeatLayout($theater, $bookedSeats)
    {
        $capacity = $theater->capacity ?? 50;
        $seatsPerRow = 10;
        $rows = min(ceil($capacity / $seatsPerRow), 10);
        $layout = [];
        $seatNumber = 1;

        for ($row = 0; $row < $rows; $row++) {
            $rowLetter = chr(65 + $row);
            $layout[$rowLetter] = [];

            for ($seat = 1; $seat <= $seatsPerRow && $seatNumber <= $capacity; $seat++) {
                $seatIdentifier = $rowLetter . $seat;
                $layout[$rowLetter][] = (object)[
                    'id' => $seatIdentifier,
                    'identifier' => $seatIdentifier,
                    'row' => $rowLetter,
                    'number' => $seat,
                    'is_occupied' => in_array($seatIdentifier, $bookedSeats),
                    'is_available' => !in_array($seatIdentifier, $bookedSeats)
                ];
                $seatNumber++;
            }
        }


        return $layout;
    }
    public function getFormattedSeats($seatsData)
{
    if (empty($seatsData)) {
        return [];
    }

    // If it's already an array, return it
    if (is_array($seatsData)) {
        return array_filter($seatsData);
    }

    // If it's a string, try to parse it
    if (is_string($seatsData)) {
        // First try JSON decode (in case it's stored as JSON)
        $jsonDecoded = json_decode($seatsData, true);
        if (is_array($jsonDecoded)) {
            return array_filter($jsonDecoded);
        }

        // If not JSON, try comma-separated string
        $exploded = explode(',', $seatsData);
        $cleaned = array_map('trim', $exploded);
        return array_filter($cleaned);
    }

    return [];
}

}
