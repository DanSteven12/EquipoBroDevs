<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background-color: #ffffff;
            border-top: 8px solid #0A2647;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #0A2647;
            margin-bottom: 25px;
            font-size: 24px;
            text-align: center;
        }

        .button {
            display: block;
            width: fit-content;
            margin: 30px auto;
            padding: 14px 30px;
            background-color: #FFC107;
            color: #0A2647 !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 13px;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <p>Hola,</p>
        <p>Has recibido este correo por una solicitud de restablecimiento de contraseña para tu cuenta en la Plataforma
            E-learning.</p>
        <p>Haz clic en el siguiente botón para continuar con el proceso:</p>
        <a href="{{ url('/restablecer-contrasena?token=' . $token . '&email=' . $email) }}" class="button">Restablecer
            Contraseña</a>
        <p>Este enlace expirará en 60 minutos.</p>
        <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
        <div class="footer">
            Atentamente,<br>
            El equipo de Plataforma E-learning
        </div>
    </div>
</body>

</html>