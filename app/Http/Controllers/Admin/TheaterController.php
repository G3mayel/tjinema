<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theater;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TheaterController extends Controller
{
    public function index(): View
    {
        $theaters = Theater::latest()->paginate(10);
        return view('admin.theaters.read', compact('theaters'));
    }

    public function create(): View
    {
        return view('admin.theaters.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'type' => 'required|string|in:regular,premium,imax',
        ]);

        Theater::create($validated);

        return redirect()->route('admin.theaters.index')
            ->with('success', 'Theater created successfully.');
    }

    public function edit(Theater $theater): View
    {
        return view('admin.theaters.edit', compact('theater'));
    }

    public function update(Request $request, Theater $theater): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'type' => 'required|string|in:regular,premium,imax',
        ]);

        $theater->update($validated);

        return redirect()->route('admin.theaters.index')
            ->with('success', 'Theater updated successfully.');
    }

    public function destroy(Theater $theater): RedirectResponse
    {
        $theater->delete();

        return redirect()->route('admin.theaters.index')
            ->with('success', 'Theater deleted successfully.');
    }
}
