@extends('base')

@section('title', __('interface.edit_session'))

@section('content')

<div class="container mt-5">
    <h1>{{ __('interface.edit_session') }}</h1>

    <!-- Message d'erreur -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de modification -->
    <form method="POST" action="{{ route('program_sessions.update', $session->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('interface.session_name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $session->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">{{ __('interface.date') }}</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $session->date) }}" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">{{ __('interface.start_time') }}</label>
            <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $session->start_time) }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">{{ __('interface.end_time') }}</label>
            <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $session->end_time) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('interface.update') }}</button>
        <a href="{{ route('program_sessions.index') }}" class="btn btn-secondary">{{ __('interface.cancel') }}</a>
    </form>
</div>

@endsection
