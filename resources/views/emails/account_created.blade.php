<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue chez {{ config('app.name') }}</title>
    <style>
        /* Reset simple pour email */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f6;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        /* Conteneur principal */
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* En-tête */
        .email-header {
            background-color: #b35c68; /* ton rosâtre foncé */
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Contenu */
        .email-body {
            padding: 30px 25px;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .email-body h2 {
            color: #b35c68;
        }

        .credentials {
            background-color: #f9f0f1;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .credentials li {
            margin-bottom: 8px;
        }

        /* Bouton */
        .btn-login {
            display: inline-block;
            padding: 12px 20px;
            background-color: #b35c68;
            color: #fff !important;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Footer */
        .email-footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            padding: 20px;
            border-top: 1px solid #eee;
        }

        @media screen and (max-width: 620px) {
            .email-container {
                margin: 20px;
            }

            .email-body {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">

        <!-- Header -->
        <div class="email-header">
            <h1>Bienvenue chez {{ config('app.name') }} !</h1>
        </div>

        <!-- Corps -->
        <div class="email-body">
            <h2>Bonjour {{ $name }},</h2>

            <p>Votre compte a été créé avec succès. Vous pouvez dès à présent vous connecter et profiter de nos services.</p>

            <!-- Identifiants -->
            <div class="credentials">
                <p><strong>Vos identifiants :</strong></p>
                <ul>
                    <li><strong>Email :</strong> {{ $email }}</li>
                    <li><strong>Mot de passe :</strong> {{ $password }}</li>
                </ul>
            </div>

            <!-- Bouton -->
            <p style="text-align:center;">
                <a href="{{ route('login') }}" class="btn-login">Se connecter</a>
            </p>

            <p>Pour votre sécurité, pensez à changer votre mot de passe après votre première connexion.</p>

            <p>Merci,<br>L’équipe <strong>{{ config('app.name') }}</strong></p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>
