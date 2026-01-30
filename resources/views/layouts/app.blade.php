<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 dark:bg-slate-950">
    <div x-data="{ 
        sidebarOpen: window.innerWidth >= 1024,
        init() {
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    this.sidebarOpen = true;
                } else {
                    this.sidebarOpen = false;
                }
            });
        }
    }" @resize.window="init()">
        <!-- Navbar -->
        <x-navbar />
        
        <!-- Sidebar -->
        <x-sidebar />
        
        <!-- Main Content with top padding for fixed navbar -->
        <div class="pt-[73px] transition-all duration-300" :class="sidebarOpen ? 'lg:ml-64' : ''">
            <main class="min-h-screen p-4 sm:p-6 lg:p-8 bg-slate-50 dark:bg-slate-950">
                @yield('content')
            </main>

            <x-footer />
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alert auto-dismiss
            const alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>
</html>
