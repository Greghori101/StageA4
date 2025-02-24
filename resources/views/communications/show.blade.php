@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $communication->title }}</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ __('interface.communication_details') }}</h5>

            <p><strong>{{ __('interface.description') }}:</strong> {{ $communication->description ?? __('interface.no_description') }}</p>
            <p><strong>{{ __('interface.date') }}:</strong> {{ $communication->date }}</p>
            <p><strong>{{ __('interface.start_time') }}:</strong> {{ $communication->start_time }}</p>
            <p><strong>{{ __('interface.end_time') }}:</strong> {{ $communication->end_time }}</p>
            <p><strong>{{ __('interface.type') }}:</strong> {{ ucfirst($communication->type) }}</p>

            <hr>

            <!-- Program Session -->
            <h5>{{ __('interface.program_session') }}</h5>
            <p>
                @if ($communication->programSession)
                    <a href="{{ route('program_sessions.show', $communication->programSession) }}">
                        {{ $communication->programSession->name }}
                    </a>
                @else
                    {{ __('interface.not_assigned') }}
                @endif
            </p>

            <!-- Room -->
            <h5>{{ __('interface.room') }}</h5>
            <p>
                @if ($communication->room)
                    <a href="{{ route('rooms.show', $communication->room) }}">
                        {{ $communication->room->name }}
                    </a>
                @else
                    {{ __('interface.not_assigned') }}
                @endif
            </p>

            <hr>

            <!-- Speakers -->
            <h5>{{ __('interface.speakers') }}</h5>
            @if ($communication->speakers->isNotEmpty())
                <div class="row text-center">
                    @foreach ($communication->speakers as $speaker)
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('speakers.show', $speaker) }}">
                                <img src="{{ $speaker->avatar?->original_url }}" alt="{{ $speaker->full_name }}" class="rounded-circle img-fluid" style="width: 80px; height: 80px;">
                                <p class="mt-2">{{ $speaker->full_name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>{{ __('interface.no_speakers') }}</p>
            @endif

            <hr>

            <!-- Sponsors -->
            <h5>{{ __('interface.sponsors') }}</h5>
            @if ($communication->sponsors->isNotEmpty())
                <div class="row text-center">
                    @foreach ($communication->sponsors as $sponsor)
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('sponsors.show', $sponsor) }}">
                                <img src="{{ $sponsor->logo?->original_url }}" alt="{{ $sponsor->name }}" class="img-fluid" style="max-height: 60px;">
                                <p class="mt-2">{{ $sponsor->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>{{ __('interface.no_sponsors') }}</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        @can('update Communication')
            <a href="{{ route('communications.edit', $communication) }}" class="btn btn-primary">{{ __('interface.edit') }}</a>
        @endcan

        @can('delete Communication')
            <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('interface.delete_confirmation') }}');">
                    {{ __('interface.delete') }}
                </button>
            </form>
        @endcan

        <a href="{{ route('communications.index') }}" class="btn btn-secondary">{{ __('interface.back') }}</a>
    </div>
</div>
@endsection
