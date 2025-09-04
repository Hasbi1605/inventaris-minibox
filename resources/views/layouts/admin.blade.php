<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Inventaris Barbershop') }}</title>
    
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/sidebar.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <!-- Sidebar -->
    @include('layouts.partials.sidebar')
    
    <!-- Main Content -->
    <main id="main-content" class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-300">
        <!-- Navbar -->
        @include('layouts.partials.navbar')
        
        <!-- Page Content -->
        <div class="w-full px-6 py-6 mx-auto">
            @yield('content')
            
            <!-- Footer -->
            @include('layouts.partials.footer')
        </div>
    </main>
    
    <!-- Fixed Plugin -->
    @include('layouts.partials.configurator')
    
    <!-- Scripts -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js') }}"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const expandButton = document.getElementById('expand-button');
            const sidebar = document.getElementById('sidenav-main');
            const mainContent = document.getElementById('main-content');
            
            // Check if sidebar state is saved in localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            // Apply saved state
            if (isCollapsed) {
                sidebar.classList.add('sidebar-collapsed');
                if (mainContent) mainContent.classList.add('main-content-collapsed');
            }
            
            // Toggle function
            function toggleSidebar() {
                sidebar.classList.toggle('sidebar-collapsed');
                if (mainContent) mainContent.classList.toggle('main-content-collapsed');
                
                // Save state to localStorage
                const collapsed = sidebar.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed);
                
                // Trigger resize event for charts and other components
                setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                }, 300);
            }
            
            // Add click event listeners for both buttons
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }
            
            if (expandButton) {
                expandButton.addEventListener('click', toggleSidebar);
            }
            
            // Keyboard accessibility - toggle with Ctrl+B
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'b') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
            
            // Mobile responsiveness - auto collapse on small screens
            function checkScreenSize() {
                if (window.innerWidth < 1280) {
                    // On mobile, don't auto-collapse if user hasn't manually collapsed
                    if (!localStorage.getItem('sidebarCollapsed')) {
                        sidebar.classList.remove('sidebar-collapsed');
                        if (mainContent) mainContent.classList.remove('main-content-collapsed');
                    }
                } else {
                    // On desktop, apply saved state
                    if (!localStorage.getItem('sidebarCollapsed') || localStorage.getItem('sidebarCollapsed') === 'false') {
                        sidebar.classList.remove('sidebar-collapsed');
                        if (mainContent) mainContent.classList.remove('main-content-collapsed');
                    }
                }
            }
            
            // Check screen size on resize
            window.addEventListener('resize', checkScreenSize);
            
            // Initial check
            checkScreenSize();
            
            // Mobile overlay for closing sidebar
            function createMobileOverlay() {
                const overlay = document.createElement('div');
                overlay.id = 'sidebar-overlay';
                overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 xl:hidden transition-opacity duration-300';
                overlay.style.display = 'none';
                document.body.appendChild(overlay);
                
                overlay.addEventListener('click', function() {
                    if (window.innerWidth < 1280) {
                        sidebar.classList.add('sidebar-collapsed');
                        overlay.style.display = 'none';
                    }
                });
                
                return overlay;
            }
            
            const overlay = createMobileOverlay();
            
            // Show/hide overlay on mobile
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                        if (window.innerWidth < 1280) {
                            overlay.style.display = isCollapsed ? 'none' : 'block';
                        } else {
                            overlay.style.display = 'none';
                        }
                    }
                });
            });
            
            observer.observe(sidebar, { attributes: true });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
