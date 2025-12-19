<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'theater_id',
        'row_number',
        'seat_number',
        'seat_type',
        'is_occupied',
        'is_available',
    ];

    protected $casts = [
        'is_occupied' => 'boolean',
        'is_available' => 'boolean',
    ];

    /**
     * Get the theater that owns the seat.
     */
    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

    /**
     * Get the seat label (e.g., A1, B2, etc.)
     */
    public function getSeatLabelAttribute(): string
    {
        return chr(64 + $this->row_number) . $this->seat_number;
    }

    /**
     * Scope to get available seats
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('is_occupied', false);
    }

    /**
     * Scope to get occupied seats
     */
    public function scopeOccupied($query)
    {
        return $query->where('is_occupied', true);
    }
}
