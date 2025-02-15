@extends('base')

@section('title', 'Ajouter une Question')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Ajouter une Question</h2>

    <div class="card shadow p-4">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf

            <!-- Contenu de la question -->
            <div class="mb-3">
                <label for="content" class="form-label">Contenu de la question</label>
                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="3" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sélection de l'utilisateur -->
            <div class="mb-3">
                <label for="user_id" class="form-label">Utilisateur</label>
                <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                    <option value="">-- Sélectionner un utilisateur --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sélection de la communication -->
            <div class="mb-3">
                <label for="communication_id" class="form-label">Communication</label>
                <select id="communication_id" name="communication_id" class="form-select @error('communication_id') is-invalid @enderror">
                    <option value="">-- Sélectionner une communication --</option>
                    @foreach ($communications as $communication)
                        <option value="{{ $communication->id }}" {{ old('communication_id') == $communication->id ? 'selected' : '' }}>
                            {{ $communication->title }}
                        </option>
                    @endforeach
                </select>
                @error('communication_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sélection de l'orateur -->
            <div class="mb-3">
                <label for="speaker_id" class="form-label">Orateur (Facultatif)</label>
                <select id="speaker_id" name="speaker_id" class="form-select @error('speaker_id') is-invalid @enderror">
                    <option value="">-- Sélectionner un orateur --</option>
                    @foreach ($speakers as $speaker)
                        <option value="{{ $speaker->id }}" {{ old('speaker_id') == $speaker->id ? 'selected' : '' }}>
                            {{ $speaker->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('speaker_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bouton de soumission -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Enregistrer la Question
                </button>
                <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
