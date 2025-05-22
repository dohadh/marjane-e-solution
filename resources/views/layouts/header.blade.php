<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Bouton pour toggle la sidebar (visible sur mobile) -->
        <button class="btn btn-sm btn-outline-primary me-3 d-lg-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand/Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logomarjan.jpg') }}" alt="image" style="max-width: 350px;">
        </a>

        <!-- Right Side Of Navbar -->
        <div class="ms-auto d-flex align-items-center">
            <!-- Notifications -->
            <div class="dropdown me-3">
                <button class="btn btn-link text-dark" type="button" id="dropdownNotifications" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <span class="badge bg-danger rounded-pill">3</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownNotifications">
                    <li><h6 class="dropdown-header">Notifications</h6></li>
                    <li><a class="dropdown-item" href="#">2 Produits en rupture</a></li>
                    <li><a class="dropdown-item" href="#">Nouvelle commande reçue</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-primary" href="#">Voir toutes</a></li>
                </ul>
            </div>

            <!-- User Menu -->
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" 
                        id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="me-2 d-none d-lg-block text-end">
                        @if(isAdmin())
                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                            <small class="text-muted">Administrateur</small>
                        @elseif (isUser())
                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                            <small class="text-muted">Non Admin</small>
                        @elseif (isClient())
                            <div class="fw-bold">{{ Auth::guard('client')->user()->nom }}</div>
                            <small class="text-muted">Client</small>
                        @endif
                    </div>
                    @if(Auth::check())
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff" 
                             class="rounded-circle" width="36" alt="Profile">
                    @else
                        <img src="https://ui-avatars.com/api/?name=Invité&background=4e73df&color=fff" 
                             class="rounded-circle" width="36" alt="Profile">
                    @endif
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                   @if(Auth::check())
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="fas fa-user-circle me-2"></i> Profil</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('parametres') }}">
                            <i class="fas fa-cog me-2"></i> Paramètres</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @if(isAdmin() || isUser())
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        @elseif(isClient())
                            <li>
                                <form method="POST" action="{{ route('clients.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Client Déconnexion
                                    </button>
                                </form>
                            </li>
                        @endif
                    @else
                        <li class="px-3 py-2 text-muted">Veuillez vous connecter</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
