// Global Variables & Configurations
const API_URL = '/api';

// --- COOKIE UTILITIES ---
function setCookie(name, value, minutes = 15) {
    const d = new Date();
    d.setTime(d.getTime() + (minutes * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Lax";
    localStorage.setItem(name, value); // Fallback safe
}

function getCookie(name) {
    const cname = name + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(cname) == 0) {
            return c.substring(cname.length, c.length);
        }
    }
    return localStorage.getItem(name) || ''; // Fallback safe
}

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    localStorage.removeItem(name);
}

// --- DYNAMIC TOAST NOTIFICATION SYSTEM ---
function showToast(message, type = 'info') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    let icon = 'fa-info-circle';
    if (type === 'success') icon = 'fa-check-circle';
    if (type === 'error') icon = 'fa-exclamation-circle';

    toast.innerHTML = `
        <i class="fa-solid ${icon}"></i>
        <div class="toast-message">${message}</div>
        <i class="fa-solid fa-xmark toast-close"></i>
    `;

    container.appendChild(toast);

    // Trigger transition
    setTimeout(() => toast.classList.add('show'), 50);

    // Auto-remove after 4s
    const removeTimeout = setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 4000);

    // Manual close
    toast.querySelector('.toast-close').addEventListener('click', () => {
        clearTimeout(removeTimeout);
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    });
}

// --- SECURE API FETCH WRAPPER ---
async function apiFetch(endpoint, options = {}) {
    const token = getCookie('token');
    
    // Set headers
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const config = {
        ...options,
        headers
    };

    try {
        const response = await fetch(`${API_URL}${endpoint}`, config);
        
        // Handle session expiration
        if (response.status === 401 && endpoint !== '/auth/login') {
            deleteCookie('token');
            deleteCookie('user');
            if (window.location.pathname.includes('perfil.html')) {
                window.location.href = '/login.html?session=expired';
            }
        }
        
        return response;
    } catch (error) {
        console.error("API Fetch Error: ", error);
        showToast("Error de conexión con el servidor.", "error");
        throw error;
    }
}

// --- DYNAMIC SESSION & NAVBAR HANDLER ---
function updateNavbar() {
    const token = getCookie('token');
    const navMenu = document.getElementById('nav-menu');
    const authButtons = document.getElementById('auth-buttons');
    
    if (!navMenu || !authButtons) return;

    if (token) {
        // Authenticated user state
        navMenu.innerHTML = `
            <li class="nav-item ${isActive('index.html')}"><a href="/index.html"><i class="fa-solid fa-house mb-1"></i> Inicio</a></li>
            <li class="nav-item ${isActive('eventos.html')}"><a href="/eventos.html"><i class="fa-solid fa-calendar-days mb-1"></i> Eventos</a></li>
            <li class="nav-item ${isActive('contacto.html')}"><a href="/contacto.html"><i class="fa-solid fa-paper-plane mb-1"></i> Contacto</a></li>
            <li class="nav-item ${isActive('perfil.html')}"><a href="/perfil.html"><i class="fa-solid fa-user mb-1"></i> Mi Perfil</a></li>
        `;
        authButtons.innerHTML = `
            <button id="btn-logout" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
        `;
        
        // Add logout listener
        document.getElementById('btn-logout').addEventListener('click', handleLogout);
    } else {
        // Guest user state
        navMenu.innerHTML = `
            <li class="nav-item ${isActive('index.html')}"><a href="/index.html"><i class="fa-solid fa-house mb-1"></i> Inicio</a></li>
            <li class="nav-item ${isActive('eventos.html')}"><a href="/eventos.html"><i class="fa-solid fa-calendar-days mb-1"></i> Eventos</a></li>
            <li class="nav-item ${isActive('contacto.html')}"><a href="/contacto.html"><i class="fa-solid fa-paper-plane mb-1"></i> Contacto</a></li>
        `;
        authButtons.innerHTML = `
            <a href="/login.html" class="btn btn-outline"><i class="fa-solid fa-right-to-bracket"></i> Ingresar</a>
            <a href="/registro.html" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Registrarse</a>
        `;
    }
}

