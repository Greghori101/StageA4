@extends('base')

@section('title', 'Modifier Utilisateur')

@section('content')

<h1>Bonjour {{ $user->full_name }},</h1>
<p>Votre compte a déjà été vérifié. ✅</p>

<a href="{{ route('users.index') }}" style="display: inline-block; padding: 10px 15px; background: blue; color: white; text-decoration: none; border-radius: 5px;">
    Retour à la liste des utilisateurs
</a>

@endsection
