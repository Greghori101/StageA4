@extends('base')

@section('title', __('interface.manage_sessions'))

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">{{ __('interface.manage_sessions') }}</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <form method="GET" action="{{ route('program_sessions.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ __('interface.search_by_name_or_date') }}" value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> {{ __('interface.search') }}
            </button>
        </div>
    </form>

    <!-- Add New Session (Admin Only) -->
    @can('create', App\Models\ProgramSession::class)
        <a href="{{ route('program_sessions.create') }}" class="btn btn-primary mb-3">
            {{ __('interface.add_session') }}
        </a>
    @endcan

    @if(auth()->user()?->hasRole('admin'))
        <!-- Admin Table View -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('interface.name') }}</th>
                        <th>{{ __('interface.date') }}</th>
                        <th>{{ __('interface.start_time') }}</th>
                        <th>{{ __('interface.end_time') }}</th>
                        <th>{{ __('interface.communications') }}</th>
                        <th>{{ __('interface.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessions as $session)
                    <tr>
                        <td>{{ $session->id }}</td>
                        <td>{{ $session->name }}</td>
                        <td>{{ $session->date }}</td>
                        <td>{{ $session->start_time }}</td>
                        <td>{{ $session->end_time }}</td>
                        <td>
                            @if ($session->communications->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach ($session->communications as $communication)
                                        <li>
                                            <a href="{{ route('communications.show', $communication->id) }}">
                                                {{ $communication->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">{{ __('interface.none') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @can('create', App\Models\Favorite::class)
                                    <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$session->id" />
                                @endcan

                                <a href="{{ route('program_sessions.show', $session->id) }}" class="btn btn-info btn-sm">{{ __('interface.view') }}</a>

                                @can('update', $session)
                                    <a href="{{ route('program_sessions.edit', $session->id) }}" class="btn btn-warning btn-sm">{{ __('interface.edit') }}</a>
                                @endcan

                                @can('delete', $session)
                                    <form action="{{ route('program_sessions.destroy', $session->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('interface.delete_session_confirmation') }}')">
                                            {{ __('interface.delete') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <!-- Card View for Moderators & Visitors -->
        <div class="row">
            @foreach ($sessions as $session)
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $session->name }}</h5>
                            <p class="card-text">
                                <strong>{{ __('interface.date') }}:</strong> {{ $session->date }} <br>
                                <strong>{{ __('interface.time') }}:</strong> {{ $session->start_time }} - {{ $session->end_time }}
                            </p>

                            @can('create', App\Models\Favorite::class)
                                <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$session->id" />
                            @endcan

                            <a href="{{ route('program_sessions.show', $session->id) }}" class="btn btn-info btn-sm">{{ __('interface.view') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-3">
        {{ $sessions->links() }}
    </div>
</div>

@endsection
