<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Plataforma E-learning</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #0A2647;
            --primary-light: #FFC107;
            --hover-color: #144272;
            --background: #F5F5F5;
            --text-main: #333333;
            --text-muted: #666666;
            --danger-red: #ef4444;
            --white: #FFFFFF;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-contenedor {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow:
                0 10px 25px -5px rgba(0, 0, 0, 0.1),
                0 8px 10px -6px rgba(0, 0, 0, 0.1);

            width: 100%;
            max-width: 400px;
            border: 4px solid var(--primary-dark);
        }

        h2 {
            text-align: center;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .campo {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.875rem;
        }

        input {
            width: 100%;
            padding: 0.875rem;
            background-color: var(--white);
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            color: var(--text-main);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
        }

        input:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(10, 38, 71, 0.1);
        }

        button {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background-color: #eab000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .enlaces {
            text-align: center;
            margin-top: 1.5rem;
        }

        .enlaces a {
            color: var(--primary-dark);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: color 0.3s;
        }

        .enlaces a:hover {
            color: var(--hover-color);
            text-decoration: underline;
        }

        /* OVERLAY BLOQUEO */

        #overlay-bloqueo {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(12px);
            z-index: 9999;

            flex-direction: column;
            justify-content: center;
            align-items: center;

            text-align: center;
            color: white;

            animation: fadeIn 0.4s ease;
        }

        /* NUEVO ICONO */

        .icon-bloqueo {
            font-size: 5rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        .titulo-bloqueo {
            font-size: 2rem;
            font-weight: 800;
            color: var(--danger-red);
            margin-bottom: 0.5rem;
            letter-spacing: 2px;
        }

        .subtitulo-bloqueo {
            color: #d1d5db;
            font-size: 1.05rem;
            max-width: 420px;
            margin-bottom: 2rem;
            line-height: 1.6;
            padding: 0 20px;
        }

        .countdown {
            font-size: 4rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;

            background: rgba(255, 255, 255, 0.05);

            padding: 1rem 2rem;

            border-radius: 12px;

            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bloqueo {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #9ca3af;
            letter-spacing: 1px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }
        }

        .mensaje-error-api {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-red);

            padding: 0.75rem;

            border-radius: 8px;

            margin-bottom: 1rem;

            font-size: 0.875rem;

            border: 1px solid rgba(239, 68, 68, 0.2);

            text-align: center;

            display: none;
        }

        /* ICONOS EN LABELS */

        .label-icon {
            margin-right: 6px;
        }
    </style>
</head>

<body>

    <!-- OVERLAY BLOQUEO -->

    <div id="overlay-bloqueo">

        <!-- NUEVO ICONO -->
        <div class="icon-bloqueo">
            🚫
        </div>

        <div class="titulo-bloqueo">
            ACCESO DENEGADO
        </div>

        <div class="subtitulo-bloqueo">
            Dirección IP bloqueada temporalmente debido
            a demasiados intentos de acceso.
            <br>
            Protección automática contra ataques DoS.
        </div>

        <div class="countdown" id="timer">
            00:00
        </div>

        <div class="footer-bloqueo">
            HTTP 429 • DEMASIADOS INTENTOS
        </div>

    </div>

    <!-- LOGIN -->

    <div class="login-contenedor">

        <h2>Iniciar Sesión</h2>

        <div id="mensaje-error-api" class="mensaje-error-api">
        </div>

        <form id="formulario-login">

            <!-- EMAIL -->

            <div class="campo">

                <label for="email">
                    <span class="label-icon">📧</span>
                    Correo Electrónico
                </label>

                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>

            </div>

            <!-- PASSWORD -->

            <div class="campo">

                <label for="password">
                    <span class="label-icon">🔒</span>
                    Contraseña
                </label>

                <input type="password" id="password" name="password" placeholder="••••••••" required>

            </div>

            <button type="submit" id="boton-login">

                🚀 Iniciar Sesión

            </button>

        </form>

        <div class="enlaces">

            <a href="{{ url('/recuperar-contrasena') }}">
                🔑 ¿Olvidaste tu contraseña?
            </a>

            <br><br>

            <a href="{{ url('/registro') }}">
                👤 ¿No tienes cuenta? Registrarse
            </a>

        </div>

    </div>

    <script>

        const overlay =
            document.getElementById('overlay-bloqueo');

        const timerElement =
            document.getElementById('timer');

        const errorApi =
            document.getElementById('mensaje-error-api');

        // CONTADOR

        function startCountdown(seconds) {

            const expirationTime =
                Date.now() + (seconds * 1000);

            localStorage.setItem(
                'block_until',
                expirationTime
            );

            showOverlay(seconds);
        }

        function showOverlay(initialSeconds) {

            overlay.style.display = 'flex';

            let duration = initialSeconds;

            const interval = setInterval(() => {

                const mins =
                    Math.floor(duration / 60);

                const secs =
                    duration % 60;

                timerElement.innerText =
                    `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;

                if (--duration < 0) {

                    clearInterval(interval);

                    overlay.style.display = 'none';

                    errorApi.style.display = 'none';

                    localStorage.removeItem('block_until');
                }

            }, 1000);
        }

        // AL RECARGAR

        window.addEventListener('DOMContentLoaded', () => {

            const blockUntil =
                localStorage.getItem('block_until');

            if (blockUntil) {

                const now = Date.now();

                const remaining =
                    Math.ceil((blockUntil - now) / 1000);

                if (remaining > 0) {

                    showOverlay(remaining);

                } else {

                    localStorage.removeItem('block_until');
                }
            }
        });

        // LOGIN

        document.getElementById('formulario-login')
            .addEventListener('submit', async (e) => {

                e.preventDefault();

                const form = e.target;

                const boton =
                    document.getElementById('boton-login');

                errorApi.style.display = 'none';

                boton.disabled = true;

                boton.innerText = 'Cargando...';

                const formData =
                    new FormData(form);

                const data =
                    Object.fromEntries(formData.entries());

                try {

                    const response =
                        await fetch('/api/auth/login', {

                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },

                            body: JSON.stringify(data)
                        });

                    const result =
                        await response.json();

                    // BLOQUEO

                    if (response.status === 429) {

                        const seconds =
                            result.reintento_en_segundos || 60;

                        startCountdown(seconds);

                        return;
                    }

                    // LOGIN EXITOSO

                    if (response.ok) {

                        if (
                            result.requiere_mfa ||
                            result.requiere_configurar_mfa
                        ) {

                            localStorage.setItem(
                                'temp_token',
                                result.token_temporal
                            );

                            localStorage.setItem(
                                'requiere_setup_mfa',
                                result.requiere_configurar_mfa
                                    ? 'true'
                                    : 'false'
                            );

                            window.location.href = '/mfa';

                            return;
                        }

                        localStorage.setItem(
                            'token',
                            result.access_token
                        );

                        const roleId =
                            result.user.role_id;

                        let redirectUrl =
                            '/estudiante/dashboard';

                        if (roleId === 0)
                            redirectUrl = '/administrador/dashboard';

                        else if (roleId === 1)
                            redirectUrl = '/docente/dashboard';

                        window.location.href =
                            redirectUrl;

                    } else {

                        errorApi.innerText =
                            result.mensaje ||
                            'Credenciales incorrectas.';

                        errorApi.style.display = 'block';
                    }

                } catch (error) {

                    console.error('Error:', error);

                    errorApi.innerText =
                        'Error de conexión con el servidor.';

                    errorApi.style.display = 'block';

                } finally {

                    boton.disabled = false;

                    boton.innerText = '🚀 Iniciar Sesión';
                }
            });

    </script>

</body>

</html>