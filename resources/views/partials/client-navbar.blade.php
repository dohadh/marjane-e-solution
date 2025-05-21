<nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between">
        <div>
            <a href="{{ route('clients.dashboard') }}" class="text-lg font-bold">Espace Client</a>
        </div>
        <form method="POST" action="{{ route('clients.logout') }}">
            @csrf
            <button type="submit" class="text-red-500">Déconnexion</button>
        </form>
    </div>
</nav>
