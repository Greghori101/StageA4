<?php

namespace App\Http\Controllers;

use App\Models\ProgramSession;
use App\Models\Speaker;
use App\Models\Room;
use Illuminate\Http\Request;

class ProgramSessionController extends Controller
{
    public function index()
    {
        $sessions = ProgramSession::with(['speakers', 'communications.room'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $rooms = Room::all();

        return view('program_sessions.index', compact('sessions', 'rooms'));
    }

    public function create()
    {
        $speakers = Speaker::all();
        return view('program_sessions.create', compact('speakers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'speakers' => 'nullable|array',
            'speakers.*' => 'exists:speakers,id',
            'communications' => 'nullable|array',
            'communications.*.title' => 'required|string|max:255',
            'communications.*.description' => 'nullable|string',
            'communications.*.date' => 'required|date',
            'communications.*.start_time' => 'required|date_format:H:i',
            'communications.*.end_time' => 'required|date_format:H:i|after:communications.*.start_time',
            'communications.*.type' => 'required|in:communication,symposium,workshop,break',
            'communications.*.room_id' => 'required|exists:rooms,id',
        ]);

        $session = ProgramSession::create($validated);

        if (isset($validated['speakers'])) {
            $session->speakers()->attach($validated['speakers']);
        }

        if (isset($validated['communications'])) {
            foreach ($validated['communications'] as $communication) {
                $session->communications()->create($communication);
            }
        }

        return redirect()->route('program_sessions.index')->with('success', 'Session and communications created successfully.');
    }

    public function edit(string $id)
    {
        $session = ProgramSession::with('communications')->findOrFail($id);
        $session->start_time = date('H:i', strtotime($session->start_time));
        $session->end_time = date('H:i', strtotime($session->end_time));

        $rooms = Room::all();
        $speakers = Speaker::all();

        return view('program_sessions.edit', compact('session', 'rooms', 'speakers'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'speakers' => 'nullable|array',
        ]);

        $session = ProgramSession::findOrFail($id);
        $session->update($validated);

        if (isset($validated['speakers'])) {
            $session->speakers()->sync($validated['speakers']);
        }

        return redirect()->route('program_sessions.index')->with('success', 'Session updated successfully.');
    }

    public function destroy(string $id)
    {
        $session = ProgramSession::findOrFail($id);
        $session->delete();

        return redirect()->route('program_sessions.index')->with('success', 'Session deleted successfully.');
    }
}
