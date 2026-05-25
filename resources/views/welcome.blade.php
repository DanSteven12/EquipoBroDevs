<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Learning Universitaria') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">

    <style>
        :root {
            --primary-dark: #0A2647;
            --primary-light: #FFC107;
            --hover-color: #144272;
            --background: #F5F5F5;
            --text-main: #333333;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            line-height: 1.6;
        }

        .navbar {
            background-color: var(--primary-dark);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-light);
        }

        .btn-login {
            background-color: var(--primary-light);
            color: var(--primary-dark) !important;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .btn-login:hover {
            background-color: #eab000;
            transform: translateY(-2px);
        }

        .hero {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, var(--primary-dark) 0%, #144272 100%);
            color: var(--white);
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 800px;
            margin: 0 auto 2.5rem;
            opacity: 0.9;
        }

        .hero-btns {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            padding: 1rem 2.5rem;
            border-radius: 10px;
            font-weight: 800;
            text-decoration: none;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--white);
            padding: 1rem 2.5rem;
            border-radius: 10px;
            font-weight: 800;
            text-decoration: none;
            text-transform: uppercase;
            border: 2px solid var(--white);
            transition: 0.3s;
        }

        .features {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .feature-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--primary-dark);
        }

        footer {
            background-color: var(--primary-dark);
            color: var(--white);
            padding: 4rem 2rem 2rem;
            text-align: center;
        }

        .footer-bottom {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="/" class="logo">
            <i class="fas fa-university"></i> PLATAFORMA ELU
        </a>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Ir al Panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registrarse</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <section class="hero">
        <h1>Excelencia Académica en la Era Digital</h1>
        <p>Accede a una formación de primer nivel con nuestra plataforma de e-learning diseñada para potenciar tu
            crecimiento profesional.</p>
        <div class="hero-btns">
            <a href="{{ route('register') }}" class="btn-primary">Empieza Ahora</a>
            <a href="#features" class="btn-secondary">Saber Más</a>
        </div>
    </section>

    <div id="features" class="features">
        <div class="feature-card">
            <i class="fas fa-user-graduate feature-icon"></i>
            <h3>Para Estudiantes</h3>
            <p>Accede a tus cursos, materiales y calificaciones en un solo lugar de forma intuitiva.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-chalkboard-teacher feature-icon"></i>
            <h3>Para Docentes</h3>
            <p>Herramientas avanzadas para la gestión de contenidos y evaluación de aprendizaje.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-shield-alt feature-icon"></i>
            <h3>Seguro y Confiable</h3>
            <p>Infraestructura robusta con autenticación de múltiples factores (MFA) para tu tranquilidad.</p>
        </div>
    </div>

    <footer>
        <div class="footer-links" style="display: flex; justify-content: center; gap: 3rem; margin-bottom: 2rem;">
            <a href="#" style="color: white; text-decoration: none;">Privacidad</a>
            <a href="#" style="color: white; text-decoration: none;">Términos</a>
            <a href="#" style="color: white; text-decoration: none;">Soporte</a>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Plataforma E-Learning Universitaria. Todos los derechos reservados.
        </div>
    </footer>
</body>

</html>