<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad de la Cuenta - Modo Prueba</title>
    <style>
        :root {
            --primary-dark: #0A2647;
            --primary-light: #FFC107;
            --hover-color: #144272;
            --background: #F5F5F5;
            --text-main: #333333;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--text-main);
            padding: 20px;
        }

        .mfa-contenedor {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            text-align: center;
            border: 4px solid var(--primary-dark);
        }

        .alert-prueba {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fef3c7;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        h2 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .seccion-qr {
            margin: 2rem 0;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px dashed #cbd5e1;
        }

        .qr-placeholder {
            margin: 1rem auto;
            max-width: 200px;
            min-height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .qr-placeholder svg {
            width: 100%;
            height: auto;
        }

        .instrucciones {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .campo {
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            box-sizing: border-box;
            text-align: center;
            font-size: 2rem;
            letter-spacing: 0.8rem;
            font-weight: 800;
            color: var(--primary-dark);
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 4px rgba(10, 38, 71, 0.1);
        }

        button {
            width: 100%;
            padding: 1.2rem;
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        button:hover {
            background-color: #eab000;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        #mensaje-error {
            color: #ef4444;
            background: #fef2f2;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: none;
            font-size: 0.9rem;
            border: 1px solid #fee2e2;
        }
    </style>
</head>

<body>
    <div class="mfa-contenedor">
        <div class="alert-prueba">
            ⚠️ MODO PRUEBA ACTIVO<br>
            Usa el código: <span style="font-size: 1.4rem; color: #b45309;">123456</span>
        </div>

        <h2>Seguridad de la Cuenta</h2>
        <p class="instrucciones">Escanea el código con Google Authenticator o usa el código de prueba de arriba.</p>

        <div id="mensaje-error"></div>

        <div class="seccion-qr">
            <p style="font-weight: 600; font-size: 0.9rem; margin-bottom: 0.5rem; color: var(--primary-dark);">Configura tu Aplicación</p>
            <div id="qr-container" class="qr-placeholder">
                <!-- QR DE RESPALDO SIEMPRE VISIBLE PARA LA DEMO -->
                <svg width="200" height="200" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" style="background:white; padding:10px;"><path d="M0 0h7v7H0zM22 0h7v7h-7zM0 22h7v7H0zM2 2h3v3H2zM24 2h3v3h-3zM2 24h3v3H2zM10 0h2v2h-2zM14 0h1v1h-1zM17 0h3v2h-3zM10 4h2v3h-2zM14 3h1v2h-1zM17 4h3v2h-3z" fill="black"/></svg>
            </div>
            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">Si el QR no carga dinámicamente, usa el de arriba para la presentación.</p>
        </div>

        <form id="formulario-mfa">
            <div class="campo">
                <input type="text" id="codigo_otp" name="codigo_otp" maxlength="6" placeholder="000000" pattern="[0-9]{6}" inputmode="numeric" required autofocus>
            </div>
            <button type="submit" id="btn-verificar">VERIFICAR Y ACCEDER</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const tokenTemporal = localStorage.getItem('temp_token');
            const qrContainer = document.getElementById('qr-container');
            const errorDiv = document.getElementById('mensaje-error');
            
            if (!tokenTemporal) {
                window.location.href = '/login';
                return;
            }

            // Intentar cargar el QR real
            try {
                const response = await fetch('/api/auth/mfa/setup', {
                    headers: { 
                        'Authorization': `Bearer ${tokenTemporal}`,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    qrContainer.innerHTML = data.qr_code;
                }
            } catch (error) {
                console.log('Manteniendo QR de respaldo');
            }
        });

        document.getElementById('formulario-mfa').addEventListener('submit', async (e) => {
            e.preventDefault();
            const codigo = document.getElementById('codigo_otp').value;
            const tokenTemporal = localStorage.getItem('temp_token');
            const btn = document.getElementById('btn-verificar');
            const errorDiv = document.getElementById('mensaje-error');

            errorDiv.style.display = 'none';
            btn.disabled = true;
            btn.innerText = 'VERIFICANDO...';

            try {
                const response = await fetch('/api/auth/mfa/verificar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        codigo_otp: codigo,
                        token_temporal: tokenTemporal
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    localStorage.setItem('token', result.access_token);
                    localStorage.removeItem('temp_token');
                    localStorage.removeItem('requiere_setup_mfa');
                    
                    const roleId = result.user.role_id;
                    let redirectUrl = '/estudiante/dashboard';
                    if (roleId === 0) redirectUrl = '/administrador/dashboard';
                    else if (roleId === 1) redirectUrl = '/docente/dashboard';
                    
                    window.location.href = redirectUrl;
                } else {
                    errorDiv.innerText = result.mensaje || 'Código inválido.';
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                errorDiv.innerText = 'Error de conexión con el servidor.';
                errorDiv.style.display = 'block';
            } finally {
                btn.disabled = false;
                btn.innerText = 'VERIFICAR Y ACCEDER';
            }
        });
    </script>
</body>
</html>