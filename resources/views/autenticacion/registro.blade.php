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
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .registro-contenedor {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow:
                0 10px 25px -5px rgba(0, 0, 0, 0.1),
                0 8px 10px -6px rgba(0, 0, 0, 0.1);
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
        }

        input:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(10, 38, 71, 0.1);
        }

        /* VALIDACIONES */

        .validacion-lista {
            list-style: none;
            padding: 0;
            margin-top: 0.8rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            font-size: 0.80rem;
        }

        .validacion-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-weight: 500;
            transition: 0.3s;
        }

        .validacion-item.cumplido {
            color: var(--success-green);
        }

        .validacion-item.no-cumplido {
            color: var(--danger-red);
        }

        .icono {
            font-size: 14px;
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
        }

        .enlace-login a {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 700;
        }

        .enlace-login a:hover {
            color: var(--hover-color);
        }
    </style>
</head>

<body>

    <div class="registro-contenedor">

        <h2>Crear Cuenta</h2>

        <form id="formulario-registro">

            <!-- NOMBRE -->
            <div class="campo">
                <label for="nombre">Nombre Completo</label>

                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre completo" required>
            </div>

            <!-- EMAIL -->
            <div class="campo">

                <label for="email">
                    Correo Electrónico
                </label>

                <input type="email" id="email" name="email" placeholder="usuario@dominio.com" required>

                <ul class="validacion-lista" id="email-rules">

                    <li class="validacion-item" data-rule="format">

                        <span class="icono">❌</span>
                        Formato válido
                    </li>

                </ul>

            </div>

            <!-- PASSWORD -->
            <div class="campo">

                <label for="password">
                    Contraseña
                </label>

                <input type="password" id="password" name="password" placeholder="••••••••••••" required>

                <ul class="validacion-lista" id="password-rules">

                    <li class="validacion-item" data-rule="length">

                        <span class="icono">❌</span>
                        Mín. 12 caracteres
                    </li>

                    <li class="validacion-item" data-rule="upper">

                        <span class="icono">❌</span>
                        Mayúscula
                    </li>

                    <li class="validacion-item" data-rule="lower">

                        <span class="icono">❌</span>
                        Minúscula
                    </li>

                    <li class="validacion-item" data-rule="number">

                        <span class="icono">❌</span>
                        Número
                    </li>

                    <li class="validacion-item" data-rule="special">

                        <span class="icono">❌</span>
                        Caracter especial
                    </li>

                </ul>

            </div>

            <!-- CONFIRMAR PASSWORD -->
            <div class="campo">

                <label for="password_confirmation">
                    Confirmar Contraseña
                </label>

                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="••••••••••••" required>

                <ul class="validacion-lista" id="confirm-rules">

                    <li class="validacion-item" data-rule="match">

                        <span class="icono">❌</span>
                        Coinciden
                    </li>

                </ul>

            </div>

            <div id="mensaje-error" class="mensaje-error" style="display:none;">
            </div>

            <button type="submit" id="boton-registro">

                Registrarse
            </button>

        </form>

        <div class="enlace-login">
            ¿Ya tienes cuenta?
            <a href="{{ url('/login') }}">
                Iniciar Sesión
            </a>
        </div>

    </div>

    <script>

        const form =
            document.getElementById('formulario-registro');

        const emailInput =
            document.getElementById('email');

        const passwordInput =
            document.getElementById('password');

        const confirmInput =
            document.getElementById('password_confirmation');

        // REGLAS
        const rules = {

            email: {

                format: (val) =>
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
            },

            password: {

                length: (val) =>
                    val.length >= 12,

                upper: (val) =>
                    /[A-Z]/.test(val),

                lower: (val) =>
                    /[a-z]/.test(val),

                number: (val) =>
                    /[0-9]/.test(val),

                special: (val) =>
                    /[!@#$%^&*(),.?":{}|<>]/.test(val)
            },

            confirm: {

                match: (val) =>
                    val === passwordInput.value &&
                    val.length > 0
            }
        };

        // ACTUALIZAR UI
        function updateUI(field, ruleName, isValid) {

            const item =
                document.querySelector(
                    `#${field}-rules [data-rule="${ruleName}"]`
                );

            if (item) {

                const icono =
                    item.querySelector('.icono');

                if (isValid) {

                    item.classList.add('cumplido');

                    item.classList.remove('no-cumplido');

                    icono.textContent = '✅';

                } else {

                    item.classList.remove('cumplido');

                    item.classList.add('no-cumplido');

                    icono.textContent = '❌';
                }
            }
        }

        // VALIDACIONES
        function checkValidity() {

            // EMAIL
            const emailValid =
                rules.email.format(emailInput.value);

            updateUI(
                'email',
                'format',
                emailValid
            );

            // PASSWORD
            Object.keys(rules.password)
                .forEach(rule => {

                    const isValid =
                        rules.password[rule](
                            passwordInput.value
                        );

                    updateUI(
                        'password',
                        rule,
                        isValid
                    );
                });

            // CONFIRM PASSWORD
            const confirmValid =
                rules.confirm.match(
                    confirmInput.value
                );

            updateUI(
                'confirm',
                'match',
                confirmValid
            );
        }

        // EVENTOS
        emailInput.addEventListener(
            'input',
            checkValidity
        );

        passwordInput.addEventListener(
            'input',
            checkValidity
        );

        confirmInput.addEventListener(
            'input',
            checkValidity
        );

        // SUBMIT
        form.addEventListener('submit', async (e) => {

            e.preventDefault();

            const boton =
                document.getElementById('boton-registro');

            const errorDiv =
                document.getElementById('mensaje-error');

            boton.disabled = true;

            boton.innerText = 'Registrando...';

            errorDiv.style.display = 'none';

            const formData =
                new FormData(form);

            const data =
                Object.fromEntries(
                    formData.entries()
                );

            try {

                const response =
                    await fetch('/api/auth/registro', {

                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },

                        body: JSON.stringify(data)
                    });

                const result =
                    await response.json();

                if (response.ok) {

                    alert('Registro exitoso');

                    window.location.href = '/login';

                } else {

                    let mensaje =
                        result.mensaje ||
                        'Error en el registro';

                    if (result.errors) {

                        mensaje =
                            Object.values(result.errors)
                                .flat()
                                .join('<br>');
                    }

                    errorDiv.innerHTML =
                        mensaje;

                    errorDiv.style.display =
                        'block';
                }

            } catch (error) {

                console.error(error);

                errorDiv.innerHTML =
                    'Error de conexión con el servidor.';

                errorDiv.style.display =
                    'block';

            } finally {

                boton.disabled = false;

                boton.innerText = 'Registrarse';
            }
        });

    </script>

</body>

</html>