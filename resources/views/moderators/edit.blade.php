@extends('base')

@section('title', 'Edit Moderator')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Edit Moderator</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('moderators.update', $moderator) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Full Name -->
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror"
                        value="{{ old('full_name', $moderator->full_name) }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Biography -->
                <div class="mb-3">
                    <label for="biography" class="form-label">Biography</label>
                    <textarea name="biography" id="biography" class="form-control @error('biography') is-invalid @enderror"
                        rows="4">{{ old('biography', $moderator->biography) }}</textarea>
                    @error('biography')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Avatar -->
                <div class="mb-3">
                    <label class="form-label">Avatar</label>
                    <div class="d-flex align-items-center">
                        @if ($moderator->avatar)
                            <img src="{{ $moderator->avatar->getUrl() }}" alt="Avatar" class="img-thumbnail me-3" width="80">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="No Avatar" class="img-thumbnail me-3" width="80">
                        @endif
                        <input type="file" name="avatar" class="form-control">
                    </div>
                    @error('avatar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit & Cancel -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
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
