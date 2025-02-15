@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $communication->title }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Description:</strong> {{ $communication->description }}</p>
            <p><strong>Date:</strong> {{ $communication->date }}</p>
            <p><strong>Time:</strong> {{ $communication->start_time }} - {{ $communication->end_time }}</p>
            <p><strong>Type:</strong> {{ ucfirst($communication->type) }}</p>
            <p><strong>Program Session:</strong> {{ $communication->programSession?->name ?? 'N/A' }}</p>
            <p><strong>Room:</strong> {{ $communication->room?->name ?? 'N/A' }}</p>

            <h5>Speakers</h5>
            <ul>
                @forelse ($communication->speakers as $speaker)
                    <li>{{ $speaker->full_name }}</li>
                @empty
                    <li>No speakers assigned.</li>
                @endforelse
            </ul>

            <h5>Sponsors</h5>
            <ul>
                @forelse ($communication->sponsors as $sponsor)
                    <li>{{ $sponsor->name }}</li>
                @empty
                    <li>No sponsors assigned.</li>
                @endforelse
            </ul>

            <h5>Questions</h5>
            <ul>
                @forelse ($communication->questions as $question)
                    <li>{{ $question->content }}</li>
                @empty
                    <li>No questions asked.</li>
                @endforelse
            </ul>

            <a href="{{ route('communications.edit', $communication) }}" class="btn btn-warning">Edit</a>

            <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

            <a href="{{ route('communications.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
