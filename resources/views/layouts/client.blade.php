{{-- resources/views/layouts/client.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Marjan Client</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('partials.client-navbar')

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
