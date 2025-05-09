<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">TaskTim</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Daftar Tugas</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
            </ul>
            <span class="navbar-text me-3">Halo, <strong><?= esc($user['nama']) ?></strong></span>
            <a href="/logout" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</nav>
