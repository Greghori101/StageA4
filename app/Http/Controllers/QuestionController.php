<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use App\Models\Communication;
use App\Models\Speaker;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     */
    public function index()
    {
        $questions = Question::latest()->paginate(10);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        $users = User::all();
        $communications = Communication::all();
        $speakers = Speaker::all();

        return view('questions.create', compact('users', 'communications', 'speakers'));
    }

    /**
     * Store a newly created question in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'answer' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'communication_id' => 'required|exists:communications,id',
            'speaker_id' => 'nullable|exists:speakers,id',
            'status' => 'required|in:pending,answered,rejected',
        ]);

        Question::create($request->all());

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $users = User::all();
        $communications = Communication::all();
        $speakers = Speaker::all();

        return view('questions.edit', compact('question', 'users', 'communications', 'speakers'));
    }

    /**
     * Update the specified question in the database.
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string',
            'answer' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'communication_id' => 'required|exists:communications,id',
            'speaker_id' => 'nullable|exists:speakers,id',
            'status' => 'required|in:pending,answered,rejected',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified question from the database.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }
}
