<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'capacity',
        'price_multiplier',
        // other fillable fields
    ];

    protected $casts = [
        'price_multiplier' => 'decimal:2',
        'capacity' => 'integer',
    ];

    /**
     * Get all seats for this theater
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Get all showtimes for this theater
     */
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    /**
     * Get all bookings for this theater
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get available seats for this theater
     */
    public function availableSeats()
    {
        return $this->seats()->available();
    }

    /**
     * Get occupied seats for this theater
     */
    public function occupiedSeats()
    {
        return $this->seats()->occupied();
    }
}
