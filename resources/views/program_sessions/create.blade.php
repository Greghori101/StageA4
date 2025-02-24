@extends('base')

@section('title', __('interface.create_new_session'))

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">{{ __('interface.create_new_session') }}</h1>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Session Creation Form -->
    <form method="POST" action="{{ route('program_sessions.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <!-- Session Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('interface.session_name') }}</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label">{{ __('interface.date') }}</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}" required>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Start Time -->
                <div class="mb-3">
                    <label for="start_time" class="form-label">{{ __('interface.start_time') }}</label>
                    <input type="time" id="start_time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                </div>

                <!-- End Time -->
                <div class="mb-3">
                    <label for="end_time" class="form-label">{{ __('interface.end_time') }}</label>
                    <input type="time" id="end_time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                </div>
            </div>
        </div>

        <!-- Moderators Selection -->
        <div class="mb-3">
            <label for="users" class="form-label">{{ __('interface.moderators') }}</label>
            <select class="form-select" id="users" name="users[]" multiple size="5">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ collect(old('users', []))->contains($user->id) ? 'selected' : '' }}>
                        {{ $user->full_name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">{{ __('interface.multi_select_hint') }}</small>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">{{ __('interface.create') }}</button>
            <a href="{{ route('program_sessions.index') }}" class="btn btn-secondary">{{ __('interface.cancel') }}</a>
        </div>
    </form>
</div>

@endsection
