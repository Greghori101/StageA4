<?php

namespace App\Http\Controllers;

use App\Models\ProgramSession;
use Illuminate\Http\Request;

class ProgramSessionController extends Controller
{
    /**
     * Display a listing of the program sessions.
     */
    public function index()
    {
        $sessions = ProgramSession::latest()->paginate(10);
        return view('program_sessions.index', compact('sessions'));
    }

    public function show(ProgramSession $programSession)
    {
        // Load related communications
        $programSession->load('communications');

        return view('program_sessions.show', compact('programSession'));
    }


    /**
     * Show the form for creating a new program session.
     */
    public function create()
    {
        return view('program_sessions.create');
    }

    /**
     * Store a newly created program session.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        ProgramSession::create($request->all());

        return redirect()->route('program_sessions.index')->with('success', 'Session ajoutée avec succès.');
    }

    /**
     * Show the form for editing the specified program session.
     */
    public function edit(ProgramSession $programSession)
    {
        return view('program_sessions.edit', compact('programSession'));
    }

    /**
     * Update the specified program session.
     */
    public function update(Request $request, ProgramSession $programSession)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $programSession->update($request->all());

        return redirect()->route('program_sessions.index')->with('success', 'Session mise à jour avec succès.');
    }

    /**
     * Remove the specified program session.
     */
    public function destroy(ProgramSession $programSession)
    {
        $programSession->delete();
        return redirect()->route('program_sessions.index')->with('success', 'Session supprimée avec succès.');
    }
}
