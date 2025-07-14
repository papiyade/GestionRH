<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Candidature reçue</title>
</head>
<body>
    <h2>Bonjour {{ $prenom }} {{ $nom }},</h2>

    <p>Nous vous remercions pour l’intérêt que vous portez à notre offre d’emploi <strong>"{{ $jobOfferTitle }}"</strong>.</p>

    <p>Votre candidature a bien été reçue et sera étudiée avec attention.</p>

    <p>Si vous ne recevez pas de réponse ou de contact de notre part dans un délai raisonnable, vous pouvez considérer que votre candidature n’a pas été retenue.</p>

    <p>Merci pour votre confiance,</p>

    <p>L’équipe {{ config('app.name') }}</p>
</body>
</html>