function isActive(pageName) {
    return window.location.pathname.endsWith(pageName) || 
           (pageName === 'index.html' && (window.location.pathname === '/' || window.location.pathname === '/index'))
           ? 'active' : '';
}

// --- LOGOUT HANDLER ---
async function handleLogout() {
    try {
        await apiFetch('/auth/logout', { method: 'POST' });
    } catch(e) {}
    
    deleteCookie('token');
    deleteCookie('user');
    showToast("Sesión cerrada correctamente.", "success");
    setTimeout(() => {
        window.location.href = '/index.html';
    }, 800);
}

// --- MODAL UTILITIES ---
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

// --- INITIALIZE & ATTACH EVENTS ---
document.addEventListener('DOMContentLoaded', () => {
    // Enable Mobile Hamburger Menu
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('show');
        });
    }

    // Load dynamic Navbar
    updateNavbar();

    // Check query params for notification messages
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('session') === 'expired') {
        showToast("Tu sesión ha expirado. Por favor, ingresa de nuevo.", "error");
    }
    if (urlParams.get('auth') === 'required') {
        showToast("Debes iniciar sesión para ver esa sección.", "error");
    }

    // Modal Close button listeners
    document.querySelectorAll('.modal-close, .btn-modal-close').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const modal = e.target.closest('.modal-overlay');
            if (modal) closeModal(modal.id);
        });
    });

    // Close modal when clicking on the overlay itself
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal(modal.id);
        });
    });

    // --- EXECUTE PAGE SPECIFIC LOGIC ---
    const path = window.location.pathname;
    
    if (path.includes('login.html')) {
        initLoginPage();
    } else if (path.includes('registro.html')) {
        initRegisterPage();
    } else if (path.includes('perfil.html')) {
        initProfilePage();
    } else if (path.includes('contacto.html')) {
        initContactPage();
    } else if (path.includes('eventos.html')) {
        initEventsPage();
    } else {
        // Home page (index.html)
        initHomePage();
    }
});

// ==========================================
//   1. LOGIN PAGE LOGIC
// ==========================================
function initLoginPage() {
    const token = getCookie('token');
    if (token) {
        window.location.href = '/perfil.html';
        return;
    }

    const form = document.getElementById('form-login');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const login = document.getElementById('login').value.trim();
        const password = document.getElementById('password').value;

        if (!login || !password) {
            showToast("Por favor, completa todos los campos.", "error");
            return;
        }

        try {
            const response = await apiFetch('/auth/login', {
                method: 'POST',
                body: JSON.stringify({ login, password })
            });

            const data = await response.json();

            if (response.ok) {
                // Save Token to cookie and user profile to cookies/localStorage
                setCookie('token', data.access_token, 60); // 60 mins
                localStorage.setItem('user', JSON.stringify(data.user));
                
                showToast("¡Inicio de sesión exitoso! Redirigiendo...", "success");
                setTimeout(() => {
                    window.location.href = '/perfil.html';
                }, 1000);
            } else {
                showToast(data.mensaje || "Credenciales incorrectas.", "error");
            }
        } catch (err) {
            showToast("No se pudo conectar con el servidor de autenticación.", "error");
        }
    });
}

// ==========================================
//   2. REGISTER PAGE LOGIC
// ==========================================
function initRegisterPage() {
    const token = getCookie('token');
    if (token) {
        window.location.href = '/perfil.html';
        return;
    }

    const form = document.getElementById('form-registro');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nombre = document.getElementById('nombre').value.trim();
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPass = document.getElementById('confirm-password').value;

        if (!nombre || !username || !email || !password) {
            showToast("Todos los campos son obligatorios.", "error");
            return;
        }

        if (password.length < 6) {
            showToast("La contraseña debe tener al menos 6 caracteres.", "error");
            return;
        }

        if (password !== confirmPass) {
            showToast("Las contraseñas no coinciden.", "error");
            return;
        }

        try {
            const response = await apiFetch('/auth/registro', {
                method: 'POST',
                body: JSON.stringify({ nombre, username, email, password })
            });

            const data = await response.json();

            if (response.ok) {
                showToast("¡Registro completado con éxito! Iniciando redirección...", "success");
                setTimeout(() => {
                    window.location.href = '/login.html';
                }, 1500);
            } else {
                if (data.errores) {
                    const firstError = Object.values(data.errores)[0][0];
                    showToast(firstError, "error");
                } else {
                    showToast(data.mensaje || "Error al registrar el usuario.", "error");
                }
            }
        } catch (err) {
            showToast("Error de conexión con el servidor.", "error");
        }
    });
}

