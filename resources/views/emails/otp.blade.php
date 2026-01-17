<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Code de vérification</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f6;font-family:Arial,Helvetica,sans-serif;color:#333;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
    <tr>
        <td align="center">

            <!-- Conteneur principal -->
            <table width="600" cellpadding="0" cellspacing="0"
                   style="background:#ffffff;border-radius:8px;overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#b35c68;padding:20px;text-align:center;color:#ffffff;">
                        <h1 style="margin:0;font-size:22px;">
                            Vérification de sécurité
                        </h1>
                    </td>
                </tr>

                <!-- Contenu -->
                <tr>
                    <td style="padding:30px 25px;font-size:15px;line-height:1.6;">

                        <p>Bonjour,</p>

                        <p>
                            Pour accéder à la page sécurisée, veuillez utiliser le code de vérification ci-dessous :
                        </p>

                        <!-- OTP -->
                        <div style="
                            background:#f9f0f1;
                            border:1px dashed #b35c68;
                            padding:20px;
                            text-align:center;
                            margin:25px 0;
                            border-radius:6px;
                        ">
                            <span style="
                                font-size:32px;
                                font-weight:bold;
                                letter-spacing:6px;
                                color:#b35c68;
                            ">
                                {{ $otp }}
                            </span>
                        </div>

                        <p style="color:#555;">
                            ⏱️ Ce code est valable pendant <strong>5 minutes</strong>.
                        </p>

                        <p style="font-size:14px;color:#777;">
                            Si vous n’êtes pas à l’origine de cette demande, veuillez ignorer cet email.
                            Aucune action ne sera effectuée sans ce code.
                        </p>

                        <p style="margin-bottom:0;">
                            Cordialement,<br>
                            <strong>L’équipe RH</strong>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#fafafa;padding:15px;text-align:center;font-size:12px;color:#888;">
                        © {{ date('Y') }} — Service RH<br>
                        Email automatique, merci de ne pas répondre
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
