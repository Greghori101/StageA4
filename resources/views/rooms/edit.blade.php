@extends('base')

@section('content')
<div class="container">
    <h1>Edit Room</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('rooms.update', $room) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Room Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $room->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" id="capacity" value="{{ old('capacity', $room->capacity) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $room->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Room</button>
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
