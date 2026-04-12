<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <!-- theme script must run early to prevent flash of incorrect theme -->
    <script>
        (function() {
            let theme = localStorage.getItem('theme') || 'system';
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (theme === 'system' && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script>
        window.Laravel = {
            @auth
                userId: {{ auth()->id() }},
            @else
                userId: null,
            @endauth
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
</head>
<body class="bg-slate-50 dark:bg-slate-950">
    <div x-data="{ 
        sidebarOpen: window.innerWidth >= 1024 ? (localStorage.getItem('sidebarOpen') === 'true' || localStorage.getItem('sidebarOpen') === null) : false,
        init() {
            // Watch untuk perubahan sidebarOpen dan simpan ke localStorage hanya untuk desktop
            this.$watch('sidebarOpen', value => {
                if (window.innerWidth >= 1024) {
                    localStorage.setItem('sidebarOpen', value);
                }
            });
            
            // Handle resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    // Di desktop, gunakan status yang tersimpan
                    const saved = localStorage.getItem('sidebarOpen');
                    if (saved === null) {
                        this.sidebarOpen = true;
                        localStorage.setItem('sidebarOpen', true);
                    } else {
                        this.sidebarOpen = saved === 'true';
                    }
                } else {
                    // Di mobile/tablet, selalu tutup
                    this.sidebarOpen = false;
                }
            });
        }
    }" @resize.window="init()">
        <!-- Navbar -->
        <x-navbar />
        
        <!-- Sidebar -->
        <x-sidebar.sidebar />
        
        <!-- Main Content with top padding for fixed navbar -->
        <div class="pt-[73px] transition-all duration-300" 
             :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">
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

            // Initialize Quill editors
            const editors = document.querySelectorAll('.editor-wrapper [id$="_editor"]');
            editors.forEach(editor => {
                const editorId = editor.id;
                const inputId = editorId.replace('_editor', '');
                const input = document.getElementById(inputId);
                const currentValue = input ? input.value : '';

                const quill = new Quill('#' + editorId, {
                    theme: 'snow',
                    placeholder: 'Tulis sesuatu...',
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['blockquote', 'code-block'],
                            ['link', 'image'],
                            ['clean']
                        ]
                    }
                });

                // Set initial value
                if (currentValue) {
                    quill.root.innerHTML = currentValue;
                }

                // Sync content to hidden input before form submission
                quill.on('text-change', function() {
                    if (input) {
                        input.value = quill.root.innerHTML;
                    }
                });

                // Sync on form submit
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function() {
                        if (input) {
                            input.value = quill.root.innerHTML;
                        }
                    });
                });
            });
        });
    </script>

    @livewireScripts
</body>
</html>