// ==========================================
//   3. PROFILE PAGE LOGIC
// ==========================================
async function initProfilePage() {
    const token = getCookie('token');
    if (!token) {
        window.location.href = '/login.html?auth=required';
        return;
    }

    // Fetch dynamic profile info from API
    let user = null;
    try {
        const response = await apiFetch('/auth/perfil');
        if (response.ok) {
            user = await response.json();
            localStorage.setItem('user', JSON.stringify(user));
        } else {
            throw new Error();
        }
    } catch(err) {
        showToast("Error al obtener los datos de perfil.", "error");
        deleteCookie('token');
        window.location.href = '/login.html?session=expired';
        return;
    }

    // Render User Profile Card Info
    document.getElementById('profile-name').innerText = user.nombre;
    document.getElementById('profile-username').innerText = `@${user.username}`;
    document.getElementById('profile-email').innerText = user.email;
    document.getElementById('profile-role').innerText = user.rol ? user.rol.nombre : 'Deportista';
    document.getElementById('avatar-letter').innerText = user.nombre.charAt(0).toUpperCase();

    // Set Form Inputs values
    const form = document.getElementById('form-perfil');
    if (form) {
        document.getElementById('edit-nombre').value = user.nombre;
        document.getElementById('edit-username').value = user.username;
    }

    // Load and render user events
    loadUserCreatedEvents(user.id);

    // Save profile form listener
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nombre = document.getElementById('edit-nombre').value.trim();
        const username = document.getElementById('edit-username').value.trim();
        const password = document.getElementById('edit-password').value;

        if (!nombre || !username) {
            showToast("Nombre y Nombre de usuario son obligatorios.", "error");
            return;
        }

        const body = { nombre, username };
        if (password) {
            if (password.length < 6) {
                showToast("La contraseña debe tener al menos 6 caracteres.", "error");
                return;
            }
            body.password = password;
        }

        try {
            const response = await apiFetch('/auth/perfil', {
                method: 'PUT',
                body: JSON.stringify(body)
            });

            const data = await response.json();

            if (response.ok) {
                showToast("¡Perfil actualizado con éxito!", "success");
                
                // Update local data and UI
                localStorage.setItem('user', JSON.stringify(data.usuario));
                document.getElementById('profile-name').innerText = data.usuario.nombre;
                document.getElementById('profile-username').innerText = `@${data.usuario.username}`;
                document.getElementById('avatar-letter').innerText = data.usuario.nombre.charAt(0).toUpperCase();
                document.getElementById('edit-password').value = '';
            } else {
                if (data.errores) {
                    showToast(Object.values(data.errores)[0][0], "error");
                } else {
                    showToast(data.mensaje || "Error al actualizar perfil.", "error");
                }
            }
        } catch (err) {
            showToast("No se pudo conectar con el servidor.", "error");
        }
    });
}

// Render events created by the logged-in user
async function loadUserCreatedEvents(userId) {
    const listContainer = document.getElementById('user-events-list');
    if (!listContainer) return;

    listContainer.innerHTML = '<div class="text-center"><i class="fa-solid fa-spinner fa-spin fa-2x"></i><p class="mt-2 text-muted">Cargando tus eventos...</p></div>';

    try {
        const response = await apiFetch('/eventos');
        if (response.ok) {
            const events = await response.json();
            const userEvents = events.filter(e => e.usuario_id === userId);

            if (userEvents.length === 0) {
                listContainer.innerHTML = `
                    <div class="text-center p-5 bg-card border-color" style="border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                        <i class="fa-solid fa-calendar-xmark fa-3x mb-3" style="color: var(--text-muted)"></i>
                        <h3>Aún no has creado eventos</h3>
                        <p class="text-secondary mt-2">¿Tienes una actividad planeada? Crea tu primer evento deportivo.</p>
                        <a href="/eventos.html" class="btn btn-primary mt-4"><i class="fa-solid fa-plus"></i> Crear mi primer Evento</a>
                    </div>
                `;
                return;
            }

            listContainer.innerHTML = `
                <div class="events-grid">
                    ${userEvents.map(event => renderEventCardHtml(event, true)).join('')}
                </div>
            `;

            // Attach dynamic click listeners
            attachEventCardListeners(userEvents);
        }
    } catch(err) {
        listContainer.innerHTML = '<p class="text-center text-rose">Error al cargar la lista de eventos.</p>';
    }
}

