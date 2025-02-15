@extends('base')

@section('title', 'Gestion des Sessions')

@section('content')

<div class="container mt-5">
    <h1>Gestion des Sessions</h1>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('program_sessions.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou date" value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </div>
    </form>

    <!-- Bouton pour ajouter une nouvelle session -->
    <a href="{{ route('program_sessions.create') }}" class="btn btn-primary mb-3">Ajouter une session</a>

    <!-- Table des sessions -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Date</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Communications</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sessions as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->name }}</td>
                    <td>{{ $session->date }}</td>
                    <td>{{ $session->start_time }}</td>
                    <td>{{ $session->end_time }}</td>
                    <td>
                        @if ($session->communications->isNotEmpty())
                            <ul>
                                @foreach ($session->communications as $communication)
                                    <li>
                                        <a href="{{ route('communications.show', $communication->id) }}">
                                            {{ $communication->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Aucune</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('program_sessions.show', $session->id) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('program_sessions.edit', $session->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="{{ route('program_sessions.destroy', $session->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette session ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $sessions->links() }}
    </div>
</div>

@endsection
