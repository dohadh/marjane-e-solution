@extends('layouts.app')

@section('content')
<div class="container py-4">
<!-- En-tête avec titre, dropdown et bouton d'ajout -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Produits</h2>

    <div class="d-flex align-items-center">
        <!-- Dropdown pour le filtre par type -->
        <div class="dropdown me-3">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownTypeButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ isset($type) ? ucfirst(str_replace('_', ' ', $type)) : 'Tous les types' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownTypeButton">
                <li>
                    <a class="dropdown-item {{ !request()->is('*type/*') ? 'active' : '' }}"
                       href="{{ route('produits.index') }}">
                        Tous
                    </a>
                </li>
                @foreach(['boissons', 'produitsLaitiers', 'alimentaire', 'produits_menagers','cosmetiques','technologie','electromenager','papeterie','bureautique' ,'jouets','quincaillerie'] as $typeOption)
                    <li>
                        <a class="dropdown-item {{ request()->is('produits/type/'.$typeOption) ? 'active' : '' }}"
                           href="{{ route('produits.byType', $typeOption) }}">
                            {{ ucfirst(str_replace('_', ' ', $typeOption)) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Bouton Ajouter -->
         {{-- @if(auth()->user()->hasRole('admin')) --}}
         @if(isAdmin())
        <a href="{{ route('produits.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Ajouter
        </a>
        @endif
    </div>
</div>


    <!-- Message de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- Titre contextuel -->
    @if(isset($type))
        <h3 class="mb-3 text-primary">
            <i class="bi bi-tag-fill me-2"></i>
            Produits de type : {{ ucfirst(str_replace('_', ' ', $type)) }}
        </h3>
    @endif

    <!-- Barre de recherche et compteur -->
    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
        <div>
            <span class="text-muted">Total : <strong>{{ $produits->count() }}</strong> produits</span>
        </div>
        <form method="GET" action="{{ isset($type) ? route('produits.byType', $type) : route('produits.index') }}" class="d-flex" role="search">
            <input type="text" name="search" class="form-control form-control-sm me-2" 
                   placeholder="Rechercher un produit..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- Message de recherche -->
    @if(request('search'))
        <div class="mb-3 px-2">
            <i class="bi bi-info-circle me-1"></i> Résultats pour : <strong>"{{ request('search') }}"</strong>
            <a href="{{ isset($type) ? route('produits.byType', $type) : route('produits.index') }}" class="btn btn-sm btn-secondary ms-3">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>
    @endif

    <!-- Liste des produits -->
    <div class="row g-3">
        @forelse ($produits as $produit)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}"
                     class="card-img-top" style="height: 180px; object-fit: contain;">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $produit->nom }}</h5>
                        <span class="badge bg-info text-dark">
                            {{ ucfirst(str_replace('_', ' ', $produit->type)) }}
                        </span>
                    </div>
                    <p class="card-text text-muted mb-3">
                        {{ number_format($produit->prix_unitaire, 2) }} MAD
                    </p>
                    <div class="mt-auto d-flex justify-content-between">
                        <a href="{{ route('produits.show', $produit) }}" class="btn btn-sm btn-info" title="Voir détails">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        @if(isAdmin())
                        <a href="{{ route('produits.edit', $produit) }}" class="btn btn-sm btn-warning" title="Modifier">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <button class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                data-id="{{ $produit->id }}" title="Supprimer">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                        @endif
                        <a href="{{ route('achats.create', ['produit_id' => $produit->id]) }}" 
                           class="btn btn-sm btn-success" title="Acheter">
                            <i class="bi bi-cart-plus-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-box-seam display-6"></i>
            <p class="fs-4 mt-3">Aucun produit trouvé</p>
            <a href="{{ route('produits.index') }}" class="btn btn-outline-primary mt-2">
                <i class="bi bi-arrow-left me-1"></i> Voir tous les produits
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($produits->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $produits->links() }}
    </div>
    @endif
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-danger shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fs-5 fw-semibold text-danger mb-3">
                    Êtes-vous sûr de vouloir supprimer ce produit ?
                </p>
                <p class="text-muted mb-0">
                    Cette action est <strong>irréversible</strong>.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3-fill me-1"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Version améliorée pour la suppression des produits
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const produitId = button.getAttribute('data-id');
                const produitNom = button.getAttribute('data-nom'); // Nouveau: récupération du nom
                const deleteForm = document.getElementById('deleteForm');
                
                // Utilisation de la route Laravel (solution recommandée)
                deleteForm.action = "{{ route('produits.destroy', '') }}/" + produitId;
                
                // Option: Personnalisation du message avec le nom du produit
                const messageElement = deleteModal.querySelector('.modal-body p.fs-5');
                if (messageElement && produitNom) {
                    messageElement.textContent = `Êtes-vous sûr de vouloir supprimer le produit "${produduitNom}" ?`;
                }
            });
        }
    });
</script>

<style>
    /* Styles complémentaires */
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
-    .btn-group .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection