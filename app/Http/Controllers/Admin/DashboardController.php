<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Booking;
use App\Models\User;
use App\Models\Theater;
use App\Models\Activity; // Add if you have an Activity model
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMovies = Movie::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::sum('total_amount');
        $totalUsers = User::where('is_admin', false)->count();
        $totalTheaters = Theater::count(); // Add this line

        // Recent activities - adjust based on your Activity model structure
        $recentActivities = collect(); // Empty collection if no Activity model
        // If you have an Activity model, uncomment the line below:
        // $recentActivities = Activity::with('user')->latest()->take(10)->get();

        // Popular movies with booking counts and revenue
        $popularMovies = Movie::withCount('bookings')
            ->with(['bookings' => function($query) {
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            }])
            ->get()
            ->map(function($movie) {
                $weeklyBookings = $movie->bookings->count();
                $weeklyRevenue = $movie->bookings->sum('total_amount');

                $movie->bookings_count = $weeklyBookings;
                $movie->revenue = $weeklyRevenue;
                $movie->rating = $movie->rating ?? 0; // Default rating if not set

                return $movie;
            })
            ->sortByDesc('bookings_count')
            ->take(10);

        $recentBookings = Booking::with(['user', 'movie', 'theater'])
            ->latest()
            ->take(10)
            ->get();

        $monthlyRevenue = Booking::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalMovies',
            'totalBookings',
            'totalRevenue',
            'totalUsers',
            'totalTheaters', // Add this line
            'recentActivities', // Add this line
            'popularMovies', // Add this line
            'recentBookings',
            'monthlyRevenue'
        ));
    }
}
