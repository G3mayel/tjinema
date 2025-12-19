<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beverage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeverageController extends Controller
{
    public function index(): View
    {
        $beverages = Beverage::latest()->paginate(10);
        return view('admin.beverages.index', compact('beverages'));
    }

    public function create(): View
    {
        return view('admin.beverages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Beverage::create($validated);

        return redirect()->route('admin.beverages.index')
            ->with('success', 'Beverage created successfully.');
    }

    public function edit(Beverage $beverage): View
    {
        return view('admin.beverages.edit', compact('beverage'));
    }

    public function update(Request $request, Beverage $beverage): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $beverage->update($validated);

        return redirect()->route('admin.beverages.index')
            ->with('success', 'Beverage updated successfully.');
    }

    public function destroy(Beverage $beverage): RedirectResponse
    {
        $beverage->delete();

        return redirect()->route('admin.beverages.index')
            ->with('success', 'Beverage deleted successfully.');
    }
}
