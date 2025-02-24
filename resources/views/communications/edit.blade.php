@extends('base')

@section('content')
<div class="container">
    <h1>{{ __('interface.edit_communication') }}</h1>

    @php $communication = $communication ?? new \App\Models\Communication; @endphp

    <form method="POST" action="{{ route('communications.update', $communication) }}">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">{{ __('interface.title') }}</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $communication->title) }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">{{ __('interface.description') }}</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $communication->description) }}</textarea>
        </div>

        <div class="row">
            <!-- Date -->
            <div class="col-md-4 mb-3">
                <label for="date" class="form-label">{{ __('interface.date') }}</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $communication->date) }}" required>
            </div>

            <!-- Start Time -->
            <div class="col-md-4 mb-3">
                <label for="start_time" class="form-label">{{ __('interface.start_time') }}</label>
                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $communication->start_time) }}" required>
            </div>

            <!-- End Time -->
            <div class="col-md-4 mb-3">
                <label for="end_time" class="form-label">{{ __('interface.end_time') }}</label>
                <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', $communication->end_time) }}" required>
            </div>
        </div>

        <!-- Type -->
        <div class="mb-3">
            <label for="type" class="form-label">{{ __('interface.type') }}</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ old('type', $communication->type) }}" required>
        </div>

        <div class="row">
            <!-- Program Session -->
            <div class="col-md-6 mb-3">
                <label for="program_session_id" class="form-label">{{ __('interface.program_session') }}</label>
                <select class="form-select" id="program_session_id" name="program_session_id">
                    <option value="">{{ __('interface.select') }}</option>
                    @foreach($programSessions as $session)
                        <option value="{{ $session->id }}" {{ old('program_session_id', $communication->program_session_id) == $session->id ? 'selected' : '' }}>
                            {{ $session->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Room -->
            <div class="col-md-6 mb-3">
                <label for="room_id" class="form-label">{{ __('interface.room') }}</label>
                <select class="form-select" id="room_id" name="room_id">
                    <option value="">{{ __('interface.select') }}</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $communication->room_id) == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Speakers -->
            <div class="col-md-6 mb-3">
                <label for="speakers" class="form-label">{{ __('interface.speakers') }}</label>
                <select class="form-select" id="speakers" name="speakers[]" multiple>
                    @foreach($speakers as $speaker)
                        <option value="{{ $speaker->id }}" 
                            {{ collect(old('speakers', $communication->speakers->pluck('id')))->contains($speaker->id) ? 'selected' : '' }}>
                            {{ $speaker->full_name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">{{ __('interface.multi_select_hint') }}</small>
            </div>

            <!-- Sponsors -->
            <div class="col-md-6 mb-3">
                <label for="sponsors" class="form-label">{{ __('interface.sponsors') }}</label>
                <select class="form-select" id="sponsors" name="sponsors[]" multiple>
                    @foreach($sponsors as $sponsor)
                        <option value="{{ $sponsor->id }}" 
                            {{ collect(old('sponsors', $communication->sponsors->pluck('id')))->contains($sponsor->id) ? 'selected' : '' }}>
                            {{ $sponsor->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">{{ __('interface.multi_select_hint') }}</small>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary w-50">{{ __('interface.update') }}</button>
        </div>
    </form>
</div>
@endsection
