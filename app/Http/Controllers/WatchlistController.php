<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        // Get user's watchlist with movie relationships
        $watchlist = Watchlist::with('movie')
            ->where('user_id', Auth::id())
            ->get();

        // Count expired movies in the watchlist
        $expiredMovies = $watchlist->filter(function($item) {
            return $item->movie->isExpired();
        })->count();

        return view('watchlist.index', compact('watchlist', 'expiredMovies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id'
        ]);

        // Check if already in watchlist
        $existingItem = Watchlist::where('user_id', Auth::id())
            ->where('movie_id', $request->movie_id)
            ->first();

        if ($existingItem) {
            return response()->json([
                'success' => false,
                'message' => 'Movie is already in your watchlist'
            ]);
        }

        // Add to watchlist
        Watchlist::create([
            'user_id' => Auth::id(),
            'movie_id' => $request->movie_id
        ]);
    }

    public function destroy($movieId)
    {

        
        $watchlistItem = Watchlist::where('user_id', Auth::id())
            ->where('movie_id', $movieId)
            ->first();

        if (!$watchlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found in watchlist'
            ]);
        }

        $watchlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie removed from watchlist'
        ]);
    }

    // Optional: Method to automatically clean up expired movies
    public function cleanupExpired()
    {
        $expiredItems = Watchlist::with('movie')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(function($item) {
                return $item->movie->isExpired();
            });

        foreach ($expiredItems as $item) {
            $item->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Expired movies removed from watchlist',
            'removed_count' => $expiredItems->count()
        ]);
    }
}
