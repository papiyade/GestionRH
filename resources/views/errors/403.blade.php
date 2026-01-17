{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farlu | 403 - Accès Non Autorisé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #AE3D7D 0%, #902e65 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-container {
            text-align: center;
            color: white;
            padding: 2rem;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            line-height: 1;
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .error-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .error-title {
            font-size: 32px;
            font-weight: 600;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-home {
            background: white;
            color: #e8571e;
            border: none;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: #902e65;
        }

        .btn-back {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-left: 15px;
        }

        .btn-back:hover {
            background: white;
            color: #902e65;
            transform: translateY(-2px);
        }

        .lock-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .details {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            backdrop-filter: blur(10px);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .details-title {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .details-content {
            font-size: 16px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="lock-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="white" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
            </svg>
        </div>

        <div class="error-code">403</div>
        
        <h1 class="error-title">Accès Non Autorisé</h1>
        
        <p class="error-message">
            Désolé, vous n'avez pas les permissions nécessaires pour accéder à cette page.
        </p>

        @if(isset($exception) && $exception->getMessage())
            <div class="details">
                <div class="details-title">Raison :</div>
                <div class="details-content">{{ $exception->getMessage() }}</div>
            </div>
        @endif

        <div style="margin-top: 40px;">
            <a href="{{ route('admin_simple') }}" class="btn-home">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="vertical-align: -2px; margin-right: 8px;" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                </svg>
                Retour au Tableau de Bord
            </a>
            <a href="javascript:history.back()" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="vertical-align: -2px; margin-right: 8px;" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Retour
            </a>
        </div>

        @auth
            <div style="margin-top: 40px; font-size: 14px; opacity: 0.7;">
                Connecté en tant que : <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }})
            </div>
        @endauth
    </div>
</body>
</html>