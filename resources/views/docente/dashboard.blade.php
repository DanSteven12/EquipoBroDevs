@extends('layouts.partials.app')

@section('title', 'Panel Docente')

@section('styles')
    <style>
        .teacher-dashboard {
            max-width: 1350px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-radius: 28px;
            padding: 3.5rem;
            color: white;
            margin-bottom: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: -80px;
            right: -80px;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .hero-section::after {
            content: "";
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-top {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
        }

        .hero-icon {
            width: 75px;
            height: 75px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
        }

        .hero-title h1 {
            margin: 0;
            font-size: 2.7rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .role-badge {
            display: inline-block;
            margin-top: 0.5rem;
            background: #facc15;
            color: #1e293b;
            padding: 0.45rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .hero-description {
            max-width: 700px;
            font-size: 1.1rem;
            line-height: 1.8;
            opacity: 0.92;
            margin-top: 1rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.8rem;
        }

        .dashboard-card {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            border-radius: 22px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: 0.35s ease;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px rgba(15, 23, 42, 0.12);
            border-color: #cbd5e1;
        }

        .dashboard-card::before {
            content: "";
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: rgba(59, 130, 246, 0.06);
            border-radius: 50%;
        }

        .card-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            transition: 0.3s ease;
        }

        .dashboard-card:hover .card-icon {
            transform: scale(1.08) rotate(4deg);
        }

        .icon-blue {
            background: #dbeafe;
            color: #2563eb;
        }

        .icon-yellow {
            background: #fef3c7;
            color: #d97706;
        }

        .icon-green {
            background: #dcfce7;
            color: #16a34a;
        }

        .icon-purple {
            background: #ede9fe;
            color: #7c3aed;
        }

        .dashboard-card h3 {
            margin: 0 0 0.8rem 0;
            font-size: 1.35rem;
            font-weight: 700;
            color: #0f172a;
        }

        .dashboard-card p {
            margin: 0;
            color: #64748b;
            line-height: 1.7;
            font-size: 0.97rem;
        }

        .card-arrow {
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-end;
            font-size: 1.2rem;
            color: #94a3b8;
            transition: 0.3s;
        }

        .dashboard-card:hover .card-arrow {
            transform: translateX(6px);
            color: #334155;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2.5rem 2rem;
            }

            .hero-title h1 {
                font-size: 2rem;
            }

            .hero-description {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="teacher-dashboard">

        <div class="hero-section">
            <div class="hero-content">

                <div class="hero-top">
                    <div class="hero-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>

                    <div class="hero-title">
                        <h1>Panel Académico Docente</h1>
                        <span class="role-badge">Profesor</span>
                    </div>
                </div>

                <p class="hero-description">
                    Administre cursos, materiales, evaluaciones y asistencia desde un entorno moderno,
                    organizado y accesible para optimizar la gestión académica.
                </p>

            </div>
        </div>

        <div class="dashboard-grid">

            <a href="#" class="dashboard-card">
                <div class="card-icon icon-blue">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>

                <h3>Mis Cursos</h3>

                <p>
                    Consulte, organice y administre las asignaturas activas junto con el contenido
                    y recursos de cada clase.
                </p>

                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <a href="#" class="dashboard-card">
                <div class="card-icon icon-yellow">
                    <i class="fas fa-medal"></i>
                </div>

                <h3>Calificaciones</h3>

                <p>
                    Registre evaluaciones, gestione actividades y supervise el rendimiento académico
                    de los estudiantes.
                </p>

                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <a href="#" class="dashboard-card">
                <div class="card-icon icon-green">
                    <i class="fas fa-file-upload"></i>
                </div>

                <h3>Subir Material</h3>

                <p>
                    Comparta documentos, tareas, presentaciones y recursos didácticos para sus grupos.
                </p>

                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <a href="#" class="dashboard-card">
                <div class="card-icon icon-purple">
                    <i class="fas fa-clipboard-check"></i>
                </div>

                <h3>Lista de Asistencia</h3>

                <p>
                    Controle la asistencia de los estudiantes inscritos y mantenga seguimiento de participación.
                </p>

                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

        </div>
    </div>
@endsection