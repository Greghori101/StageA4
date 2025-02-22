@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">Communications</h1>

    @if (auth()->user()->can('create Communication'))
        <a href="{{ route('communications.create') }}" class="btn btn-primary mb-3">Add New Communication</a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->can('read Communication'))
        @if(auth()->user()->hasRole('admin'))
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
                                <x-favorite-button modelType="App\Models\Communication" :modelId="$communication->id" />
                                <a href="{{ route('communications.show', $communication) }}" class="btn btn-info btn-sm">View</a>

                                @if(auth()->user()->can('update Communication'))
                                    <a href="{{ route('communications.edit', $communication) }}" class="btn btn-warning btn-sm">Edit</a>
                                @endif

                                @if(auth()->user()->can('delete Communication'))
                                    <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No communications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="row">
                @foreach ($communications as $communication)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $communication->title }}</h5>
                                <p class="card-text"><strong>Date:</strong> {{ $communication->date }}</p>
                                <p class="card-text"><strong>Time:</strong> {{ $communication->start_time }} - {{ $communication->end_time }}</p>
                                <p class="card-text"><strong>Type:</strong> {{ ucfirst($communication->type) }}</p>
                                <p class="card-text"><strong>Room:</strong> {{ $communication->room?->name ?? 'N/A' }}</p>
                                <a href="{{ route('communications.show', $communication) }}" class="btn btn-info btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <div class="d-flex justify-content-center">
        {{ $communications->links() }}
    </div>
</div>
@endsection
