<div class="sidebar bg-white border-end" id="sidebar">
    <div class="sidebar-header text-center py-4">
        <h4>
            <img src="{{ asset('images/logomarjan.jpg') }}" alt="image" style="max-width: 200px;">
            <span class="fw-bold">Marjan Holding</span>
        </h4>
    </div>

    <div class="sidebar-menu px-3">
        {{-- Affichage pour utilisateur normal --}}
        @if(Auth::guard('web')->check())
            <div class="alert alert-info">
                Utilisateur connecté : {{ Auth::guard('web')->user()->name }}<br>
                Rôle : {{ Auth::guard('web')->user()->role }}
            </div>

            @if(Auth::guard('web')->user()->role === 'admin')
                <div class="alert alert-success">
                    Bienvenue Admin ! 🎉
                </div>
            @endif
        @endif

        {{-- Affichage pour client --}}
        @if(Auth::guard('client')->check())
            <div class="alert alert-primary">
                Client connecté : {{ Auth::guard('client')->user()->name }}
            </div>
        @endif

        <ul class="nav flex-column">
            {{-- Ces liens sont visibles par tous --}}
            <li class="nav-item mb-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link rounded" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>

           
                <li class="nav-item mb-2 {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <a class="nav-link rounded" href="{{ route('clients.index') }}">
                        <i class="fas fa-users me-2"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2 {{ request()->routeIs('factures.*') ? 'active' : '' }}">
                    <a class="nav-link rounded" href="{{ route('factures.index') }}">
                        <i class="fas fa-file-invoice me-2"></i> Factures
                    </a>
                </li>
                <li class="nav-item mb-2 {{ request()->routeIs('produits.*') ? 'active' : '' }}">
                    <a class="nav-link rounded" href="{{ route('produits.index') }}">
                        <i class="fas fa-box-open me-2"></i> Produits
                        <span class="badge bg-danger float-end">2</span>
                    </a>
                </li>
                <li class="nav-item mb-2 {{ request()->routeIs('fournisseurs.*') ? 'active' : '' }}">
                    <a class="nav-link rounded" href="{{ route('fournisseurs.index') }}">
                        <i class="fas fa-truck me-2"></i> Fournisseurs
                    </a>
                </li>
                <li class="nav-item mb-2 {{ request()->routeIs('achats.*') ? 'active' : '' }}">
                    <a class="nav-link rounded" href="{{ route('achats.index') }}">
                        <i class="fas fa-shopping-cart me-2"></i> Achats
                    </a>
                </li>
            

            <hr class="my-3">
            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">
                <span>Accès Rapides</span>
            </h6>

            {{-- Ces liens peuvent être visibles par tout le monde ou juste client/admin selon la logique --}}
            <li class="nav-item mb-2 {{ request()->routeIs('ventes.*') ? 'active' : '' }}">
                <a class="nav-link rounded text-primary" href="{{ route('ventes.index') }}">
                    <i class="fas fa-shopping-cart me-2"></i> Ventes
                </a>
            </li>

            <li class="nav-item mb-2 {{ request()->routeIs('stock.index') ? 'active' : '' }}">
                <a class="nav-link rounded text-secondary" href="{{ route('stock.index') }}">
                    <i class="fas fa-boxes me-2"></i> Stock
                </a>
            </li>

            <li class="nav-item mb-2 {{ request()->routeIs('stock.rupture') ? 'active' : '' }}">
                <a class="nav-link rounded text-danger" href="{{ route('stock.rupture') }}">
                    <i class="fas fa-exclamation-triangle me-2"></i> Rupture de Stock
                </a>
            </li>

            <li class="nav-item mb-2 {{ request()->routeIs('rapports.index') ? 'active' : '' }}">
                <a class="nav-link rounded text-info" href="{{ route('rapports.index') }}">
                    <i class="fas fa-chart-bar me-2"></i> Rapports
                </a>
            </li>

            <form method="GET" action="{{ route('search') }}" class="d-flex mt-3">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Rechercher..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </ul>

        {{-- Administration visible uniquement pour l'admin --}}
        @if(Auth::guard('web')->check() && Auth::guard('web')->user()->role === 'admin')
            <hr class="my-3">
            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">
                <span>Administration</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link rounded" href="{{ route('users.index') }}">
                        <i class="fas fa-user-shield me-2"></i> Utilisateurs
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link rounded" href="{{ route('parametres') }}">
                        <i class="fas fa-cog me-2"></i> Paramètres
                    </a>
                </li>
            </ul>
        @endif
    </div>
</div>
