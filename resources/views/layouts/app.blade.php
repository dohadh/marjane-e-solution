<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Marjan Holding') }} - @yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --light: #f8f9fc;
            --dark: #5a5c69;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #app-container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .nav-link {
            color: var(--dark);
            margin: 0.2rem 0.5rem;
            border-radius: 5px;
            transition: all 0.2s;
        }

        .sidebar-menu .nav-link:hover {
            background-color: rgba(78, 115, 223, 0.1);
            color: var(--primary);
        }

        .sidebar-menu .nav-link.active {
            background-color: rgba(78, 115, 223, 0.2);
            color: var(--primary);
            font-weight: 500;
        }

        .sidebar-menu .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        #main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .navbar {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            background: white;
            padding: 0.75rem 1.5rem;
        }

        .footer {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 -0.15rem 0.5rem 0 rgba(58, 59, 69, 0.05);
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.5rem 0 rgba(58, 59, 69, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.2);
        }

        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -250px;
            }
            .sidebar.show {
                left: 0;
            }
            #main-content {
                margin-left: 0 !important;
            }
        }
    </style>

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="app-container">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div id="main-content">
            <!-- Header -->
            @include('layouts.header')

            <!-- Page Content -->
            <main class="container-fluid py-4">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>

    <!-- ✅ Scripts à la fin -->

    <!-- Bootstrap Bundle avec Popper.js intégré -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('#sidebarToggle');
            const sidebar = document.querySelector('.sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = event.target === sidebarToggle || 
                                          sidebarToggle.contains(event.target);
                    
                    if (!isClickInsideSidebar && !isClickOnToggle) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
