<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::latest()->paginate(10);
        return view('admin.movies.read', compact('movies'));
    }

    public function create(): View
    {
        return view('admin.movies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'rating' => 'required|string|max:10',
            'showing_start' => 'required|date',
            'showing_end' => 'required|date|after:showing_start',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Movie::create($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie created successfully.');
    }

    public function edit(Movie $movie): View
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'rating' => 'required|string|max:10',
            'showing_start' => 'required|date',
            'showing_end' => 'required|date|after:showing_start',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie deleted successfully.');
    }
}
