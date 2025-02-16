@extends('base')

@section('title', 'Poser une Question')

@section('content')
<div class="container mt-5">
    <div class="mb-4 text-center">
        <h1 class="text-white p-3" style="background-color: #56B947; border-radius: 10px;">Poser une Question</h1>
    </div>

    <div class="card shadow p-4">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf

            <!-- Contenu de la Question -->
            <div class="mb-3">
                <label for="content" class="form-label"><strong>Votre Question</strong></label>
                <textarea id="content" name="content" class="form-control" rows="3" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sélection de la Communication -->
            <div class="mb-3">
                <label for="communication_id" class="form-label"><strong>Communication liée</strong></label>
                <select id="communication_id" name="communication_id" class="form-control" required>
                    <option value="">Sélectionnez une communication</option>
                    @foreach($communications as $communication)
                        <option value="{{ $communication->id }}" {{ old('communication_id') == $communication->id ? 'selected' : '' }}>
                            {{ $communication->title }}
                        </option>
                    @endforeach
                </select>
                @error('communication_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sélection de l'Orateur (Facultatif) -->
            <div class="mb-3">
                <label for="speaker_id" class="form-label"><strong>Orateur (optionnel)</strong></label>
                <select id="speaker_id" name="speaker_id" class="form-control">
                    <option value="">Aucun orateur</option>
                    @foreach($speakers as $speaker)
                        <option value="{{ $speaker->id }}" {{ old('speaker_id') == $speaker->id ? 'selected' : '' }}>
                            {{ $speaker->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Boutons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('questions.index') }}" class="btn btn-secondary">Retour</a>
                <button type="submit" class="btn btn-success">Soumettre la Question</button>
            </div>
        </form>
    </div>
</div>
@endsection
