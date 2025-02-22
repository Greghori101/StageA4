@extends('base')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Speakers</h1>
        @if(auth()->user()->can('create Speaker'))
            <a href="{{ route('speakers.create') }}" class="btn btn-primary">Add New Speaker</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->hasRole('admin'))
        <!-- ADMIN VIEW : TABLE -->
        <div class="card">
            <div class="card-body">
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
                                @if($speaker->getFirstMediaUrl('avatar'))
                                    <img src="{{ $speaker->getFirstMediaUrl('avatar') }}" alt="Avatar" width="50">
                                @else
                                    No Avatar
                                @endif
                            </td>
                            <td>
                                <x-favorite-button modelType="App\Models\Speaker" :modelId="$speaker->id" />
                                <a href="{{ route('speakers.show', $speaker) }}" class="btn btn-info btn-sm">View</a>

                                @if(auth()->user()->can('update Speaker'))
                                    <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-warning btn-sm">Edit</a>
                                @endif

                                @if(auth()->user()->can('delete Speaker'))
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSpeakerModal{{ $speaker->id }}">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteSpeakerModal{{ $speaker->id }}" tabindex="-1" aria-labelledby="deleteSpeakerLabel" aria-hidden="true">
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- MODERATOR & VISITOR VIEW : CARDS -->
        <div class="row">
            @foreach($speakers as $speaker)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            @if($speaker->getFirstMediaUrl('avatar'))
                                <img src="{{ $speaker->getFirstMediaUrl('avatar') }}" alt="Avatar" class="img-fluid rounded-circle mb-2" width="100">
                            @else
                                <div class="mb-2">No Avatar</div>
                            @endif
                            <h5 class="card-title">{{ $speaker->full_name }}</h5>
                            <p>{{ Str::limit($speaker->biography, 100) }}</p>
                            <a href="{{ route('speakers.show', $speaker) }}" class="btn btn-info btn-sm">View</a>
                            <x-favorite-button modelType="App\Models\Speaker" :modelId="$speaker->id" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
