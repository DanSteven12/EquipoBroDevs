<footer class="main-footer">
    <div class="footer-content">
        <p>&copy; {{ date('Y') }} Plataforma E-Learning Universitaria. Panel de Administración.</p>
        <div class="footer-links">
            <a href="#">Soporte</a>
            <a href="#">Políticas</a>
            <a href="#">Ayuda</a>
        </div>
    </div>
</footer>

<style>
    .main-footer {
        background: var(--white);
        padding: 2.5rem 1rem;
        border-top: 4px solid var(--primary-dark);
        margin-top: auto;
        box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.02);
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #777;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .footer-links {
        display: flex;
        gap: 2rem;
    }

    .footer-links a {
        color: #555;
        text-decoration: none;
        transition: 0.3s;
        font-weight: 600;
    }

    .footer-links a:hover {
        color: var(--primary-dark);
    }

    @media (max-width: 600px) {
        .footer-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>