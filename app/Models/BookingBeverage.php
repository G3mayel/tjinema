<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingBeverage extends Model
{
    protected $fillable = [
        'booking_id',
        'beverage_id',
        'quantity',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function beverage()
    {
        return $this->belongsTo(Beverage::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->beverage->price * $this->quantity;
    }
}
