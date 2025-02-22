@extends('base')

@section('title', 'Modifier Utilisateur')

@section('content')
<h1>Erreur ❌</h1>
<p>{{ $message }}</p>

<a href="{{ route('users.index') }}" style="display: inline-block; padding: 10px 15px; background: red; color: white; text-decoration: none; border-radius: 5px;">
    Retour à la liste des utilisateurs
</a>
@endsection
