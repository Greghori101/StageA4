<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\ProgramSession;
use App\Models\Room;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CommunicationsController extends Controller
{
    public function index($programSessionId)
    {
        $programSession = ProgramSession::findOrFail($programSessionId);
        $communications = Communication::where('program_session_id', $programSessionId)->distinct()->get();

        return view('communications.index', compact('communications', 'programSession'));
    }

    public function create($programSessionId)
    {
        $programSession = ProgramSession::findOrFail($programSessionId);
        $rooms = Room::all();
        $speakers = Speaker::all();

        return view('communications.create', compact('programSession', 'rooms', 'speakers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:communications,title,NULL,id,program_session_id,' . $request->program_session_id,
            'description' => 'nullable|string',
            'type' => 'required|string|in:communication,symposium,workshop,break',
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i|before:end_time',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'program_session_id' => 'required|exists:program_sessions,id',
            'speakers' => 'array|nullable',
            'speakers.*' => 'exists:speakers,id',
        ]);

        $programSession = ProgramSession::findOrFail($validated['program_session_id']);
        $sessionTimezone = $programSession->timezone ?? 'UTC';

        $communicationDateStart = Carbon::parse($validated['date'] . ' ' . $validated['start_time'])
                                        ->setTimezone($sessionTimezone);

        $communicationDateEnd = Carbon::parse($validated['date'] . ' ' . $validated['end_time'])
                                      ->setTimezone($sessionTimezone);

        $sessionDate = Carbon::parse($programSession->date)->setTimezone($sessionTimezone)->startOfDay();

        if (!$communicationDateStart->isSameDay($sessionDate)) {
            return redirect()->back()->withErrors(['date_mismatch' => 'The communication date must match the program session date.']);
        }

        $existingCommunication = Communication::where('title', $validated['title'])
                                              ->where('date', $validated['date'])
                                              ->where('program_session_id', $validated['program_session_id'])
                                              ->first();

        if ($existingCommunication) {
            return redirect()->back()->withErrors(['duplicate' => 'This communication already exists for this program session.']);
        }

        $communication = Communication::create($validated);

        if (!empty($validated['speakers'])) {
            $communication->speakers()->sync($validated['speakers']);
        }

        return redirect()->route('program-sessions.communications', $validated['program_session_id'])
                         ->with('success', 'Communication created successfully.');
    }

    public function show($id)
    {
        $communication = Communication::with([
            'speakers',
            'room',
            'questions' => fn($query) => $query->where('status', 'answered')
        ])->findOrFail($id);

        return view('communications.show', compact('communication'));
    }

    public function edit($id)
    {
        $communication = Communication::findOrFail($id);
        $programSessions = ProgramSession::all();
        $rooms = Room::all();
        $speakers = Speaker::all();

        return view('communications.edit', compact('communication', 'programSessions', 'rooms', 'speakers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:communication,symposium,workshop,break',
            'program_session_id' => 'required|exists:program_sessions,id',
            'room_id' => 'required|exists:rooms,id',
            'speakers' => 'array|nullable',
            'speakers.*' => 'exists:speakers,id',
        ]);

        $communication = Communication::findOrFail($id);
        $communication->update($validated);

        if (!empty($validated['speakers'])) {
            $communication->speakers()->sync($validated['speakers']);
        } else {
            $communication->speakers()->detach();
        }

        return redirect()->route('communications.index', $communication->program_session_id)
                         ->with('success', 'Communication updated successfully.');
    }

    public function destroy($id)
    {
        $communication = Communication::findOrFail($id);
        $communication->delete();

        return redirect()->route('program-sessions.show', $communication->program_session_id)
                         ->with('success', 'Communication deleted successfully.');
    }
}
