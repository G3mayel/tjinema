<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Showtime;
use App\Models\Theater;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BookingService
{
    /**
     * Create a new booking
     */
    public function createBooking(array $bookingData)
    {
        try {
            DB::beginTransaction();

            // Validate showtime exists and is active
            $showtime = Showtime::with(['movie', 'theater'])
                ->findOrFail($bookingData['showtime_id']);

            // Check if seats are available
            $requestedSeats = $bookingData['seats'];
            $unavailableSeats = $this->getUnavailableSeats($showtime->theater, $showtime->id, $requestedSeats);

            if (!empty($unavailableSeats)) {
                throw new Exception('Some seats are no longer available: ' . implode(', ', $unavailableSeats));
            }

            // Calculate prices
            $ticketPrice = $this->calculateTicketPrice($showtime, count($requestedSeats));
            $beveragePrice = $bookingData['beverage_price'] ?? 0;
            $totalAmount = $ticketPrice + $beveragePrice;

            // Create booking
            $booking = Booking::create([
                'user_id' => $bookingData['user_id'],
                'movie_id' => $showtime->movie_id,
                'theater_id' => $showtime->theater_id,
                'showtime_id' => $bookingData['showtime_id'],
                'seats' => $requestedSeats,
                'ticket_price' => $ticketPrice,
                'beverage_price' => $beveragePrice,
                'total_amount' => $totalAmount,
            ]);

            DB::commit();

            return [
                'success' => true,
                'booking' => $booking->load(['showtime.movie', 'showtime.theater', 'user', 'movie', 'theater']),
                'message' => 'Booking created successfully'
            ];

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Booking creation failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Update booking (since there's no status field, we'll focus on updating beverage price)
     */
    public function updateBooking($bookingId, array $updateData)
    {
        try {
            $booking = Booking::findOrFail($bookingId);

            // Check if showtime hasn't started yet
            if (!$booking->showtime->start_time->isFuture()) {
                throw new Exception('Cannot update booking for past showtimes');
            }

            // Update beverage price if provided
            if (isset($updateData['beverage_price'])) {
                $booking->beverage_price = $updateData['beverage_price'];
                $booking->total_amount = $booking->ticket_price + $booking->beverage_price;
            }

            $booking->save();

            return [
                'success' => true,
                'booking' => $booking,
                'message' => 'Booking updated successfully'
            ];

        } catch (Exception $e) {
            Log::error('Booking update failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Cancel a booking (delete it since there's no status field)
     */
    public function cancelBooking($bookingId, $reason = null)
    {
        try {
            $booking = Booking::findOrFail($bookingId);

            // Check if showtime hasn't started yet
            if (!$booking->showtime->start_time->isFuture()) {
                throw new Exception('Cannot cancel booking for past showtimes');
            }

            // Store booking data for return
            $bookingData = $booking->toArray();

            // Delete the booking
            $booking->delete();

            return [
                'success' => true,
                'booking' => $bookingData,
                'message' => 'Booking cancelled successfully'
            ];

        } catch (Exception $e) {
            Log::error('Booking cancellation failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get available seats for a showtime
     */
    public function getAvailableSeats($showtimeId)
    {
        $showtime = Showtime::with('theater')->findOrFail($showtimeId);
        $theater = $showtime->theater;

        return $theater->generateSeatLayoutForShowtime($showtimeId);
    }

    /**
     * Get booking details
     */
    public function getBookingDetails($bookingId)
    {
        return Booking::with(['showtime.movie', 'showtime.theater', 'user', 'movie', 'theater'])
            ->findOrFail($bookingId);
    }

    /**
     * Get user bookings
     */
    public function getUserBookings($userId)
    {
        return Booking::with(['showtime.movie', 'showtime.theater', 'movie', 'theater'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get showtime bookings (for admin)
     */
    public function getShowtimeBookings($showtimeId)
    {
        return Booking::with(['user', 'showtime.movie', 'showtime.theater', 'movie', 'theater'])
            ->where('showtime_id', $showtimeId)
            ->get();
    }

    /**
     * Calculate ticket price for booking
     */
    private function calculateTicketPrice(Showtime $showtime, int $seatCount)
    {
        $movie = $showtime->movie;
        $theater = $showtime->theater;

        // Base price from movie
        $basePrice = $movie->price;

        // Apply theater multiplier
        $theaterMultiplier = $theater->price_multiplier ?? 1.0;

        // Apply time-based multiplier (weekend/evening surcharge)
        $timeMultiplier = $this->getTimeMultiplier($showtime->start_time);

        $finalPrice = $basePrice * $theaterMultiplier * $timeMultiplier;

        return $finalPrice * $seatCount;
    }

    /**
     * Get time-based price multiplier
     */
    private function getTimeMultiplier($startTime)
    {
        $hour = $startTime->format('H');
        $dayOfWeek = $startTime->format('N'); // 1 (Monday) to 7 (Sunday)

        // Weekend surcharge
        if ($dayOfWeek >= 6) {
            return 1.2;
        }

        // Evening surcharge (after 6 PM)
        if ($hour >= 18) {
            return 1.15;
        }

        return 1.0;
    }

    /**
     * Check which seats are unavailable
     */
    private function getUnavailableSeats(Theater $theater, $showtimeId, array $requestedSeats)
    {
        $unavailableSeats = [];

        // Get all booked seats for this showtime
        $bookedSeats = Booking::where('showtime_id', $showtimeId)
            ->pluck('seats')
            ->flatMap(function ($seatJson) {
                return is_array($seatJson) ? $seatJson : json_decode($seatJson, true) ?? [];
            })
            ->toArray();

        foreach ($requestedSeats as $seat) {
            if (in_array($seat, $bookedSeats)) {
                $unavailableSeats[] = $seat;
            }
        }

        return $unavailableSeats;
    }

    /**
     * Generate unique booking reference (optional since not in your schema)
     */
    private function generateBookingReference()
    {
        do {
            $reference = 'BK' . strtoupper(substr(uniqid(), -8));
        } while (Booking::where('id', $reference)->exists()); // Using id since no booking_reference field

        return $reference;
    }

    /**
     * Get booking statistics
     */
    public function getBookingStats($showtimeId = null, $startDate = null, $endDate = null)
    {
        $query = Booking::query();

        if ($showtimeId) {
            $query->where('showtime_id', $showtimeId);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $bookings = $query->get();

        return [
            'total_bookings' => $bookings->count(),
            'total_ticket_revenue' => $bookings->sum('ticket_price'),
            'total_beverage_revenue' => $bookings->sum('beverage_price'),
            'total_revenue' => $bookings->sum('total_amount'),
            'average_ticket_price' => $bookings->avg('ticket_price'),
            'average_beverage_price' => $bookings->avg('beverage_price'),
            'total_seats_booked' => $bookings->sum(function ($booking) {
                return count($booking->seats);
            })
        ];
    }
}
