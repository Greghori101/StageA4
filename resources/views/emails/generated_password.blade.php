<!DOCTYPE html>
<html>
<head>
    <title>Votre compte a été créé</title>
</head>
<body>
    <p>Bonjour {{ $user->full_name }},</p>

    <p>Votre compte a été créé avec succès. Voici vos identifiants :</p>

    <p><strong>Email :</strong> {{ $user->email }}</p>
    <p><strong>Mot de passe :</strong> {{ $password }}</p>

    <p>Nous vous recommandons de changer votre mot de passe après connexion.</p>

    <p>Cordialement,</p>
    <p>L'équipe</p>
</body>
</html>
