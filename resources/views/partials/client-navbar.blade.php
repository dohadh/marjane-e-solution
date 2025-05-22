<nav class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <a href="{{ route('clients.dashboard') }}" class="text-xl font-bold text-blue-600 hover:text-blue-800">Espace Client</a>
        
        <div>
            <form method="POST" action="{{ route('clients.logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav>
