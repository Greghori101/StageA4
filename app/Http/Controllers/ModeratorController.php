<?php

namespace App\Http\Controllers;

use App\Models\Moderator;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    /**
     * Display a listing of moderators.
     */
    public function index()
    {
        $moderators = Moderator::all();
        return view('moderators.index', compact('moderators'));
    }

    /**
     * Show the form for creating a new moderator.
     */
    public function create()
    {
        return view('moderators.create');
    }

    /**
     * Store a newly created moderator in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $moderator = Moderator::create($validated);

        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            $moderator->addMedia($request->file('avatar'))->toMediaCollection('photo');
        }

        return redirect()->route('moderators.index')->with('success', 'Moderator created successfully.');
    }

    /**
     * Display the specified moderator.
     */
    public function show(Moderator $moderator)
    {
        return view('moderators.show', compact('moderator'));
    }

    /**
     * Show the form for editing the specified moderator.
     */
    public function edit(Moderator $moderator)
    {
        return view('moderators.edit', compact('moderator'));
    }

    /**
     * Update the specified moderator in storage.
     */
    public function update(Request $request, Moderator $moderator)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $moderator->update($validated);

        // Handle avatar update
        if ($request->hasFile('avatar')) {
            $moderator->clearMediaCollection('photo'); // Remove old avatar
            $moderator->addMedia($request->file('avatar'))->toMediaCollection('photo');
        }

        return redirect()->route('moderators.index')->with('success', 'Moderator updated successfully.');
    }

    /**
     * Remove the specified moderator from storage.
     */
    public function destroy(Moderator $moderator)
    {
        $moderator->clearMediaCollection('photo'); // Remove associated avatar
        $moderator->delete();

        return redirect()->route('moderators.index')->with('success', 'Moderator deleted successfully.');
    }
}
