@extends('base')

@section('content')
<div class="container">
    <h1>{{ $communication->title }}</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Détails de la Communication</h5>

            <p><strong>Description:</strong> {{ $communication->description ?? 'Aucune description' }}</p>
            <p><strong>Date:</strong> {{ $communication->date }}</p>
            <p><strong>Heure de début:</strong> {{ $communication->start_time }}</p>
            <p><strong>Heure de fin:</strong> {{ $communication->end_time }}</p>
            <p><strong>Type:</strong> {{ $communication->type }}</p>

            <hr>

            <!-- Program Session -->
            <h5>Session du Programme</h5>
            @if ($communication->programSession)
                <p>
                    <a href="{{ route('program_sessions.show', $communication->programSession) }}">
                        {{ $communication->programSession->name }}
                    </a>
                </p>
            @else
                <p>Non attribuée</p>
            @endif

            <!-- Room -->
            <h5>Salle</h5>
            @if ($communication->room)
                <p>
                    <a href="{{ route('rooms.show', $communication->room) }}">
                        {{ $communication->room->name }}
                    </a>
                </p>
            @else
                <p>Non attribuée</p>
            @endif

            <hr>

            <!-- Speakers -->
            <h5>Intervenants</h5>
            @if ($communication->speakers->isNotEmpty())
                <div class="row">
                    @foreach ($communication->speakers as $speaker)
                        <div class="col-md-4 text-center">
                            <a href="{{ route('speakers.show', $speaker) }}">
                                <img src="{{ $speaker->avatar->original_url }}" alt="{{ $speaker->full_name }}" class="rounded-circle img-fluid" style="width: 80px; height: 80px;">
                                <p>{{ $speaker->full_name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Aucun intervenant</p>
            @endif

            <hr>

            <!-- Sponsors -->
            <h5>Sponsors</h5>
            @if ($communication->sponsors->isNotEmpty())
                <div class="row">
                    @foreach ($communication->sponsors as $sponsor)
                        <div class="col-md-4 text-center">
                            <a href="{{ route('sponsors.show', $sponsor) }}">
                                <img src="{{ $sponsor->logo->original_url }}" alt="{{ $sponsor->name }}" class="img-fluid" style="max-height: 60px;">
                                <p>{{ $sponsor->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Aucun sponsor</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('communications.edit', $communication) }}" class="btn btn-primary">Modifier</a>
        <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette communication ?');">Supprimer</button>
        </form>
        <a href="{{ route('communications.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
@endsection
