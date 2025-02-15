@extends('base')

@section('title', 'Questions')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Liste des Questions</h2>

    <div class="text-end mb-3">
        <a href="{{ route('questions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une Question
        </a>
    </div>

    @if ($questions->isEmpty())
        <div class="alert alert-warning text-center">Aucune question disponible.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Contenu</th>
                        <th>Réponse</th>
                        <th>Utilisateur</th>
                        <th>Communication</th>
                        <th>Orateur</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <td class="text-center">{{ $question->id }}</td>
                            <td>{{ Str::limit($question->content, 50) }}</td>
                            <td>{{ $question->answer ?? 'Pas encore répondu' }}</td>
                            <td>{{ $question->user->full_name ?? 'Utilisateur inconnu' }}</td>
                            <td>{{ $question->communication->title ?? 'Non assignée' }}</td>
                            <td>{{ $question->speaker->full_name ?? 'Non assigné' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $question->status === 'answered' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($question->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('questions.show', $question->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous supprimer cette question ?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
