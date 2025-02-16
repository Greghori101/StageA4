@extends('base')

@section('title', 'Questions')

@section('content')
<div class="container text-center mt-5">
    <!-- Title -->
    <div class="mb-4">
        <h1 class="text-white p-3" style="background-color: #56B947; border-radius: 10px;">Questions</h1>
    </div>
    <a href="{{ route('questions.create') }}" class="btn btn-success mb-3">Ask a Question</a>

    <!-- Question Statistics -->
    <div class="d-flex justify-content-center mb-4">
        <div class="p-3 me-2" style="background-color: #F2A341; border-radius: 10px;">
            <h5>Pending</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $pending_count }}</span>
        </div>
        <div class="p-3 me-2" style="background-color: #56A6B4; border-radius: 10px;">
            <h5>Validated</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $validated_count }}</span>
        </div>
        <div class="p-3 me-2" style="background-color: #4CAF50; border-radius: 10px;">
            <h5>Processed</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $processed_count }}</span>
        </div>
        <div class="p-3 ms-2" style="background-color: #E74C3C; border-radius: 10px;">
            <h5>Rejected</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $rejected_count }}</span>
        </div>
    </div>

    <!-- Pending Questions -->
    <div class="p-4 mb-4" style="background-color: #F2A341; border-radius: 10px;">
        <h5 class="text-white">Pending Questions:</h5>
        @if($pending_questions->isEmpty())
        <p>No pending questions at the moment...</p>
        @else
        <div class="row">
            @foreach($pending_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <strong>{{ $question->content }}</strong>
                        <br>
                        <small>Communication: {{ $question->communication->title ?? 'Not specified' }}</small>
                        @if ($question->speaker)
                        <br><small>Speaker: {{ $question->speaker->name }}</small>
                        @endif
                        <div class="mt-2">
                            <form action="{{ route('questions.validate', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Validate</button>
                            </form>
                            <form action="{{ route('questions.reject', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </div>
                        <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />

                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Validated Questions -->
    <div class="p-4 mb-4" style="background-color: #56A6B4; border-radius: 10px;">
        <h5 class="text-white">Validated Questions:</h5>
        @if($validated_questions->isEmpty())
        <p>No validated questions at the moment...</p>
        @else
        <div class="row">
            @foreach($validated_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <strong>{{ $question->content }}</strong>
                        <br>
                        <small>Communication: {{ $question->communication->title ?? 'Not specified' }}</small>
                        @if ($question->speaker)
                        <br><small>Speaker: {{ $question->speaker->name }}</small>
                        @endif
                        <div class="mt-2">
                            <form action="{{ route('questions.process', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Mark as Processed</button>
                            </form>
                            <form action="{{ route('questions.respond', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="text" name="answer" class="form-control d-inline w-75" placeholder="Provide an answer">
                                <button type="submit" class="btn btn-warning btn-sm">Respond</button>
                            </form>
                            <form action="{{ route('questions.reject', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                            <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Processed Questions -->
    <div class="p-4 mb-4" style="background-color: #4CAF50; border-radius: 10px;">
        <h5 class="text-white">Processed Questions:</h5>
        @if($processed_questions->isEmpty())
        <p>No processed questions at the moment...</p>
        @else
        <div class="row">
            @foreach($processed_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <strong>{{ $question->content }}</strong>
                        <br>
                        <small>Communication: {{ $question->communication->title ?? 'Not specified' }}</small>
                        @if ($question->speaker)
                        <br><small>Speaker: {{ $question->speaker->name }}</small>
                        @endif
                        <div class="mt-3">
                            <strong>Answer:</strong>
                            <p>{{ $question->answer ?? 'No answer provided.' }}</p>
                        </div>
                        <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Rejected Questions -->
    <div class="p-4 mb-4" style="background-color: #E74C3C; border-radius: 10px;">
        <h5 class="text-white">Rejected Questions:</h5>
        @if($rejected_questions->isEmpty())
        <p>No rejected questions at the moment...</p>
        @else
        <div class="row">
            @foreach($rejected_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <form action="{{ route('questions.update-rejected', $question->id) }}" method="POST">
                            @csrf
                            <strong>Question:</strong>
                            <textarea name="content" class="form-control mb-2">{{ $question->content }}</textarea>
                            <small>Communication: {{ $question->communication->title ?? 'Not specified' }}</small>
                            @if ($question->speaker)
                            <br><small>Speaker: {{ $question->speaker->name }}</small>
                            @endif
                            <div class="mt-2">
                                <button type="submit" class="btn btn-success btn-sm">Validate After Update</button>
                            </div>
                        </form>
                        <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
