@extends('base')

@section('title', __('interface.ask_question'))

@section('content')
<div class="container mt-5">
    <div class="mb-4 text-center">
        <h1 class="text-white p-3" style="background-color: #56B947; border-radius: 10px;">
            {{ __('interface.ask_question') }}
        </h1>
    </div>

    <div class="card shadow p-4">
        <!-- Communication Selection Form -->
        <form action="{{ route('questions.create') }}" method="GET">
            <div class="mb-3">
                <label for="communication_id" class="form-label"><strong>{{ __('interface.related_communication') }}</strong></label>
                <select id="communication_id" name="communication_id" class="form-control" required onchange="this.form.submit()">
                    <option value="">{{ __('interface.select_communication') }}</option>
                    @foreach($communications as $communication)
                        <option value="{{ $communication->id }}" 
                            {{ (request('communication_id') == $communication->id) ? 'selected' : '' }}>
                            {{ $communication->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Main Question Submission Form -->
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="communication_id" value="{{ request('communication_id') ?? old('communication_id') }}">

            <!-- Question Content -->
            <div class="mb-3">
                <label for="content" class="form-label"><strong>{{ __('interface.your_question') }}</strong></label>
                <textarea id="content" name="content" class="form-control" rows="3" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Speaker Selection (Optional) -->
            <div class="mb-3">
                <label for="speaker_id" class="form-label"><strong>{{ __('interface.speaker_optional') }}</strong></label>
                <select id="speaker_id" name="speaker_id" class="form-control">
                    <option value="">{{ __('interface.no_speaker') }}</option>
                    @foreach($speakers as $speaker)
                        <option value="{{ $speaker->id }}" 
                            {{ old('speaker_id') == $speaker->id ? 'selected' : '' }}>
                            {{ $speaker->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('questions.index') }}" class="btn btn-secondary">{{ __('interface.back') }}</a>
                <button type="submit" class="btn btn-success">{{ __('interface.submit_question') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
