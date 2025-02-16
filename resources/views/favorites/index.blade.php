@extends('base')

@section('title', 'Mes Favoris')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Mes Favoris</h2>

    @if($favorites->isEmpty())
    <p>Aucun favori trouvé.</p>
    @else
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="favoriteTabs" role="tablist">
        @foreach($favorites as $modelType => $items)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ Str::slug($modelType) }}"
                data-bs-toggle="tab" data-bs-target="#content-{{ Str::slug($modelType) }}"
                type="button" role="tab" aria-controls="content-{{ Str::slug($modelType) }}"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                {{ class_basename($modelType) }}
            </button>
        </li>
        @endforeach
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-3" id="favoriteTabsContent">
        @foreach($favorites as $modelType => $items)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
            id="content-{{ Str::slug($modelType) }}"
            role="tabpanel" aria-labelledby="tab-{{ Str::slug($modelType) }}">

            <div class="row">
                @foreach($items as $favorite)
                @php
                $model = app($favorite->model_type)::find($favorite->model_id);
                @endphp

                @if($model)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ method_exists($model, 'getTitle') ? $model->getTitle() : class_basename($modelType) . " #" . $model->id }}
                            </h5>

                            @if($model instanceof App\Models\Communication)
                            <p>{{ $model->description }}</p>
                            <p><strong>Date:</strong> {{ $model->date }}</p>
                            <p><strong>Heure:</strong> {{ $model->start_time }} - {{ $model->end_time }}</p>

                            @elseif($model instanceof App\Models\ProgramSession)
                            <p>{{ $model->name }}</p>
                            <p><strong>Date:</strong> {{ $model->date }}</p>

                            @elseif($model instanceof App\Models\Question)
                            <p>{{ $model->content }}</p>
                            <p><strong>Réponse:</strong> {{ $model->answer ?? 'Non répondu' }}</p>

                            @elseif($model instanceof App\Models\Speaker)
                            <p><strong>Nom:</strong> {{ $model->full_name }}</p>
                            <p>{{ $model->biography }}</p>

                            @elseif($model instanceof App\Models\Sponsor)
                            <p><strong>Nom:</strong> {{ $model->name }}</p>
                            <p>{{ $model->description }}</p>

                            @endif

                            <!-- Favorite Toggle Button -->
                            <form action="{{ route('favorites.toggle', ['modelType' => $favorite->model_type, 'modelId' => $favorite->model_id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer des favoris</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
