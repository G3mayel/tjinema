<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class UserActivityController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['movie', 'theater', 'showtime', 'beverages.beverage'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.activity', compact('bookings'));
    }
    
}