// ==========================================
//   4. CONTACT PAGE LOGIC
// ==========================================
function initContactPage() {
    const form = document.getElementById('form-contacto');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const nombre = document.getElementById('contacto-nombre').value.trim();
        const email = document.getElementById('contacto-email').value.trim();
        const asunto = document.getElementById('contacto-asunto').value.trim();
        const mensaje = document.getElementById('contacto-mensaje').value.trim();

        if (!nombre || !email || !asunto || !mensaje) {
            showToast("Por favor, rellena todos los campos del formulario.", "error");
            return;
        }

        // Mock submission success (since it's a contact form)
        showToast("¡Mensaje enviado con éxito! Nos comunicaremos contigo pronto.", "success");
        form.reset();
    });
}

// ==========================================
//   5. EXPLORE EVENTS PAGE LOGIC
// ==========================================
let allEventsCache = [];

async function initEventsPage() {
    const token = getCookie('token');
    const btnCreateTrigger = document.getElementById('btn-create-event-trigger');
    
    // 1. Check dynamic visibility of creation triggers
    if (token) {
        if (btnCreateTrigger) btnCreateTrigger.style.display = 'inline-flex';
    } else {
        if (btnCreateTrigger) btnCreateTrigger.style.display = 'none';
    }

    // 2. Fetch and render all events
    await loadEvents();

    // 3. Search & Filter Real-Time Listeners
    const searchInput = document.getElementById('search-event');
    const categorySelect = document.getElementById('filter-category');

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            filterAndRenderCachedEvents();
        });
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', () => {
            filterAndRenderCachedEvents();
        });
    }

    // Check if redirect has a category filter pre-selected in URL
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('categoria');
    if (categoryParam && categorySelect) {
        categorySelect.value = categoryParam;
        filterAndRenderCachedEvents();
    }

    // 4. Create Event Form Submit Listener
    const formCreate = document.getElementById('form-create-evento');
    if (formCreate) {
        formCreate.addEventListener('submit', async (e) => {
            e.preventDefault();

            const titulo = document.getElementById('create-titulo').value.trim();
            const categoria = document.getElementById('create-categoria').value;
            const fecha = document.getElementById('create-fecha').value;
            const lugar = document.getElementById('create-lugar').value.trim();
            const descripcion = document.getElementById('create-descripcion').value.trim();
            const imagen = document.getElementById('create-imagen').value.trim();

            if (!titulo || !categoria || !fecha || !lugar || !descripcion) {
                showToast("Todos los campos obligatorios deben ser completados.", "error");
                return;
            }

            try {
                const response = await apiFetch('/eventos', {
                    method: 'POST',
                    body: JSON.stringify({ titulo, categoria, fecha, lugar, descripcion, imagen })
                });

                const data = await response.json();

                if (response.ok) {
                    showToast("¡Evento creado correctamente!", "success");
                    closeModal('modal-create-event');
                    formCreate.reset();
                    await loadEvents(); // Refresh Grid
                } else {
                    showToast(data.mensaje || "Error al crear el evento.", "error");
                }
            } catch(err) {
                showToast("No se pudo conectar con el servidor.", "error");
            }
        });
    }

    // 5. Update Event Form Submit Listener
    const formEdit = document.getElementById('form-edit-evento');
    if (formEdit) {
        formEdit.addEventListener('submit', async (e) => {
            e.preventDefault();

            const id = document.getElementById('edit-id').value;
            const titulo = document.getElementById('edit-titulo').value.trim();
            const categoria = document.getElementById('edit-categoria').value;
            const fecha = document.getElementById('edit-fecha').value;
            const lugar = document.getElementById('edit-lugar').value.trim();
            const descripcion = document.getElementById('edit-descripcion').value.trim();
            const imagen = document.getElementById('edit-imagen').value.trim();

            if (!titulo || !categoria || !fecha || !lugar || !descripcion) {
                showToast("Completa los campos requeridos.", "error");
                return;
            }

            try {
                const response = await apiFetch(`/eventos/${id}`, {
                    method: 'PUT',
                    body: JSON.stringify({ titulo, categoria, fecha, lugar, descripcion, imagen })
                });

                const data = await response.json();

                if (response.ok) {
                    showToast("¡Evento deportivo actualizado!", "success");
                    closeModal('modal-edit-event');
                    closeModal('modal-event-detail');
                    await loadEvents(); // Refresh Grid
                } else {
                    showToast(data.mensaje || "Error al actualizar evento.", "error");
                }
            } catch(err) {
                showToast("Error de conexión.", "error");
            }
        });
    }
}

