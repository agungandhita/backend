<!DOCTYPE html>
<html lang="id">
<head>
    @include('admin.partials.start')
</head>
<body class="bg-light">
    @include('admin.partials.header')
    @include('admin.partials.sidebar')

    <!-- Sidebar Overlay untuk Mobile -->
    <div id="sidebar-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none" style="z-index: 1045;"></div>

    <!-- Main Content Area -->
    <div class="main-content" style="margin-left: 0; transition: margin-left 0.3s ease;">
        <main class="container-fluid" style="padding-top: 5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
            @yield('content')
            @yield('container')
        </main>
    </div>

    @include('admin.partials.end')
    @include('sweetalert::alert')
    @stack('scripts')

    <!-- JavaScript untuk Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mainContent = document.querySelector('.main-content');

            // Fungsi untuk toggle sidebar mobile
            function toggleSidebar() {
                if (sidebar && sidebarOverlay) {
                    sidebar.style.transform = 'translateX(0)';
                    sidebarOverlay.classList.remove('d-none');
                }
            }

            // Fungsi untuk close sidebar
            function closeSidebar() {
                if (sidebar && sidebarOverlay) {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebarOverlay.classList.add('d-none');
                }
            }

            // Event listeners
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Fungsi untuk adjust layout berdasarkan ukuran layar
            function adjustLayout() {
                if (!mainContent || !sidebar) return;

                if (window.innerWidth >= 992) { // lg breakpoint
                    mainContent.style.marginLeft = '240px';
                    sidebar.style.transform = 'translateX(0)';
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.add('d-none');
                    }
                } else {
                    mainContent.style.marginLeft = '0';
                    sidebar.style.transform = 'translateX(-100%)';
                }
            }

            // Initial adjustment dan resize listener
            adjustLayout();
            window.addEventListener('resize', adjustLayout);
        });
    </script>
</body>
</html>

