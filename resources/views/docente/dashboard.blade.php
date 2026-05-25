@extends('layouts.partials.app')

@section('title', 'Panel Docente')

@section('styles')
    <style>
        .teacher-dashboard {
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
    <div class="teacher-dashboard">
        <div class="welcome-section">
            <h1>¡Bienvenido, Docente! <span class="role-badge">Profesor</span></h1>
            <p>Panel de gestión académica. Desde aquí puede administrar sus cursos, evaluaciones y recursos didácticos de
                manera eficiente.</p>
        </div>

        <div class="quick-grid">
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-chalkboard"></i></div>
                <h3>Mis Cursos</h3>
                <p>Gestione sus asignaturas vigentes y el contenido de sus clases.</p>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-star"></i></div>
                <h3>Calificaciones</h3>
                <p>Evalúe el desempeño de sus alumnos y registre sus notas finales.</p>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <h3>Subir Material</h3>
                <p>Publique lecturas, tareas y guías para sus diferentes grupos.</p>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon"><i class="fas fa-user-check"></i></div>
                <h3>Lista Asistencia</h3>
                <p>Consulte la lista de estudiantes inscritos en sus cursos activos.</p>
            </a>
        </div>
    </div>
@endsection