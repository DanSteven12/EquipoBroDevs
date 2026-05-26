@extends('layouts.partials.app')

@section('title', 'Panel Docente')

@section('styles')
    <style>
        .teacher-dashboard {
            max-width: 1350px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* HERO */

        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 30px;
            padding: 4rem;
            color: white;
            margin-bottom: 2.5rem;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: -100px;
            right: -100px;
            width: 280px;
            height: 280px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .hero-section::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-top {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .hero-icon {
            width: 90px;
            height: 90px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .hero-title h1 {
            margin: 0;
            font-size: 2.8rem;
            font-weight: 800;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.8rem;
            background: rgba(250, 204, 21, 0.15);
            color: #fde68a;
            border: 1px solid rgba(250, 204, 21, 0.3);
            padding: 0.55rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-description {
            max-width: 700px;
            font-size: 1.1rem;
            line-height: 1.8;
            opacity: 0.9;
        }

        /* GRID */

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
            gap: 1.8rem;
            margin-bottom: 2.5rem;
        }

        .dashboard-card {
            position: relative;
            overflow: hidden;
            background: white;
            border-radius: 24px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.35s ease;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 22px 40px rgba(15, 23, 42, 0.12);
        }

        .dashboard-card::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.06;
        }

        .card-blue::before {
            background: #2563eb;
        }

        .card-yellow::before {
            background: #f59e0b;
        }

        .card-green::before {
            background: #16a34a;
        }

        .card-purple::before {
            background: #7c3aed;
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
        }

        .card-icon {
            width: 75px;
            height: 75px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .icon-blue {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
        }

        .icon-yellow {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .icon-green {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .icon-purple {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
        }

        .mini-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: #f8fafc;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-card h3 {
            margin: 0 0 1rem;
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
        }

        .dashboard-card p {
            margin: 0;
            color: #64748b;
            line-height: 1.8;
        }

        .card-footer {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-tag {
            background: #f8fafc;
            color: #475569;
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .arrow-btn {
            width: 45px;
            height: 45px;
            border-radius: 14px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            transition: 0.3s;
        }

        .dashboard-card:hover .arrow-btn {
            background: #0f172a;
            color: white;
            transform: translateX(5px);
        }

        /* ACTIVIDADES */

        .activities-section {
            background: white;
            border-radius: 28px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
            border: 1px solid #e2e8f0;
        }

        .activities-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .activities-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .activities-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, #0f172a, #334155);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .activities-title h2 {
            margin: 0;
            font-size: 1.7rem;
            color: #0f172a;
            font-weight: 800;
        }

        .activities-title p {
            margin: 0.3rem 0 0;
            color: #64748b;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8fafc;
            padding: 1.2rem 1.5rem;
            border-radius: 20px;
            transition: 0.3s;
            border: 1px solid transparent;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .activity-item:hover {
            transform: translateX(6px);
            border-color: #cbd5e1;
            background: white;
        }

        .activity-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .activity-badge {
            width: 55px;
            height: 55px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .badge-blue {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
        }

        .badge-red {
            background: linear-gradient(135deg, #dc2626, #f87171);
        }

        .badge-green {
            background: linear-gradient(135deg, #16a34a, #4ade80);
        }

        .badge-purple {
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
        }

        .activity-info h4 {
            margin: 0;
            font-size: 1rem;
            color: #0f172a;
            font-weight: 700;
        }

        .activity-info p {
            margin: 0.3rem 0 0;
            color: #64748b;
            font-size: 0.92rem;
        }

        .activity-date {
            background: white;
            padding: 0.6rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2.5rem;
            }

            .hero-title h1 {
                font-size: 2rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .hero-icon {
                width: 75px;
                height: 75px;
                font-size: 2rem;
            }

            .activity-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <div class="teacher-dashboard">

        {{-- HERO --}}
        <div class="hero-section">
            <div class="hero-content">

                <div class="hero-top">

                    <div class="hero-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>

                    <div class="hero-title">
                        <h1>Panel Académico Docente</h1>

                        <span class="role-badge">
                            <i class="fas fa-shield-alt"></i>
                            Profesor
                        </span>
                    </div>

                </div>

                <p class="hero-description">
                    Administre cursos, materiales académicos, evaluaciones y asistencia desde un entorno moderno,
                    organizado y eficiente.
                </p>

            </div>
        </div>

        {{-- CARDS --}}
        <div class="dashboard-grid">

            <a href="#" class="dashboard-card card-blue">

                <div class="card-top">
                    <div class="card-icon icon-blue">
                        <i class="fas fa-laptop-house"></i>
                    </div>

                    <div class="mini-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>

                <h3>Mis Cursos</h3>

                <p>
                    Organice asignaturas, contenido académico y actividades relacionadas con cada grupo.
                </p>

                <div class="card-footer">
                    <span class="card-tag">Gestión Académica</span>

                    <div class="arrow-btn">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

            </a>

            <a href="#" class="dashboard-card card-yellow">

                <div class="card-top">
                    <div class="card-icon icon-yellow">
                        <i class="fas fa-award"></i>
                    </div>

                    <div class="mini-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>

                <h3>Calificaciones</h3>

                <p>
                    Registre notas, evaluaciones y consulte el rendimiento académico de los estudiantes.
                </p>

                <div class="card-footer">
                    <span class="card-tag">Evaluaciones</span>

                    <div class="arrow-btn">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

            </a>

            <a href="#" class="dashboard-card card-green">

                <div class="card-top">
                    <div class="card-icon icon-green">
                        <i class="fas fa-file-circle-plus"></i>
                    </div>

                    <div class="mini-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>

                <h3>Subir Material</h3>

                <p>
                    Publique documentos, tareas, recursos digitales y archivos para sus estudiantes.
                </p>

                <div class="card-footer">
                    <span class="card-tag">Recursos</span>

                    <div class="arrow-btn">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

            </a>

            <a href="#" class="dashboard-card card-purple">

                <div class="card-top">
                    <div class="card-icon icon-purple">
                        <i class="fas fa-clipboard-user"></i>
                    </div>

                    <div class="mini-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>

                <h3>Lista de Asistencia</h3>

                <p>
                    Controle la asistencia y participación de los estudiantes inscritos en cada curso.
                </p>

                <div class="card-footer">
                    <span class="card-tag">Control Escolar</span>

                    <div class="arrow-btn">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

            </a>

        </div>

        {{-- ACTIVIDADES --}}
        <div class="activities-section">

            <div class="activities-header">

                <div class="activities-title">

                    <div class="activities-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>

                    <div>
                        <h2>Próximas Actividades</h2>
                        <p>Eventos y tareas programadas para los próximos días</p>
                    </div>

                </div>

            </div>

            <div class="activity-list">

                <div class="activity-item">

                    <div class="activity-left">

                        <div class="activity-badge badge-blue">
                            <i class="fas fa-code"></i>
                        </div>

                        <div class="activity-info">
                            <h4>Clase de Programación Web</h4>
                            <p>Grupo 9A • Laboratorio 2</p>
                        </div>

                    </div>

                    <div class="activity-date">
                        <i class="fas fa-clock"></i> 28 Mayo • 08:00 AM
                    </div>

                </div>

                <div class="activity-item">

                    <div class="activity-left">

                        <div class="activity-badge badge-red">
                            <i class="fas fa-file-signature"></i>
                        </div>

                        <div class="activity-info">
                            <h4>Entrega de Proyecto Final</h4>
                            <p>Ingeniería de Software</p>
                        </div>

                    </div>

                    <div class="activity-date">
                        <i class="fas fa-calendar"></i> 30 Mayo
                    </div>

                </div>

                <div class="activity-item">

                    <div class="activity-left">

                        <div class="activity-badge badge-green">
                            <i class="fas fa-book-reader"></i>
                        </div>

                        <div class="activity-info">
                            <h4>Revisión de Tareas</h4>
                            <p>Asignación de Base de Datos</p>
                        </div>

                    </div>

                    <div class="activity-date">
                        <i class="fas fa-check-circle"></i> Pendiente
                    </div>

                </div>

                <div class="activity-item">

                    <div class="activity-left">

                        <div class="activity-badge badge-purple">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="activity-info">
                            <h4>Reunión Académica</h4>
                            <p>Coordinación de Carrera</p>
                        </div>

                    </div>

                    <div class="activity-date">
                        <i class="fas fa-clock"></i> 02 Junio • 12:00 PM
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection