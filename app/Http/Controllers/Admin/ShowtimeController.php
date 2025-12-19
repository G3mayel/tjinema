<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShowtimeController extends Controller
{
    public function index(): View
    {
        $showtimes = Showtime::with(['movie', 'theater'])
            ->latest()
            ->paginate(15);

        return view('admin.showtimes.read', compact('showtimes'));
    }

    public function create(): View
    {
        $movies = Movie::where('showing_end', '>=', now())->get();
        $theaters = Theater::all();

        return view('admin.showtimes.create', compact('movies', 'theaters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'start_time' => 'required|date|after:now',
        ]);

        $movie = Movie::find($validated['movie_id']);
        $endTime = \Carbon\Carbon::parse($validated['start_time'])
            ->addMinutes($movie->duration);

        $validated['end_time'] = $endTime;

        Showtime::create($validated);

        return redirect()->route('admin.showtimes.index')
            ->with('success', 'Showtime created successfully.');
    }

    public function edit(Showtime $showtime): View
    {
        $movies = Movie::where('showing_end', '>=', now())->get();
        $theaters = Theater::all();

        return view('admin.showtimes.edit', compact('showtime', 'movies', 'theaters'));
    }

    public function update(Request $request, Showtime $showtime): RedirectResponse
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'start_time' => 'required|date',
        ]);

        $movie = Movie::find($validated['movie_id']);
        $endTime = \Carbon\Carbon::parse($validated['start_time'])
            ->addMinutes($movie->duration);

        $validated['end_time'] = $endTime;

        $showtime->update($validated);

        return redirect()->route('admin.showtimes.index')
            ->with('success', 'Showtime updated successfully.');
    }

    public function destroy(Showtime $showtime): RedirectResponse
    {
        $showtime->delete();

        return redirect()->route('admin.showtimes.index')
            ->with('success', 'Showtime deleted successfully.');
    }
}
