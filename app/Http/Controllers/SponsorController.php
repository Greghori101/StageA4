<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $categories = Sponsor::select('category')->distinct()->get();

        $query = Sponsor::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $sponsors = $query->get();

        return view('sponsors.index', compact('sponsors', 'categories'));
    }

    public function create()
    {
        return view('sponsors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'files' => 'nullable|array|max:10240',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,avi|max:10240',
        ]);

        $sponsor = Sponsor::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? null,
        ]);

        if ($request->hasFile('logo')) {
            $sponsor->addMedia($request->file('logo'))->toMediaCollection('logos');
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $sponsor->addMedia($file)->toMediaCollection('files');
            }
        }

        return redirect()->route('sponsors.index')->with('success', 'Sponsor created successfully.');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'files' => 'nullable|array|max:10240',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,avi|max:10240',
        ]);

        $sponsor->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
        ]);

        if ($request->hasFile('logo')) {
            $sponsor->clearMediaCollection('logos');
            $sponsor->addMedia($request->file('logo'))->toMediaCollection('logos');
        }

        if ($request->hasFile('files')) {
            $sponsor->clearMediaCollection('files');
            foreach ($request->file('files') as $file) {
                $sponsor->addMedia($file)->toMediaCollection('files');
            }
        }

        return redirect()->route('sponsors.index')->with('success', 'Sponsor updated successfully.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->clearMediaCollection('logos');
        $sponsor->clearMediaCollection('files');
        $sponsor->delete();

        return redirect()->route('sponsors.index')->with('success', 'Sponsor deleted successfully.');
    }

    public function showByCategory($category)
    {
        $categories = Sponsor::select('category')->distinct()->get();
        $sponsors = Sponsor::where('category', $category)->get();

        return view('sponsors.index', compact('sponsors', 'categories'));
    }
}
