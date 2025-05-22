<div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow-sm" style="width: 250px; min-height: 100vh;">

    <!-- Sidebar Header avec logo et titre -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/logomarjan.jpg') }}" alt="Logo Client" style="max-width: 250px;" class="mb-2">
        <h5 class="fw-bold">Espace Client</h5>
    </div>

    <!-- Affichage client connecté -->
    @if(Auth::guard('client')->check())
        <div class="alert alert-primary py-2 px-3 text-center">
            <small>Connecté en tant que :</small>
            <div class="fw-semibold">{{ Auth::guard('client')->user()->name }}</div>
        </div>
    @endif

    <!-- Menu de navigation -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1">
            <a href="{{ route('clients.dashboard') }}" 
               class="nav-link text-dark rounded {{ request()->routeIs('clients.dashboard') ? 'active bg-primary text-white' : '' }}">
                <i class="bi bi-house-door-fill me-2"></i> Tableau de bord
            </a>
        </li>
        <li class="nav-item mb-1">
            <a 
               class="nav-link text-dark rounded {{ request()->routeIs('clients.profile') ? 'active bg-primary text-white' : '' }}">
                <i class="bi bi-person-lines-fill me-2"></i> Mon profil
            </a>
        </li>
        <li class="nav-item mb-1">
            <a 
               class="nav-link text-dark rounded {{ request()->routeIs('clients.orders') ? 'active bg-primary text-white' : '' }}">
                <i class="bi bi-basket-fill me-2"></i> Mes commandes
            </a>
        </li>
    </ul>

    <hr>

    <!-- Recherche rapide -->
    <form  class="d-flex mt-3 px-2">
        <input type="search" name="q" class="form-control form-control-sm" placeholder="Rechercher..." aria-label="Recherche client">
        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
            <i class="bi bi-search"></i>
        </button>
    </form>

</div>
