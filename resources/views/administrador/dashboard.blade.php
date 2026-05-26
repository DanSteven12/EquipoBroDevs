@extends('layouts.partials.app')

@section('title', 'Dashboard Administrador')

@section('styles')
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .welcome-card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-left: 8px solid var(--primary-light);
        }

        .welcome-card h1 {
            color: var(--primary-dark);
            margin: 0 0 1rem 0;
            font-size: 2.2rem;
            font-weight: 800;
        }

        .welcome-card p {
            color: #4a5568;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            /* Se ajustó el grid para soportar 4 columnas de forma simétrica */
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            border: 1px solid #edf2f7;
            text-decoration: none; /* Evita subrayados si se usa como enlace */
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            flex-shrink: 0;
        }

        /* Colores ejecutivos refinados */
        .icon-users {
            background: #eff6ff;
            color: #2563eb;
        }

        .icon-teachers {
            background: #f0fdf4;
            color: #16a34a;
        }

        .icon-courses {
            background: #faf5ff;
            color: #7c3aed;
        }

        .icon-admin-users {
            background: #fff7ed;
            color: #ea580c;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 0.9rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
        }

        .stat-info p {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .stat-info .action-text {
            font-size: 0.85rem;
            color: #718096;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.25rem;
        }

        .stat-card:hover .action-text {
            color: var(--primary-light);
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container">
        <div class="welcome-card">
            <h1>¡Bienvenido al Panel de Control!</h1>
            <p>Desde aquí puedes gestionar todos los aspectos institucionales de la plataforma. Utiliza el menú superior
                para navegar entre las diferentes secciones.</p>
        </div>

        <div class="stats-grid">
            <!-- Tarjeta Estudiantes -->
            <div class="stat-card">
                <div class="stat-icon icon-users">
                    <i class="fa-solid fa-address-book"></i>
                </div>
                <div class="stat-info">
                    <h3>Estudiantes</h3>
                    <p>N/A</p>
                </div>
            </div>

            <!-- Tarjeta Docentes -->
            <div class="stat-card">
                <div class="stat-icon icon-teachers">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <div class="stat-info">
                    <h3>Docentes</h3>
                    <p>N/A</p>
                </div>
            </div>

            <!-- Tarjeta Cursos Activos -->
            <div class="stat-card">
                <div class="stat-icon icon-courses">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <div class="stat-info">
                    <h3>Cursos Activos</h3>
                    <p>0</p>
                </div>
            </div>

            <!-- NUEVA TARJETA: Acceso Directo a Gestión de Usuarios -->
            <a href="{{ route('admin.usuarios') }}" class="stat-card">
                <div class="stat-icon icon-admin-users">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div class="stat-info">
                    <h3>Administrar</h3>
                    <span class="action-text">
                        Gestionar Usuarios <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>
@endsection