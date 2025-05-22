<div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow-sm"
     style="width: 250px; min-height: 100vh; position: fixed;">

    <!-- Logo et titre -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/logomarjan.jpg') }}" alt="Logo Client" style="max-width: 200px;" class="mb-2">
        <h5 class="fw-bold text-primary">Espace Client</h5>
    </div>

    <!-- Affichage client connecté -->
    @if(Auth::guard('client')->check())
        <div class="alert alert-primary py-2 px-3 text-center">
            <small>Connecté en tant que :</small>
            <div class="fw-semibold">{{ Auth::guard('client')->user()->name }}</div>
        </div>
    @endif

    <!-- Menu navigation -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="{{ route('clients.dashboard') }}"
               class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center {{ request()->routeIs('clients.dashboard') ? 'bg-primary text-white' : '' }}">
                <i class="bi bi-house-door-fill me-2"></i> Tableau de bord
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('clients.profile') }}"
               class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center {{ request()->routeIs('clients.profile') ? 'bg-primary text-white' : '' }}">
                <i class="bi bi-person-lines-fill me-2"></i> Mon profil
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('produits.index') }}"
               class="nav-link text-dark rounded px-3 py-2 d-flex justify-content-between align-items-center {{ request()->routeIs('produits.*') ? 'bg-primary text-white' : '' }}">
                <span><i class="bi bi-box2-fill me-2"></i> Produits</span>
                <span class="badge bg-danger">2</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('clients.achats.index') }}"
               class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center {{ request()->routeIs('clients.achats.*') ? 'bg-primary text-white' : '' }}">
                <i class="bi bi-cart-check-fill me-2"></i> Achats
            </a>
        </li>
    </ul>

    <hr>

    {{-- Recherche rapide (facultative) --}}
    {{--
    <form class="d-flex mt-3 px-2" method="GET" action="{{ route('clients.search') }}">
        <input type="search" name="q" class="form-control form-control-sm" placeholder="Rechercher..." aria-label="Recherche client">
        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
            <i class="bi bi-search"></i>
        </button>
    </form>
    --}}
</div>
