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

        h1 {
            color: #0A2647;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        p {
            margin-bottom: 15px;
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
        <h1>¡Bienvenido a la Plataforma ELU!</h1>
        <p>Hola <strong>{{ $usuario->nombre }}</strong>,</p>
        <p>Gracias por registrarte. Para completar tu registro y activar tu cuenta institucional, por favor haz clic en
            el siguiente botón:</p>

        <a href="{{ url('/activar-cuenta?token=' . $token . '&email=' . $usuario->email) }}" class="button">Activar mi
            Cuenta</a>

        <p>Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:</p>
        <p style="word-break: break-all; font-size: 12px; color: #144272;">
            {{ url('/activar-cuenta?token=' . $token . '&email=' . $usuario->email) }}
        </p>

        <div class="footer">
            Este es un correo automático, por favor no respondas a este mensaje.<br>
            © {{ date('Y') }} Plataforma E-Learning Universitaria.
        </div>
    </div>
</body>

</html>