async function loadEvents() {
    const grid = document.getElementById('events-grid-explore');
    if (!grid) return;

    grid.innerHTML = '<div class="text-center" style="grid-column: 1/-1;"><i class="fa-solid fa-spinner fa-spin fa-3x mb-3" style="color: var(--accent-cyan)"></i><p>Explorando eventos...</p></div>';

    try {
        const response = await apiFetch('/eventos');
        if (response.ok) {
            allEventsCache = await response.json();
            filterAndRenderCachedEvents();
        } else {
            grid.innerHTML = '<p class="text-center" style="grid-column: 1/-1;">Error al recuperar los eventos del servidor.</p>';
        }
    } catch(err) {
        grid.innerHTML = '<p class="text-center" style="grid-column: 1/-1;">No se pudo conectar con el servidor.</p>';
    }
}

function filterAndRenderCachedEvents() {
    const grid = document.getElementById('events-grid-explore');
    if (!grid) return;

    const query = document.getElementById('search-event')?.value.toLowerCase().trim() || '';
    const selectedCategory = document.getElementById('filter-category')?.value || '';

    let filtered = allEventsCache;

    // Apply Real-time filters
    if (query) {
        filtered = filtered.filter(e => 
            e.titulo.toLowerCase().includes(query) || 
            e.descripcion.toLowerCase().includes(query) ||
            e.lugar.toLowerCase().includes(query)
        );
    }

    if (selectedCategory) {
        filtered = filtered.filter(e => e.categoria === selectedCategory);
    }

    if (filtered.length === 0) {
        grid.innerHTML = `
            <div class="text-center p-5" style="grid-column: 1/-1; background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                <i class="fa-solid fa-basketball-ball fa-bounce fa-3x mb-3" style="color: var(--text-muted)"></i>
                <h3>No se encontraron eventos</h3>
                <p class="text-secondary mt-2">Prueba cambiando tu búsqueda o seleccionando otra categoría.</p>
            </div>
        `;
        return;
    }

    grid.innerHTML = filtered.map(event => renderEventCardHtml(event)).join('');

    // Attach Click Event listeners to cards
    attachEventCardListeners(filtered);
}

