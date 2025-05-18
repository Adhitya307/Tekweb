<style>
    .navbar {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1rem;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        color: #007bff;
        letter-spacing: 1px;
    }

    .nav-link {
        font-weight: 600;
        color: #555;
        transition: color 0.3s ease;
    }
    .nav-link:hover, .nav-link:focus {
        color: #007bff;
        text-decoration: none;
    }

    .btn-profile {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 0.375rem 1rem;
        font-size: 0.9rem;
        color: #007bff;
        border: 2px solid #007bff;
        transition: background-color 0.3s, color 0.3s ease;
        text-decoration: none;
    }

    .btn-profile:hover, .btn-profile:focus {
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
    }

    .btn-profile svg {
        width: 20px;
        height: 20px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">TaskTim</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
            </ul>

            <div class="d-flex ms-auto">
                <?php if (isset($user) && !empty($user['nama'])): ?>
                    <a href="/profile" class="btn btn-profile">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z"/>
                            <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <?= esc($user['nama']) ?>
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline-primary">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
