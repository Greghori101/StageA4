<!-- resources/views/speakers/edit.blade.php -->

@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Speaker</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('speakers.update', $speaker) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $speaker->full_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="biography" class="form-label">Biography</label>
                    <textarea class="form-control" id="biography" name="biography" rows="4" required>{{ old('biography', $speaker->biography) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                    @if($speaker->avatar)
                        <div class="mt-2">
                            <img src="{{ $speaker->avatar->getUrl() }}" alt="Avatar" class="img-thumbnail" width="150">
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('speakers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
