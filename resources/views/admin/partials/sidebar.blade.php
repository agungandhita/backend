<!-- Sidebar -->
<aside id="sidebar" class="sidebar bg-white shadow-sm position-fixed top-0 start-0 h-100 d-lg-block" style="width: 240px; z-index: 1050; transform: translateX(-100%); transition: transform 0.3s ease; margin-top: 60px;">

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav p-3">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Users Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.users.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-users me-2"></i>
                    Kelola Pengguna
                </a>
            </li>

            <!-- Categories Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.categories.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-tags me-2"></i>
                    Kelola Kategori
                </a>
            </li>

            <!-- Tools Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.tools.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.tools.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-tools me-2"></i>
                    Kelola Alat Teknik
                </a>
            </li>

            <!-- Videos Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.videos.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.videos.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-play-circle me-2"></i>
                    Kelola Video
                </a>
            </li>

            <!-- Quiz Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.quizzes.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.quizzes.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-question-circle me-2"></i>
                    Kelola Kuis
                </a>
            </li>

            <!-- Scores Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.scores.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.scores.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-chart-line me-2"></i>
                    Kelola Skor
                </a>
            </li>

            <!-- Statistics -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.scores.statistics') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('admin.scores.statistics') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik
                </a>
            </li>
        </ul>

        <!-- Logout Button -->
        <div class="mt-3 pt-3 border-top">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="position-absolute bottom-0 start-0 end-0 p-3 border-top bg-light">
        <div class="d-flex align-items-center p-2 bg-white rounded shadow-sm">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                <i class="fas fa-user-shield text-white" style="font-size: 0.875rem;"></i>
            </div>
            <div class="flex-grow-1 text-truncate">
                <p class="mb-0 fw-medium" style="font-size: 0.875rem;">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="mb-0 text-muted" style="font-size: 0.75rem;">Administrator</p>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay untuk Mobile -->
<div id="sidebar-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-lg-none d-none" style="z-index: 1020;"></div>
