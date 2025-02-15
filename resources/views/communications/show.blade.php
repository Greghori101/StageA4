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

            <h5>Session du Programme</h5>
            <p>{{ $communication->programSession->name ?? 'Non attribuée' }}</p>

            <h5>Salle</h5>
            <p>{{ $communication->room->name ?? 'Non attribuée' }}</p>

            <h5>Intervenants</h5>
            @if ($communication->speakers->isNotEmpty())
                <ul>
                    @foreach ($communication->speakers as $speaker)
                        <li>{{ $speaker->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>Aucun intervenant</p>
            @endif

            <h5>Sponsors</h5>
            @if ($communication->sponsors->isNotEmpty())
                <ul>
                    @foreach ($communication->sponsors as $sponsor)
                        <li>{{ $sponsor->name }}</li>
                    @endforeach
                </ul>
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
