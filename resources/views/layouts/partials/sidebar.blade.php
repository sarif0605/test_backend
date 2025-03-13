<nav class="sb-sidenav accordion sb-sidenav-dark mt-4" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <!-- Dashboard -->
            <a class="nav-link d-flex align-items-center py-3 px-3 rounded {{ request()->routeIs('dashboard') ? 'active bg-light text-dark fw-bold mx-2' : '' }}"
               href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon me-3 text-primary"><i class="fas fa-home"></i></div>
                <span class="{{ request()->routeIs('dashboard') ? 'text-dark' : 'text-light' }}">Dashboard</span>
            </a>

            <a class="nav-link d-flex align-items-center py-3 px-3 rounded {{ request()->routeIs('category') ? 'active bg-light text-dark fw-bold mx-2' : '' }}"
                href="{{ route('category') }}">
                 <div class="sb-nav-link-icon me-3 text-primary"><i class="fas fa-th-large"></i></div>
                 <span class="{{ request()->routeIs('category') ? 'text-dark' : 'text-light' }}">Category</span>
             </a>

            <!-- Content -->
            <a class="nav-link d-flex align-items-center py-3 px-3 rounded {{ request()->routeIs('content') ? 'active bg-light text-dark fw-bold mx-2' : '' }}"
               href="{{ route('content') }}">
                <div class="sb-nav-link-icon me-3 text-primary"><i class="fas fa-book"></i></div>
                <span class="{{ request()->routeIs('content') ? 'text-dark' : 'text-light' }}">Content</span>
            </a>

            <div class="border-top my-3"></div>

            <div class="ps-3 py-2 text-uppercase fw-bold small text-muted">
                PROFILE
            </div>

            <!-- Profile -->
            <a class="nav-link d-flex align-items-center py-3 px-3 rounded {{ request()->routeIs('profile.edit') ? 'active bg-light text-dark fw-bold mx-2' : '' }}"
               href="{{ route('profile.edit') }}">
                <div class="sb-nav-link-icon me-3 text-primary"><i class="fas fa-cog"></i></div>
                <span class="{{ request()->routeIs('profile.edit') ? 'text-dark' : 'text-light' }}">Profile</span>
            </a>

            <!-- Kalender -->
            <a class="nav-link d-flex align-items-center py-3 px-3 rounded {{ request()->routeIs('calender') ? 'active bg-light text-dark fw-bold mx-2' : '' }}"
               href="{{ route('calender') }}">
                <div class="sb-nav-link-icon me-3 text-primary"><i class="fas fa-calendar-alt"></i></div>
                <span class="{{ request()->routeIs('calender') ? 'text-dark' : 'text-light' }}">Kalender</span>
            </a>

            <!-- Logout -->
            <a class="nav-link d-flex align-items-center py-3 mt-3 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <div class="sb-nav-link-icon me-3"><i class="fas fa-sign-out-alt"></i></div>
                Log Out
            </a>
        </div>
    </div>
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