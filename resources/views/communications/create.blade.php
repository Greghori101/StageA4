@extends('base')

@section('content')
<div class="container">
    <h1>Créer une Communication</h1>

    @php $communication = $communication ?? null; @endphp

    <form method="POST" action="{{ route('communications.store') }}">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Heure de début</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Heure de fin</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required>
        </div>

        <div class="mb-3">
            <label for="program_session_id" class="form-label">Session du Programme</label>
            <select class="form-select" id="program_session_id" name="program_session_id">
                <option value="">Sélectionner</option>
                @foreach($programSessions as $session)
                    <option value="{{ $session->id }}" {{ old('program_session_id') == $session->id ? 'selected' : '' }}>
                        {{ $session->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_id" class="form-label">Salle</label>
            <select class="form-select" id="room_id" name="room_id">
                <option value="">Sélectionner</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sélection des intervenants -->
        <div class="mb-3">
            <label for="speakers" class="form-label">Intervenants</label>
            <select class="form-select" id="speakers" name="speakers[]" multiple size="5">
                @foreach($speakers as $speaker)
                    <option value="{{ $speaker->id }}" {{ collect(old('speakers', []))->contains($speaker->id) ? 'selected' : '' }}>
                        {{ $speaker->full_name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Maintenez la touche <strong>CTRL</strong> (ou <strong>CMD</strong> sur Mac) pour sélectionner plusieurs intervenants.</small>
        </div>

        <!-- Sélection des sponsors -->
        <div class="mb-3">
            <label for="sponsors" class="form-label">Sponsors</label>
            <select class="form-select" id="sponsors" name="sponsors[]" multiple size="5">
                @foreach($sponsors as $sponsor)
                    <option value="{{ $sponsor->id }}" {{ collect(old('sponsors', []))->contains($sponsor->id) ? 'selected' : '' }}>
                        {{ $sponsor->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Maintenez la touche <strong>CTRL</strong> (ou <strong>CMD</strong> sur Mac) pour sélectionner plusieurs sponsors.</small>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
