<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Plataforma E-learning</title>
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
            --success-green: #28a745;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .registro-contenedor {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
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
            margin-bottom: 1.25rem;
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
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(10, 38, 71, 0.1);
        }

        /* Validación en tiempo real */
        .validacion-lista {
            list-style: none;
            padding: 0;
            margin: 0.75rem 0 0 0;
            font-size: 0.75rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .validacion-item {
            display: flex;
            align-items: center;
            color: var(--text-muted);
            transition: color 0.3s;
            font-weight: 500;
        }

        .validacion-item.cumplido {
            color: var(--success-green);
        }

        .validacion-item.no-cumplido {
            color: var(--danger-red);
        }

        .validacion-item svg {
            width: 14px;
            height: 14px;
            margin-right: 6px;
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
            margin-top: 1rem;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover:not(:disabled) {
            background-color: #eab000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .mensaje-error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-red);
            padding: 0.75rem;
            border-radius: 8px;
            margin-top: 1rem;
            font-size: 0.875rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
            text-align: center;
        }

        .enlace-login {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--text-main);
            font-weight: 500;
        }

        .enlace-login a {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .enlace-login a:hover {
            color: var(--hover-color);
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="registro-contenedor">
        <h2>Crear Cuenta</h2>
        <form id="formulario-registro">
            <div class="campo">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
            </div>

            <div class="campo">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="usuario@dominio.com" required>
                <ul class="validacion-lista" id="email-rules">
                    <li class="validacion-item" data-rule="format">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                            </path>
                        </svg>
                        Formato válido
                    </li>
                </ul>
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••••••" required>
                <ul class="validacion-lista" id="password-rules">
                    <li class="validacion-item" data-rule="length">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                            </path>
                        </svg>
                        Mín. 12 caracteres
                    </li>
                    <li class="validacion-item" data-rule="upper">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                            </path>
                        </svg>
                        Mayúscula
                    </li>
                    <li class="validacion-item" data-rule="lower">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                            </path>
                        </svg>
                        Minúscula
                    </li>
                    <li class="validacion-item" data-rule="number">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                            </path>
                        </svg>
                        Número
                    </li>
                    <li class="validacion-item" data-rule="special">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                            </path>
                        </svg>
                        Especial (!@#$%^&*)
                    </li>
                </ul>
            </div>

            <div class="campo">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="••••••••••••" required>
                <ul class="validacion-lista" id="confirm-rules">
                    <li class="validacion-item" data-rule="match">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                            </path>
                        </svg>
                        Coinciden
                    </li>
                </ul>
            </div>

            <div id="mensaje-error" class="mensaje-error" style="display: none; margin-bottom: 1rem;"></div>
            <button type="submit" id="boton-registro">Registrarse</button>
        </form>
        <div class="enlace-login">
            ¿Ya tienes cuenta? <a href="{{ url('/login') }}">Iniciar Sesión</a>
        </div>
    </div>

    <script>
        const form = document.getElementById('formulario-registro');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const botonSubmit = document.getElementById('boton-registro');

        const rules = {
            email: {
                format: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
            },
            password: {
                length: (val) => val.length >= 12,
                upper: (val) => /[A-Z]/.test(val),
                lower: (val) => /[a-z]/.test(val),
                number: (val) => /[0-9]/.test(val),
                special: (val) => /[!@#$%^&*(),.?":{}|<>]/.test(val)
            },
            confirm: {
                match: (val) => val === passwordInput.value && val.length > 0
            }
        };

        function updateUI(field, ruleName, isValid) {
            const item = document.querySelector(`#${field}-rules [data-rule="${ruleName}"]`);
            if (item) {
                item.classList.toggle('cumplido', isValid);
                item.classList.toggle('no-cumplido', !isValid && document.getElementById(field).value.length > 0);
            }
        }

        function checkValidity() {
            let formValid = true;

            // Email
            const emailValid = rules.email.format(emailInput.value);
            updateUI('email', 'format', emailValid);
            if (!emailValid) formValid = false;

            // Password
            Object.keys(rules.password).forEach(rule => {
                const isValid = rules.password[rule](passwordInput.value);
                updateUI('password', rule, isValid);
                if (!isValid) formValid = false;
            });

            // Confirm
            const confirmValid = rules.confirm.match(confirmInput.value);
            updateUI('confirm', 'match', confirmValid);
            if (!confirmValid) formValid = false;

            // botonSubmit.disabled = !formValid; // Opcional: deshabilitar hasta que sea válido
        }

        emailInput.addEventListener('input', checkValidity);
        passwordInput.addEventListener('input', checkValidity);
        confirmInput.addEventListener('input', checkValidity);

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const boton = document.getElementById('boton-registro');
            const errorDiv = document.getElementById('mensaje-error');

            errorDiv.style.display = 'none';
            boton.disabled = true;
            boton.innerText = 'Registrando...';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('/api/auth/registro', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    let msg = 'Registro exitoso. Serás redirigido.';
                    if (result.enlace_activacion_test) {
                        msg = `Registro exitoso (MODO PRUEBA). <br><br> Haz clic aquí para activar:<br> <a href="${result.enlace_activacion_test}" style="color: var(--primary-dark); font-weight: bold; word-break: break-all;">${result.enlace_activacion_test}</a>`;
                        errorDiv.innerHTML = msg;
                        errorDiv.style.background = 'rgba(40, 167, 69, 0.1)';
                        errorDiv.style.color = 'var(--success-green)';
                        errorDiv.style.borderColor = 'rgba(40, 167, 69, 0.2)';
                        errorDiv.style.display = 'block';
                    } else {
                        alert(msg);
                        window.location.href = '/login';
                    }
                } else {
                    let mensaje = result.mensaje || 'Error en el registro';
                    if (result.errors) {
                        mensaje = Object.values(result.errors).flat().join('<br>');
                    } else if (typeof result === 'object') {
                        mensaje = Object.values(result).flat().join('<br>');
                    }
                    errorDiv.innerHTML = mensaje;
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                errorDiv.innerText = 'Error de conexión con el servidor.';
                errorDiv.style.display = 'block';
            } finally {
                boton.disabled = false;
                boton.innerText = 'Registrarse';
            }
        });
    </script>
</body>

</html>