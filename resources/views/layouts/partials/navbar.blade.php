<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3 d-flex align-items-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/adhivasindo.png') }}" alt="Logo" style="height: 40px; width: auto; margin-right: 10px;">
        ADHIVASINDO
    </a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-light" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Search Bar -->
    <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search class..."
                   aria-label="Search class..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-outline-secondary" id="btnNavbarSearch" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Icons Section -->
    <ul class="navbar-nav d-flex align-items-center">
        <!-- Notifications -->
        <li class="nav-item me-3">
            <a class="nav-link position-relative text-light" href="#">
                <i class="fas fa-bell fa-sm"></i>
                <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </a>
        </li>

        <!-- Messages -->
        <li class="nav-item me-3">
            <a class="nav-link position-relative text-light" href="#">
                <i class="fas fa-envelope fa-sm"></i>
                <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                    1
                </span>
            </a>
        </li>

        <!-- User Profile -->
        <li class="nav-item dropdown me-3">
            <a class="nav-link dropdown-toggle text-light" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-sm"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                </li>
            </ul>
        </li>

        <!-- Settings -->
        <li class="nav-item">
            <a class="nav-link text-light" href="#">
                <i class="fas fa-cog fa-sm"></i>
            </a>
        </li>
    </ul>
</nav>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
