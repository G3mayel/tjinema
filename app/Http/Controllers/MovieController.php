<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $nowShowing = Movie::with('watchlists')
            ->where('showing_start', '<=', now())
            ->where('showing_end', '>=', now())
            ->latest()
            ->get();

        $comingSoon = Movie::with('watchlists') 
            ->where('showing_start', '>', now())
            ->latest()
            ->take(6)
            ->get();

        return view('movies.read', compact('nowShowing', 'comingSoon'));
    }

    public function show(Movie $movie): View
    {
        $isInWatchlist = false;

        if (Auth::check()) {
            $isInWatchlist = Watchlist::where('user_id', Auth::id())
                ->where('movie_id', $movie->id)
                ->exists();
        }

        return view('movies.show', compact('movie', 'isInWatchlist'));
    }
    public function toggleWatchlist(Request $request, Movie $movie)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $watchlist = Watchlist::where('user_id', Auth::id())
            ->where('movie_id', $movie->id)
            ->first();

        if ($watchlist) {
            $watchlist->delete();
            $message = 'Removed from watchlist';
        } else {
            Watchlist::create([
                'user_id' => Auth::id(),
                'movie_id' => $movie->id,
            ]);
            $message = 'Added to watchlist';
        }

        return redirect()->back()->with('message', $message);
    }

}
