<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $speakers = Speaker::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', "%{$search}%");
        })->get();

        return view('speakers.index', compact('speakers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('speakers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $speaker = Speaker::create([
            'full_name' => $validated['full_name'],
            'biography' => $validated['biography'],
        ]);

        if ($request->hasFile('photo')) {
            $speaker->addMedia($request->file('photo'))->toMediaCollection('photos');
        }

        return redirect()->route('speakers.index')->with('success', 'Speaker created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $speaker = Speaker::with('communications')->findOrFail($id);

        return view('speakers.show', compact('speaker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $speaker = Speaker::findOrFail($id);
        return view('speakers.edit', compact('speaker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $speaker = Speaker::findOrFail($id);
        $speaker->update($validated);

        if ($request->hasFile('photo')) {
            $speaker->clearMediaCollection('photos');
            $speaker->addMedia($request->file('photo'))->toMediaCollection('photos');
        }

        return redirect()->route('speakers.index')->with('success', 'Speaker updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $speaker = Speaker::findOrFail($id);
        $speaker->clearMediaCollection('photos');
        $speaker->delete();

        return redirect()->route('speakers.index')->with('success', 'Speaker deleted successfully.');
    }
}
