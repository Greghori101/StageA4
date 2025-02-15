@extends('base')

@section('title', 'Détails de la Session')

@section('content')
<div class="container mt-5">
    <h1>Détails de la Session</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">{{ $programSession->name }}</h5>
            <p><strong>Date:</strong> {{ $programSession->date }}</p>
            <p><strong>Heure de début:</strong> {{ $programSession->start_time }}</p>
            <p><strong>Heure de fin:</strong> {{ $programSession->end_time }}</p>

            <hr>

            <h5>Communications liées</h5>
            @if ($programSession->communications->isNotEmpty())
                <ul>
                    @foreach ($programSession->communications as $communication)
                        <li>
                            <a href="{{ route('communications.show', $communication) }}">
                                {{ $communication->title }}
                            </a> - {{ $communication->date }} ({{ $communication->start_time }} - {{ $communication->end_time }})
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucune communication liée à cette session.</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <!-- Bouton pour ajouter une communication -->
        <a href="{{ route('communications.create', ['program_session_id' => $programSession->id]) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Ajouter une communication
        </a>

        <!-- Bouton pour modifier -->
        <a href="{{ route('program_sessions.edit', $programSession) }}" class="btn btn-primary">
            Modifier
        </a>

        <!-- Formulaire de suppression -->
        <form action="{{ route('program_sessions.destroy', $programSession) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette session ?');">
                Supprimer
            </button>
        </form>

        <!-- Bouton retour -->
        <a href="{{ route('program_sessions.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
@endsection
