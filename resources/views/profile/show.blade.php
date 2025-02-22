@extends('base')

@section('title', 'Mon Profil')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Mon Profil</h2>

    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ $user->avatar ? $user->avatar->getUrl() : asset('images/default-avatar.png') }}"
                     class="rounded-circle"
                     width="150" height="150"
                     alt="Avatar">
            </div>

            <h4 class="text-center mt-3">{{ $user->full_name }}</h4>
            <p class="text-center">{{ $user->job_title ?? 'Aucune fonction spécifiée' }}</p>

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Institution:</strong> {{ $user->institution ?? 'Non renseigné' }}</li>
                <li class="list-group-item"><strong>Adresse:</strong> {{ $user->address ?? 'Non renseigné' }}</li>
                <li class="list-group-item"><strong>Pays:</strong> {{ $user->country ?? 'Non renseigné' }}</li>
                <li class="list-group-item"><strong>État/Région:</strong> {{ $user->state ?? 'Non renseigné' }}</li>
            </ul>

            <div class="text-center mt-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier le profil</a>
            </div>
        </div>
    </div>
</div>
@endsection
