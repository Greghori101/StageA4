@extends('base')

@section('title', 'Modifier la Session')

@section('content')

<div class="container mt-5">
    <h1>Modifier la Session</h1>

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
            <label for="name" class="form-label">Nom de la Session</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $session->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $session->date) }}" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Heure de Début</label>
            <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $session->start_time) }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Heure de Fin</label>
            <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $session->end_time) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
        <a href="{{ route('program_sessions.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

@endsection