// ==========================================
//   6. HOME PAGE LOGIC (index.html)
// ==========================================
async function initHomePage() {
    // Load Upcoming Events (limit to 3)
    const upcomingContainer = document.getElementById('upcoming-events-grid');
    if (!upcomingContainer) return;

    upcomingContainer.innerHTML = '<div class="text-center" style="grid-column: 1/-1;"><i class="fa-solid fa-spinner fa-spin fa-2x mb-2"></i><p>Cargando próximos eventos...</p></div>';

    try {
        const response = await apiFetch('/eventos');
        if (response.ok) {
            const events = await response.json();
            
            // Get upcoming events sorted chronologically by date
            const upcoming = events
                .filter(e => new Date(e.fecha) >= new Date().setHours(0,0,0,0))
                .slice(0, 3); // top 3

            if (upcoming.length === 0) {
                // If no upcoming, take latest 3 events or show dynamic mockups
                const latest = events.slice(0, 3);
                if (latest.length === 0) {
                    upcomingContainer.innerHTML = `
                        <div class="text-center p-5" style="grid-column: 1/-1; background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                            <i class="fa-regular fa-calendar-days fa-3x mb-3" style="color: var(--text-muted)"></i>
                            <h3>No hay eventos activos programados</h3>
                            <p class="text-secondary mt-2">¡Sé el primero en programar una actividad deportiva!</p>
                            <a href="/eventos.html" class="btn btn-primary mt-4"><i class="fa-solid fa-plus"></i> Crear Evento</a>
                        </div>
                    `;
                    return;
                }
                upcomingContainer.innerHTML = latest.map(e => renderEventCardHtml(e)).join('');
                attachEventCardListeners(latest);
                return;
            }

            upcomingContainer.innerHTML = upcoming.map(e => renderEventCardHtml(e)).join('');
            attachEventCardListeners(upcoming);
        }
    } catch(err) {
        upcomingContainer.innerHTML = '<p class="text-center text-rose" style="grid-column: 1/-1;">Error de conexión.</p>';
    }
}


// ==========================================
//   REUSABLE FRONTEND COMPONENT RENDERERS
// ==========================================

function renderEventCardHtml(event, isProfile = false) {
    const fechaFormatted = formatFecha(event.fecha);
    const organizerName = event.usuario ? event.usuario.nombre : 'Organizador';
    const firstLetter = organizerName.charAt(0).toUpperCase();

    // Map Category Icon
    let catIcon = 'fa-volleyball';
    const catLower = event.categoria.toLowerCase();
    if (catLower.includes('fútbol') || catLower.includes('futbol')) catIcon = 'fa-futbol';
    else if (catLower.includes('baloncesto') || catLower.includes('basquet') || catLower.includes('basketball')) catIcon = 'fa-basketball';
    else if (catLower.includes('ciclismo') || catLower.includes('bici')) catIcon = 'fa-bicycle';
    else if (catLower.includes('senderismo') || catLower.includes('trekking') || catLower.includes('montaña')) catIcon = 'fa-mountain-sun';
    else if (catLower.includes('atletismo') || catLower.includes('correr') || catLower.includes('running')) catIcon = 'fa-running';

    return `
        <div class="event-card" data-id="${event.id}">
            <div class="event-banner">
                <span class="event-badge"><i class="fa-solid ${catIcon}"></i> ${event.categoria}</span>
                <img src="${event.imagen || '/img/recreativo.jpg'}" alt="${event.titulo}" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 180%22><rect width=%22100%25%22 height=%22100%25%22 fill=%22%231e293b%22/><text x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Outfit%22 font-size=%2222%22 fill=%22%233b82f6%22 font-weight=%22bold%22>${event.categoria}</text></svg>'">
            </div>
            <div class="event-body">
                <h3 class="event-title">${event.titulo}</h3>
                <p class="event-desc">${event.descripcion}</p>
                <div class="event-meta">
                    <div class="meta-item">
                        <i class="fa-regular fa-calendar-days"></i>
                        <span>${fechaFormatted}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>${event.lugar}</span>
                    </div>
                </div>
            </div>
            <div class="event-footer">
                <div class="organizer-info">
                    <div class="avatar-mini">${firstLetter}</div>
                    <span>${organizerName}</span>
                </div>
                <div class="event-action-btn card-view-details" data-id="${event.id}">
                    <span>Ver Más</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </div>
        </div>
    `;
}

function attachEventCardListeners(eventsList) {
    document.querySelectorAll('.card-view-details').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const eventId = parseInt(e.currentTarget.getAttribute('data-id'));
            const event = eventsList.find(ev => ev.id === eventId);
            if (event) showEventDetails(event);
        });
    });
}

