<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre',
        'rating',
        'duration',
        'price',
        'poster',
        'description',
        'showing_start',
        'showing_end',
        'end_date', // Movie's end date, if applicable
        // Other fillable fields as needed
    ];

    protected $casts = [
        'showing_start' => 'datetime', // Casting to datetime for date comparisons
        'showing_end' => 'datetime',
        'end_date' => 'date', // Casting to date for proper date storage
        'price' => 'decimal:2', // Price should be a decimal with 2 decimal places
    ];

    /**
     * Get all bookings for this movie
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all showtimes for this movie
     */
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    /**
     * Check if the movie is expired (no longer showing).
     * This checks if the `showing_end` date is in the past.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->showing_end < now()->startOfDay();
    }

    /**
     * Relationship with the Watchlist model (one-to-many).
     * This will return all watchlist items related to the movie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function watchlistItems()
    {
        return $this->hasMany(Watchlist::class);
    }

    /**
     * Alias for `watchlistItems` for Blade template compatibility.
     * This is for backward compatibility with any templates expecting `watchlists` as the relationship name.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function watchlists()
    {
        return $this->watchlistItems();
    }

    /**
     * Check if a specific movie is in a user's watchlist.
     *
     * @param int $userId
     * @return bool
     */
    public function isInWatchlist($userId)
    {
        return $this->watchlistItems()->where('user_id', $userId)->exists();
    }

    /**
     * Scope to get active (non-expired) movies.
     * An active movie is one that doesn't have an `end_date`, or its `end_date` is greater than or equal to today's date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', Carbon::now());
        });
    }

    /**
     * Scope to get expired movies.
     * An expired movie is one that has an `end_date` earlier than today's date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', Carbon::now());
    }
}
