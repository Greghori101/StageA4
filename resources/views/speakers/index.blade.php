<!-- resources/views/speakers/index.blade.php -->

@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">Speakers</h1>

    <a href="{{ route('speakers.create') }}" class="btn btn-primary mb-3">Add New Speaker</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Biography</th>
                <th>Avatar</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($speakers as $speaker)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $speaker->full_name }}</td>
                    <td>{{ Str::limit($speaker->biography, 50) }}</td>
                    <td>
                        @if($speaker->avatar)
                            <img src="{{ $speaker->avatar->getUrl() }}" alt="Avatar" width="50">
                        @else
                            No Avatar
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('speakers.show', $speaker) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
