<header class="position-fixed top-0 start-0 end-0 bg-white border-bottom shadow-sm" style="z-index: 1040; height: 60px;">
    <div class="d-flex align-items-center justify-content-between px-3 py-2 px-lg-4 h-100">
        <!-- Logo dan Toggle Sidebar -->
        <div class="d-flex align-items-center">
            <button id="sidebar-toggle" class="btn btn-outline-secondary me-3 d-lg-none">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex align-items-center">
                <i class="fas fa-tools text-primary me-2 fs-5"></i>
                <span class="fw-bold text-dark d-none d-md-inline">Admin Panel - E-Jarkom SMK</span>
            </div>
        </div>

        <!-- Menu Kanan -->
        <div class="d-flex align-items-center">
            <!-- Notifikasi -->
            <div class="position-relative me-3">
                <button id="notification-toggle" class="btn btn-outline-secondary position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </button>
                @include('admin.partials.norifikasi')
            </div>

            <!-- Profile Info -->
            <div class="d-flex align-items-center">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                    <i class="fas fa-user-shield text-white" style="font-size: 0.875rem;"></i>
                </div>
                <div class="d-none d-sm-block">
                    <div class="fw-medium text-dark">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
        </div>
    </div>
</header>
