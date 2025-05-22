<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Marjan Holding') }} - @yield('title', 'Client Marjan Holding')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #1E3A8A;
            --secondary: #6c757d;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #E0F7FF 0%, var(--primary) 100%);
            min-height: 100vh;
            margin: 0;
        }

        .main-content {
            margin-left: 250px; /* Fix pour correspondre à la largeur du sidebar */
            padding: 20px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="d-flex flex-column">

<div class="d-flex">
    {{-- Sidebar --}}
    @include('clients.layouts.sidebar')

    <div class="flex-grow-1 d-flex flex-column">
        {{-- Header --}}
        @include('clients.layouts.header')

        {{-- Contenu principal --}}
        <main class="main-content">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('clients.layouts.footer')
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
