@extends('base')

@section('title', 'Mes Favoris')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Mes Favoris</h2>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="favoriteTabs" role="tablist">
        @foreach($favorites as $modelType => $items)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ Str::slug($modelType) }}"
                        data-bs-toggle="tab" data-bs-target="#content-{{ Str::slug($modelType) }}"
                        type="button" role="tab" aria-controls="content-{{ Str::slug($modelType) }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ ucfirst(class_basename($modelType)) }}
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

                <ul class="list-group">
                    @foreach($items as $favorite)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $favorite->model_type }} - ID: {{ $favorite->model_id }}
                            <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </li>
                    @endforeach
                </ul>

            </div>
        @endforeach
    </div>
</div>
@endsection
