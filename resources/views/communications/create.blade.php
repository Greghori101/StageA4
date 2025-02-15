@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Communication</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('communications.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                </div>

                <div class="mb-3">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                </div>

                <div class="mb-3">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="lecture" {{ old('type') == 'lecture' ? 'selected' : '' }}>Lecture</option>
                        <option value="panel" {{ old('type') == 'panel' ? 'selected' : '' }}>Panel</option>
                        <option value="workshop" {{ old('type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="program_session_id" class="form-label">Program Session</label>
                    <select class="form-control" id="program_session_id" name="program_session_id">
                        <option value="">-- Select Session --</option>
                        @foreach ($programSessions as $session)
                            <option value="{{ $session->id }}" {{ old('program_session_id') == $session->id ? 'selected' : '' }}>
                                {{ $session->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="room_id" class="form-label">Room</label>
                    <select class="form-control" id="room_id" name="room_id">
                        <option value="">-- Select Room --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="speakers" class="form-label">Speakers</label>
                    <select class="form-control" id="speakers" name="speakers[]" multiple>
                        @foreach ($speakers as $speaker)
                            <option value="{{ $speaker->id }}" {{ in_array($speaker->id, old('speakers', [])) ? 'selected' : '' }}>
                                {{ $speaker->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sponsors" class="form-label">Sponsors</label>
                    <select class="form-control" id="sponsors" name="sponsors[]" multiple>
                        @foreach ($sponsors as $sponsor)
                            <option value="{{ $sponsor->id }}" {{ in_array($sponsor->id, old('sponsors', [])) ? 'selected' : '' }}>
                                {{ $sponsor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Create Communication</button>
                <a href="{{ route('communications.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
