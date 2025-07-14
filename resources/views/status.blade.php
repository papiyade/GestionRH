<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Restreint - Entreprise inactive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2gFLSABXhYhQihjDoKchc3lo4X/DnsW3YvfgRHzcwpU3A/gfKzLdbrJ0uxw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #e0e4eb 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }
        .restriction-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            border-top: 5px solid #dc3545; /* Red accent */
            position: relative;
            overflow: hidden;
        }
        .restriction-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 20px;
            animation: bounceIn 0.8s ease-out;
        }
        .restriction-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 15px;
        }
        .restriction-message {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-contact {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-contact:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            color: white; /* Keep text white on hover */
        }
        .footer-note {
            margin-top: 30px;
            font-size: 0.85rem;
            color: #adb5bd;
        }

        /* Animations */
        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="restriction-container">
        <div class="restriction-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h1 class="restriction-title">Accès Restreint</h1>
        <p class="restriction-message">
            Votre entreprise,  est actuellement **inactive**.
            Cela signifie que certaines fonctionnalités ou l'accès public à votre profil peuvent être restreints.
            Veuillez contacter l'administrateur pour plus d'informations ou pour résoudre cette situation.
        </p>
        <a href="mailto:admin@votreentreprise.com" class="btn-contact">
            <i class="fas fa-headset me-2"></i> Contacter l'administrateur
        </a>
        <p class="footer-note">
            Merci de votre compréhension.
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>