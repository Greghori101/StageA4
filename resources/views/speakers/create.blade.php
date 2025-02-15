<!-- resources/views/speakers/create.blade.php -->

@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Speaker</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('speakers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="biography" class="form-label">Biography</label>
                    <textarea class="form-control" id="biography" name="biography" rows="4" required>{{ old('biography') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create Speaker</button>
                    <a href="{{ route('speakers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
