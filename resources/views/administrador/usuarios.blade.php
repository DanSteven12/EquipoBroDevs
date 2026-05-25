@extends('layouts.partials.app')

@section('title', 'Gestión de Usuarios - Admin')

@section('styles')
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
        }

        .form-section,
        .list-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        h2 {
            color: var(--primary-dark);
            margin-top: 0;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #4a5568;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: 0.2s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(46, 196, 182, 0.1);
        }

        .submit-btn {
            width: 100%;
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: #eab000;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem;
            background: #f8f9fa;
            color: #718096;
            font-weight: 600;
            border-bottom: 2px solid #edf2f7;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #edf2f7;
            color: #2d3748;
        }

        .status-badge {
            background: #fff8e1;
            color: #ffa000;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .error-msg {
            color: var(--accent-red);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .alert-success {
            background: #def7ec;
            color: #03543f;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .search-container {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            align-items: center;
        }

        .search-input-group {
            flex: 1;
            position: relative;
        }

        .search-input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }

        .search-input-group input {
            padding-left: 2.5rem;
            background: white;
        }

        .filter-btn {
            background: var(--primary-dark);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .filter-btn:hover {
            background: var(--hover-color);
        }

        .role-select {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            font-weight: 600;
            color: #4a5568;
            outline: none;
            cursor: pointer;
        }

        .role-select:focus {
            border-color: var(--primary-light);
        }

        .table-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .table-header-flex h2 {
            margin-bottom: 0;
        }

        @media (max-width: 900px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="admin-container">
        <!-- Formulario de Registro de Docentes -->
        <div class="form-section">
            <h2><i class="fas fa-user-plus"></i> Registrar Docente</h2>

            @if (session('status'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('admin.registrar-docente') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej. Juan Pérez">
                    @error('nombre') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="docente@universidad.edu">
                    @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" required placeholder="********">
                    @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" required placeholder="********">
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Guardar Docente
                </button>
            </form>
        </div>

        <!-- Lista de Usuarios -->
        <div class="list-section">
            <div class="table-header-flex">
                <h2>
                    <i
                        class="fas {{ $rol_id == 0 ? 'fa-user-shield' : ($rol_id == 1 ? 'fa-chalkboard-teacher' : 'fa-user-graduate') }}"></i>
                    {{ $rol_id == 0 ? 'Administradores' : ($rol_id == 1 ? 'Docentes' : 'Estudiantes') }} Registrados
                </h2>
            </div>

            <!-- Barra de Filtros -->
            <form action="{{ route('admin.usuarios') }}" method="GET" id="search-form">
                <div class="search-container">
                    <div class="search-input-group">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                            placeholder="Buscar por nombre o correo..." autocomplete="off">
                    </div>

                    <select name="role" id="role-select" class="role-select" onchange="this.form.submit()">
                        <option value="2" {{ $rol_id == 2 ? 'selected' : '' }}>Estudiantes</option>
                        <option value="1" {{ $rol_id == 1 ? 'selected' : '' }}>Docentes</option>
                        <option value="0" {{ $rol_id == 0 ? 'selected' : '' }}>Administradores</option>
                    </select>

                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.usuarios') }}" class="filter-btn"
                            style="background: #a0aec0; text-decoration: none;">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    @endif
                </div>
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha Reg.</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td><strong>{{ $usuario->nombre }}</strong></td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                <td><span class="status-badge">Activo</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; color: #718096;">
                                    No se encontraron usuarios con estos filtros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Búsqueda automática con debounce (500ms)
        let typingTimer;
        const searchInput = document.getElementById('search-input');
        const searchForm = document.getElementById('search-form');

        searchInput.addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                searchForm.submit();
            }, 800);
        });

        // Mantener el cursor al final del input después de recargar
        window.addEventListener('load', () => {
            if (searchInput.value) {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
        });
    </script>
@endsection