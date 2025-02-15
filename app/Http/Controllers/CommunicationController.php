<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\ProgramSession;
use App\Models\Room;
use App\Models\Speaker;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communications = Communication::with(['programSession', 'room', 'speakers', 'sponsors'])->paginate(10);
        return view('communications.index', compact('communications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programSessions = ProgramSession::all();
        $rooms = Room::all();
        $speakers = Speaker::all();
        $sponsors = Sponsor::all();

        return view('communications.create', compact('programSessions', 'rooms', 'speakers', 'sponsors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'type' => 'required|string',
            'program_session_id' => 'nullable|exists:program_sessions,id',
            'room_id' => 'nullable|exists:rooms,id',
            'speakers' => 'array',
            'speakers.*' => 'exists:speakers,id',
            'sponsors' => 'array',
            'sponsors.*' => 'exists:sponsors,id',
        ]);

        $communication = Communication::create($validated);

        if ($request->has('speakers')) {
            $communication->speakers()->sync($request->speakers);
        }

        if ($request->has('sponsors')) {
            $communication->sponsors()->sync($request->sponsors);
        }

        return redirect()->route('communications.index')->with('success', 'Communication created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Communication $communication)
    {
        return view('communications.show', compact('communication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Communication $communication)
    {
        $programSessions = ProgramSession::all();
        $rooms = Room::all();
        $speakers = Speaker::all();
        $sponsors = Sponsor::all();

        return view('communications.edit', compact('communication', 'programSessions', 'rooms', 'speakers', 'sponsors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Communication $communication)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'type' => 'required|string',
            'program_session_id' => 'nullable|exists:program_sessions,id',
            'room_id' => 'nullable|exists:rooms,id',
            'speakers' => 'array',
            'speakers.*' => 'exists:speakers,id',
            'sponsors' => 'array',
            'sponsors.*' => 'exists:sponsors,id',
        ]);

        $communication->update($validated);

        if ($request->has('speakers')) {
            $communication->speakers()->sync($request->speakers);
        }

        if ($request->has('sponsors')) {
            $communication->sponsors()->sync($request->sponsors);
        }

        return redirect()->route('communications.index')->with('success', 'Communication updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Communication $communication)
    {
        $communication->delete();
        return redirect()->route('communications.index')->with('success', 'Communication deleted successfully.');
    }
}
