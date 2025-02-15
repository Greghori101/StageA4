@extends('base')

@section('title', 'Gestion des Utilisateurs')

@section('content')

<div class="container mt-5">
    <h1>Gestion des Utilisateurs</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou email" value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </div>
    </form>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Ajouter un utilisateur</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Institution</th>
                <th>Adresse</th>
                <th>État</th>
                <th>Pays</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->institution ?? 'N/A' }}</td>
                    <td>{{ $user->address ?? 'N/A' }}</td>
                    <td>{{ $user->state }}</td>
                    <td>{{ $user->country }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>

@endsection
