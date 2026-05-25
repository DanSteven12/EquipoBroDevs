<nav class="admin-nav">
    <div class="nav-container">
        <a href="{{ url('/administrador/dashboard') }}" class="brand">
            <i class="fas fa-university"></i> <span>E-Learning <span>Admin</span></span>
        </a>
        <div class="nav-links">
            <a href="{{ url('/administrador/dashboard') }}"
                class="{{ Request::is('administrador/dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ url('/administrador/usuarios') }}"
                class="{{ Request::is('administrador/usuarios') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Gestión Usuarios
            </a>
            <button class="logout-btn" onclick="cerrarSesion()">
                <i class="fas fa-sign-out-alt"></i> Salir
            </button>
        </div>
    </div>
</nav>

<style>
    .admin-nav {
        background: var(--primary-dark);
        padding: 1rem 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand {
        text-decoration: none;
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .brand span span {
        color: var(--primary-light);
    }

    .nav-links {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .nav-links a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 0.8rem;
        border-radius: 6px;
    }

    .nav-links a:hover {
        background: var(--hover-color);
        color: white;
    }

    .nav-links a.active {
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 700;
    }

    .logout-btn {
        background: var(--accent-red);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #b5250a;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .nav-links span {
            display: none;
        }
    }
</style>

<script>
    async function cerrarSesion() {
        try {
            const token = localStorage.getItem('token');
            if (token) {
                await fetch('/api/auth/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
            }
        } catch (error) {
            console.error('Error al cerrar sesión:', error);
        } finally {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
    }
</script>