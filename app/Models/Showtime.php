<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $fillable = [
        'movie_id',
        'theater_id',
        'start_time',
        'end_time',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFormattedTimeAttribute()
    {
        return $this->start_time->format('H:i');
    }
}
