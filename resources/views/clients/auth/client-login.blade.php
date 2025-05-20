

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Connexion Client</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- si tu utilises Tailwind ou autre --}}
</head>
<body>
    <div class="container mx-auto max-w-md mt-10 p-6 border rounded shadow">

        <h1 class="text-2xl font-bold mb-6 text-center">Connexion Client</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('clients.login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block mb-1 font-semibold">Adresse e-mail</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
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
                    autocomplete="current-password"
                    class="w-full border px-3 py-2 rounded"
                />
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        class="mr-2"
                        {{ old('remember') ? 'checked' : '' }}
                    />
                    Se souvenir de moi
                </label>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    Se connecter
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm">
            Pas encore inscrit ? 
            <a href="{{ route('clients.register') }}" class="text-blue-600 hover:underline">Créer un compte client</a>
        </p>
    </div>
</body>
</html>
