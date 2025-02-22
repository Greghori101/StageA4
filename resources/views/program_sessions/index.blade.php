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

    <!-- Bouton pour ajouter une nouvelle session (Admin uniquement) -->
    @if(auth()->user()->can('create ProgramSession'))
        <a href="{{ route('program_sessions.create') }}" class="btn btn-primary mb-3">Ajouter une session</a>
    @endif

    @if(auth()->user()?->hasRole('admin'))
        <!-- Table pour les Admins -->
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
                        <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$session->id" />
                        <a href="{{ route('program_sessions.show', $session->id) }}" class="btn btn-info btn-sm">Voir</a>

                        @if(auth()->user()->can('update ProgramSession'))
                            <a href="{{ route('program_sessions.edit', $session->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endif

                        @if(auth()->user()->can('delete ProgramSession'))
                            <form action="{{ route('program_sessions.destroy', $session->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette session ?')">Supprimer</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <!-- Affichage en cartes pour Modérateurs et Visiteurs -->
        <div class="row">
            @foreach ($sessions as $session)
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $session->name }}</h5>
                        <p class="card-text"><strong>Date :</strong> {{ $session->date }}</p>
                        <p class="card-text"><strong>Heure :</strong> {{ $session->start_time }} - {{ $session->end_time }}</p>

                        <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$session->id" />

                        <a href="{{ route('program_sessions.show', $session->id) }}" class="btn btn-info btn-sm">Voir</a>

                        @if(auth()->user()->can('create Question'))
                            <a href="{{ route('questions.create', ['session_id' => $session->id]) }}" class="btn btn-primary btn-sm">Poser une question</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-3">
        {{ $sessions->links() }}
    </div>
</div>

@endsection
