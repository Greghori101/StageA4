@extends('base')

@section('title', 'Create Moderator')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Create Moderator</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('moderators.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Full Name -->
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror"
                        value="{{ old('full_name') }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Biography -->
                <div class="mb-3">
                    <label for="biography" class="form-label">Biography</label>
                    <textarea name="biography" id="biography" class="form-control @error('biography') is-invalid @enderror"
                        rows="4">{{ old('biography') }}</textarea>
                    @error('biography')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Avatar -->
                <div class="mb-3">
                    <label class="form-label">Avatar</label>
                    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
                    @error('avatar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit & Cancel -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Create Moderator
                    </button>
                    <a href="{{ route('moderators.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
