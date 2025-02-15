@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">Communications</h1>

    <a href="{{ route('communications.create') }}" class="btn btn-primary mb-3">Add New Communication</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Type</th>
                <th>Program Session</th>
                <th>Room</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($communications as $communication)
                <tr>
                    <td>{{ $communication->title }}</td>
                    <td>{{ $communication->date }}</td>
                    <td>{{ $communication->start_time }} - {{ $communication->end_time }}</td>
                    <td>{{ ucfirst($communication->type) }}</td>
                    <td>{{ $communication->programSession?->name ?? 'N/A' }}</td>
                    <td>{{ $communication->room?->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('communications.show', $communication) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('communications.edit', $communication) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No communications found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $communications->links() }}
    </div>
</div>
@endsection
