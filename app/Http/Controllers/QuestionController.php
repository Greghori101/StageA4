<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $pendingCount = Question::where('status', 'pending')->count();
        $approvedCount = Question::where('status', 'approved')->count();
        $processedCount = Question::where('status', 'processed')->count();
        $rejectedCount = Question::where('status', 'rejected')->count();

        $pendingQuestions = Question::where('status', 'pending')->with(['communication', 'speaker'])->get();
        $approvedQuestions = Question::where('status', 'approved')->with(['communication', 'speaker'])->get();
        $processedQuestions = Question::where('status', 'processed')->with(['communication', 'speaker'])->get();
        $rejectedQuestions = Question::where('status', 'rejected')->with(['communication', 'speaker'])->get();

        return view('questions.index', compact(
            'pendingCount',
            'approvedCount',
            'processedCount',
            'rejectedCount',
            'pendingQuestions',
            'approvedQuestions',
            'processedQuestions',
            'rejectedQuestions'
        ));
    }

    public function create(Request $request)
    {
        $communications = Communication::all();
        $speakers = collect();

        if ($request->filled('communication_id')) {
            $communication = Communication::find($request->communication_id);
            if ($communication) {
                $speakers = $communication->speakers;
            }
        }

        return view('questions.create', compact('communications', 'speakers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'communication_id' => 'required|exists:communications,id',
            'speaker_id' => 'nullable|exists:speakers,id',
        ]);

        Question::create($validated);

        return redirect()->route('questions.create')->with('success', 'Your question has been submitted.');
    }

    public function getSpeakers($communicationId)
    {
        $communication = Communication::with('speakers')->find($communicationId);

        return $communication ? response()->json($communication->speakers) : response()->json([], 404);
    }

    public function showCommunicationWithSpeakers($id)
    {
        $communication = Communication::with('speakers')->find($id);

        if (!$communication) {
            return redirect()->back()->with('error', 'Communication not found.');
        }

        return view('communications.show', compact('communication'));
    }

    public function approve($id)
    {
        $question = Question::findOrFail($id);
        $question->update(['status' => 'approved']);

        return redirect()->route('questions.index')->with('success', 'Question approved successfully.');
    }

    public function reject($id)
    {
        $question = Question::findOrFail($id);
        $question->update(['status' => 'rejected']);

        return redirect()->route('questions.index')->with('success', 'Question rejected successfully.');
    }

    public function process($id)
    {
        $question = Question::where('id', $id)->where('status', 'approved')->firstOrFail();

        $question->update([
            'status' => 'processed',
            'response' => 'Answered verbally by the speaker.',
        ]);

        return redirect()->route('questions.index')->with('success', 'The question has been processed, and the response has been recorded.');
    }

    public function updateRejected(Request $request, $id)
    {
        $question = Question::where('id', $id)->where('status', 'rejected')->firstOrFail();

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $question->update([
            'content' => $validated['content'],
            'status' => 'approved',
        ]);

        return redirect()->route('questions.index')->with('success', 'The question has been updated and approved.');
    }

    public function respond(Request $request, $id)
    {
        $question = Question::where('id', $id)->where('status', 'approved')->firstOrFail();

        $validated = $request->validate([
            'response' => 'required|string',
        ]);

        $question->update([
            'response' => $validated['response'],
            'status' => 'processed',
        ]);

        return redirect()->route('questions.index')->with('success', 'The question has been processed, and the response has been recorded.');
    }
}