// format date helper
function formatFecha(fechaString) {
    try {
        const f = new Date(fechaString);
        return f.toLocaleString('es-ES', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch(e) {
        return fechaString;
    }
}

// Show Detailed event details in Modal
function showEventDetails(event) {
    const modalDetail = document.getElementById('modal-event-detail');
    if (!modalDetail) return;

    // Fill Modal Contents
    document.getElementById('detail-titulo').innerText = event.titulo;
    document.getElementById('detail-categoria').innerText = event.categoria;
    document.getElementById('detail-fecha').innerText = formatFecha(event.fecha);
    document.getElementById('detail-lugar').innerText = event.lugar;
    document.getElementById('detail-descripcion').innerText = event.descripcion;
    document.getElementById('detail-organizador').innerText = event.usuario ? event.usuario.nombre : 'Organizador';
    document.getElementById('detail-avatar-letter').innerText = (event.usuario ? event.usuario.nombre : 'O').charAt(0).toUpperCase();

    // Banner image setup
    const banner = document.getElementById('detail-banner');
    if (banner) {
        banner.src = event.imagen || '/img/recreativo.jpg';
        banner.onerror = function() {
            this.src = `data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 600 250%22><rect width=%22100%25%22 height=%22100%25%22 fill=%22%231e293b%22/><text x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Outfit%22 font-size=%2228%22 fill=%22%233b82f6%22 font-weight=%22bold%22>${event.categoria}</text></svg>`;
        };
    }

    // Owner specific dynamic buttons (Edit & Delete)
    const token = getCookie('token');
    const actionsWrapper = document.getElementById('detail-owner-actions');
    
    if (token) {
        const storedUser = localStorage.getItem('user');
        const userObj = storedUser ? JSON.parse(storedUser) : null;
        
        // Show buttons if logged user is the creator OR is system admin (role_id = 0)
        if (userObj && (event.usuario_id === userObj.id || userObj.role_id === 0)) {
            actionsWrapper.style.display = 'flex';
            actionsWrapper.innerHTML = `
                <button id="btn-edit-event-trigger" class="btn btn-outline"><i class="fa-solid fa-pen-to-square"></i> Editar Evento</button>
                <button id="btn-delete-event" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
            `;

            // Attach listeners to owner controls
            document.getElementById('btn-edit-event-trigger').addEventListener('click', () => {
                openEditEventModal(event);
            });

            document.getElementById('btn-delete-event').addEventListener('click', () => {
                confirmDeleteEvent(event.id);
            });
        } else {
            actionsWrapper.style.display = 'none';
        }
    } else {
        actionsWrapper.style.display = 'none';
    }

    openModal('modal-event-detail');
}

// Open Edit Event Modal and fill form inputs
function openEditEventModal(event) {
    const modal = document.getElementById('modal-edit-event');
    if (!modal) return;

    // Fill inputs
    document.getElementById('edit-id').value = event.id;
    document.getElementById('edit-titulo').value = event.titulo;
    document.getElementById('edit-categoria').value = event.categoria;
    
    // Format date local string for datetime-local input type (YYYY-MM-DDTHH:MM)
    const d = new Date(event.fecha);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    document.getElementById('edit-fecha').value = `${year}-${month}-${day}T${hours}:${minutes}`;
    
    document.getElementById('edit-lugar').value = event.lugar;
    document.getElementById('edit-descripcion').value = event.descripcion;
    document.getElementById('edit-imagen').value = event.imagen || '';

    openModal('modal-edit-event');
}

// Request deletion confirm from client
async function confirmDeleteEvent(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este evento deportivo? Esta acción no se puede deshacer.")) {
        try {
            const response = await apiFetch(`/eventos/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                showToast("Evento deportivo eliminado con éxito.", "success");
                closeModal('modal-event-detail');
                
                // Refresh list depending on current page
                if (window.location.pathname.includes('perfil.html')) {
                    const storedUser = localStorage.getItem('user');
                    const user = storedUser ? JSON.parse(storedUser) : null;
                    if (user) loadUserCreatedEvents(user.id);
                } else if (window.location.pathname.includes('eventos.html')) {
                    await loadEvents();
                }
            } else {
                const data = await response.json();
                showToast(data.mensaje || "Error al eliminar el evento.", "error");
            }
        } catch(err) {
            showToast("Error de conexión al eliminar el evento.", "error");
        }
    }
}
