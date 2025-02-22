@extends('base')

@section('title', __('interface.add_sponsor'))

@section('content')

<div class="container mt-5">
    <h1>{{ __('interface.add_sponsor') }}</h1>

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
            <label for="name" class="form-label">{{ __('interface.sponsor_name') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">{{ __('interface.category') }}</label>
            <input type="text" id="category" name="category" class="form-control" value="{{ old('category') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('interface.description') }}</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">{{ __('interface.logo') }}</label>
            <input type="file" id="logo" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('interface.add') }}</button>
        <a href="{{ route('sponsors.index') }}" class="btn btn-secondary">{{ __('interface.cancel') }}</a>
    </form>
</div>

@endsection
