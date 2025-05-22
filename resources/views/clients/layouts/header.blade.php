<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">

        {{-- Bouton menu pour petit écran --}}
        <button class="btn btn-sm btn-outline-primary me-3 d-lg-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        {{-- Logo / Nom --}}
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ route('clients.dashboard') }}">
            <img src="{{ asset('images/logomarjan.jpg') }}" alt="Logo" style="height: 120px;" class="me-2">
            <span>Espace Client</span>
        </a>

        {{-- Zone à droite : avatar + menu utilisateur --}}
        <div class="ms-auto d-flex align-items-center">

            {{-- Menu Utilisateur --}}
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button"
                        id="dropdownUserClient" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="me-2 d-none d-lg-block text-end">
                        <div class="fw-bold">{{ Auth::guard('client')->user()->name }}</div>
                        <small class="text-muted">Client</small>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('client')->user()->name) }}&background=0d6efd&color=fff"
                         class="rounded-circle" width="36" alt="Client Avatar">
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUserClient">
                    <li>
                        {{--<a class="dropdown-item" href="{{ route('clients.profil') }}">--}}
                            <i class="fas fa-user-circle me-2"></i> Mon profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('clients.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
