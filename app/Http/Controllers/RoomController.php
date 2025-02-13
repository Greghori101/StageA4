<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('communications')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $room = Room::findOrFail($id);
        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
