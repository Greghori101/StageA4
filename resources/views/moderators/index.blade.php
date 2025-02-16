@extends('base')

@section('title', 'Moderators')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Moderators</h1>

    <div class="text-end mb-3">
        <a href="{{ route('moderators.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Moderator
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Full Name</th>
                    <th>Biography</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($moderators as $index => $moderator)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($moderator->avatar)
                                <img src="{{ $moderator->avatar->getUrl() }}" alt="Avatar" class="img-thumbnail" width="50">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="No Avatar" class="img-thumbnail" width="50">
                            @endif
                        </td>
                        <td>{{ $moderator->full_name }}</td>
                        <td>{{ Str::limit($moderator->biography, 50, '...') }}</td>
                        <td>
                            <a href="{{ route('moderators.show', $moderator) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('moderators.edit', $moderator) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('moderators.destroy', $moderator) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
