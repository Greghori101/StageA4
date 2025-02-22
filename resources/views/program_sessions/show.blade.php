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

            <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$programSession->id" />

            <hr>

            <h5>Communications liées</h5>
            @if ($programSession->communications->isNotEmpty())
                <div class="row">
                    @foreach ($programSession->communications as $communication)
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('communications.show', $communication) }}">
                                            {{ $communication->title }}
                                        </a>
                                    </h5>
                                    <p><strong>Description:</strong> {{ $communication->description }}</p>
                                    <p><strong>Date:</strong> {{ $communication->date }}</p>
                                    <p><strong>Heure:</strong> {{ $communication->start_time }} - {{ $communication->end_time }}</p>
                                    <p><strong>Type:</strong> {{ $communication->type }}</p>

                                    @if ($communication->room)
                                        <p><strong>Salle:</strong> {{ $communication->room->name }}</p>
                                    @endif

                                    @if ($communication->speakers->isNotEmpty())
                                        <p><strong>Intervenants:</strong>
                                            {{ $communication->speakers->pluck('name')->join(', ') }}
                                        </p>
                                    @endif

                                    @if ($communication->sponsors->isNotEmpty())
                                        <p><strong>Sponsors:</strong>
                                            {{ $communication->sponsors->pluck('name')->join(', ') }}
                                        </p>
                                    @endif

                                    <p><strong>Questions associées:</strong> {{ $communication->questions->count() }}</p>

                                    <a href="{{ route('communications.show', $communication) }}" class="btn btn-info btn-sm">
                                        Voir plus
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Aucune communication liée à cette session.</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        @if(auth()->user()->can('create Communication'))
            <!-- Bouton pour ajouter une communication -->
            <a href="{{ route('communications.create', ['program_session_id' => $programSession->id]) }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Ajouter une communication
            </a>
        @endif

        @if(auth()->user()->can('update ProgramSession'))
            <!-- Bouton pour modifier -->
            <a href="{{ route('program_sessions.edit', $programSession) }}" class="btn btn-primary">Modifier</a>
        @endif

        @if(auth()->user()->can('delete ProgramSession'))
            <!-- Formulaire de suppression -->
            <form action="{{ route('program_sessions.destroy', $programSession) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette session ?');">
                    Supprimer
                </button>
            </form>
        @endif

        @if(auth()->user()->can('create Question'))
            <a href="{{ route('questions.create', ['session_id' => $programSession->id]) }}" class="btn btn-primary">
                Poser une question
            </a>
        @endif

        <!-- Bouton retour -->
        <a href="{{ route('program_sessions.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
@endsection
