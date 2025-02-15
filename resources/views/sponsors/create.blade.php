@extends('base')

@section('title', 'Ajouter un Sponsor')

@section('content')

<div class="container mt-5">
    <h1>Ajouter un Sponsor</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('sponsors.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom du Sponsor</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <input type="text" id="category" name="category" class="form-control" value="{{ old('category') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" id="logo" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="{{ route('sponsors.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

@endsection
