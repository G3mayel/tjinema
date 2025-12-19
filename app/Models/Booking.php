<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'theater_id',
        'showtime_id',
        'booking_date',
        'seats',
        'ticket_price',
        'beverage_price',
        'total_amount',
        'payment_method'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'ticket_price' => 'decimal:2',
        'beverage_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'seats' => 'array'
    ];

    /**
     * Get the user that owns the booking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the movie for this booking
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the theater for this booking
     */
    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

    /**
     * Get the showtime for this booking
     */
    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    /**
     * Get the beverages for this booking
     */
    public function beverages(): HasMany
    {
        return $this->hasMany(BookingBeverage::class);
    }

    /**
     * Get seat count
     */
    public function getSeatCountAttribute()
    {
        return is_array($this->seats) ? count($this->seats) : 0;
    }

    /**
     * Get formatted seats
     */
    public function getFormattedSeatsAttribute()
    {
        if (is_array($this->seats)) {
            return implode(', ', $this->seats);
        }
        return '';
    }

    /**
     * Get show date from booking_date
     */
    public function getShowDateAttribute()
    {
        return $this->booking_date ? $this->booking_date->format('Y-m-d') : null;
    }

    /**
     * Get total price (alias for total_amount)
     */
    public function getTotalPriceAttribute()
    {
        return $this->total_amount;
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled()
    {
        // Can't cancel if showtime has already started
        return $this->showtime->start_time->isFuture();
    }

    /**
     * Check if booking is active
     */
    public function isActive()
    {
        return true; // Since there's no status field, all bookings are considered active
    }

    /**
     * Scope for active bookings
     */
    public function scopeActive($query)
    {
        return $query; // Return all since no status field
    }

    /**
     * Scope for confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query; // Return all since no status field
    }

    /**
     * Scope for user bookings
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getSeatsArrayAttribute()
{
    if (empty($this->seats)) {
        return [];
    }

    // If it's already an array, return it
    if (is_array($this->seats)) {
        return array_filter($this->seats);
    }

    // If it's a string, try to parse it
    if (is_string($this->seats)) {
        // First try JSON decode
        $jsonDecoded = json_decode($this->seats, true);
        if (is_array($jsonDecoded)) {
            return array_filter($jsonDecoded);
        }

        // If not JSON, try comma-separated string
        $exploded = explode(',', $this->seats);
        $cleaned = array_map('trim', $exploded);
        return array_filter($cleaned);
    }

    return [];
}
}
