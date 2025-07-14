<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
</head>
<body>
    <h2>Bonjour {{ $name }},</h2>

    <p>Votre compte a été créé avec succès. Voici vos identifiants :</p>

    <ul>
        <li><strong>Email :</strong> {{ $email }}</li>
        <li><strong>Mot de passe :</strong> {{ $password }}</li>
    </ul>

    <p>Connectez-vous et pensez à modifier votre mot de passe dès que possible.</p>

    <p>Merci,<br>L’équipe {{ config('app.name') }}</p>
</body>
</html>
