<!-- resources/views/speakers/show.blade.php -->

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
            @if($speaker->avatar)
                <img src="{{ $speaker->avatar->getUrl() }}" alt="Avatar" class="img-thumbnail" width="150">
            @else
                <p>No Avatar</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('speakers.index') }}" class="btn btn-secondary">Back to List</a>

                <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
