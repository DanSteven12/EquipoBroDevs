@extends('layouts.partials.app')

@section('title', 'Panel Estudiante')

@section('styles')
    <style>
        .student-dashboard {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .welcome-section {
            background: var(--white);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border-left: 8px solid var(--primary-light);
            margin-bottom: 2rem;
        }

        .welcome-section h1 {
            color: var(--primary-dark);
            font-size: 2.5rem;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 800;
        }

        .role-badge {
            background: var(--primary-dark);
            color: var(--primary-light);
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .welcome-section p {
            color: #666;
            font-size: 1.2rem;
            max-width: 600px;
        }

        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            text-decoration: none;
            color: var(--text-main);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            border: 1px solid #edf2f7;
        }

        .action-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-light);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            background: #f0f4f8;
            color: var(--primary-dark);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            transition: 0.3s;
        }

        .action-card:hover .action-icon {
            background: var(--primary-dark);
            color: var(--primary-light);
        }

        .action-card h3 {
            margin: 0;
            font-size: 1.4rem;
            color: var(--primary-dark);
            font-weight: 700;
        }

        .action-card p {
            margin: 0;
            color: #777;
            font-size: 0.95rem;
            line-height: 1.5;
        }
    </style>
@endsection

@section('content')
    <div class="student-dashboard">
        <div class="welcome-section">
            <h1>¡Hola, Estudiante! <span class="role-badge">Alumno</span></h1>
            <p>Bienvenido de nuevo a tu espacio de aprendizaje. Aquí tienes acceso rápido a todo lo que necesitas para tu
                formación académica.</p>
        </div>

        <div class="quick-grid">
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-book-open"></i></div>
                <h3>Mis Cursos</h3>
                <p>Accede a tus materias matriculadas y recursos de estudio actuales.</p>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Mis Notas</h3>
                <p>Consulta tus calificaciones y el progreso académico del semestre.</p>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-calendar-alt"></i></div>
                <h3>Calendario</h3>
                <p>Revisa fechas importantes, exámenes y entregas de trabajos.</p>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-users"></i></div>
                <h3>Compañeros</h3>
                <p>Conecta con tus compañeros de clase y grupos de estudio.</p>
            </a>
        </div>
    </div>
@endsection