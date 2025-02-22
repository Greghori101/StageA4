@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">Speaker Details</h1>

    <div class="card">
        <div class="card-header">
            <h3>{{ $speaker->full_name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Biography:</strong></p>
            <p>{{ $speaker->biography }}</p>

            <p><strong>Avatar:</strong></p>
            @if($speaker->getFirstMediaUrl('avatar'))
                <img src="{{ $speaker->getFirstMediaUrl('avatar') }}" alt="Avatar" class="img-thumbnail" width="150">
            @else
                <p>No Avatar</p>
            @endif

            <div class="mt-4">
                <x-favorite-button modelType="App\Models\Speaker" :modelId="$speaker->id" />

                @if(auth()->user()->can('update Speaker'))
                    <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-warning">Edit</a>
                @endif

                <a href="{{ route('speakers.index') }}" class="btn btn-secondary">Back to List</a>

                @if(auth()->user()->can('delete Speaker'))
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSpeakerModal">
                        Delete
                    </button>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteSpeakerModal" tabindex="-1" aria-labelledby="deleteSpeakerLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteSpeakerLabel">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete speaker "{{ $speaker->full_name }}"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Questions related to this Speaker -->
    <div class="mt-5">
        <h4>Questions for {{ $speaker->full_name }}</h4>

        @if($speaker->questions->isEmpty())
            <p>No questions asked yet.</p>
        @else
            <div class="row">
                @foreach($speaker->questions as $question)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <strong>{{ $question->content }}</strong>
                                <br>
                                <small>Communication: {{ $question->communication->title ?? 'Not specified' }}</small>
                                <div class="mt-3">
                                    <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
