@extends('base')

@section('title', 'Gestion des Sponsors')

@section('content')

<div class="container mt-5">
    <h1>Gestion des Sponsors</h1>

    <!-- Message de succès -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('sponsors.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher un sponsor..." value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </div>
    </form>

    <!-- Bouton pour ajouter un sponsor -->
    <a href="{{ route('sponsors.create') }}" class="btn btn-primary mb-3">Ajouter un Sponsor</a>

    <!-- Table des sponsors -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Description</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sponsors as $sponsor)
            <tr>
                <td>{{ $sponsor->id }}</td>
                <td>{{ $sponsor->name }}</td>
                <td>{{ $sponsor->category ?? 'N/A' }}</td>
                <td>{{ $sponsor->description ?? 'N/A' }}</td>
                <td>
                    @if ($sponsor->logo)
                    <img src="{{ $sponsor->logo->getUrl() }}" alt="Logo" width="50">
                    @else
                    <span>Aucun logo</span>
                    @endif
                </td>
                <td>
                    <x-favorite-button modelType="App\Models\Sponsor" :modelId="$sponsor->id" />
                    <!-- Lien pour modifier -->
                    <a href="{{ route('sponsors.edit', $sponsor->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                    <!-- Formulaire pour supprimer -->
                    <form action="{{ route('sponsors.destroy', $sponsor->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce sponsor ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $sponsors->links() }}
    </div>
</div>

@endsection
