

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inscription Client</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto max-w-md mt-10 p-6 border rounded shadow">

        <h1 class="text-2xl font-bold mb-6 text-center">Inscription Client</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('clients.register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block mb-1 font-semibold">Nom complet</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="w-full border px-3 py-2 rounded"
                />
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-1 font-semibold">Adresse e-mail</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full border px-3 py-2 rounded"
                />
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-1 font-semibold">Mot de passe</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full border px-3 py-2 rounded"
                />
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block mb-1 font-semibold">Confirmer le mot de passe</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    class="w-full border px-3 py-2 rounded"
                />
            </div>

            <div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                    S'inscrire
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm">
            Déjà un compte ? 
            <a href="{{ route('clients.login') }}" class="text-green-600 hover:underline">Se connecter</a>
        </p>
    </div>
</body>
</html>
