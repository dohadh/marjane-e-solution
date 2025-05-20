@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- En-tête avec icône et titre stylisé -->
    <div class="text-center mb-5">
        <div class="icon-circle bg-danger bg-gradient mb-3 mx-auto">
            <i class="bi bi-exclamation-triangle-fill text-white fs-3"></i>
        </div>
        <h2 class="text-danger fw-bold mb-2">Produits en Rupture de Stock</h2>
        <p class="text-muted">Liste des produits nécessitant un réapprovisionnement urgent</p>
    </div>

    @if($ruptures->isEmpty())
        <!-- Message quand tout est en stock -->
        <div class="alert alert-success alert-elegant text-center rounded-pill shadow-sm py-3 animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill me-2"></i> Félicitations ! Tous les produits sont en stock.
        </div>
    @else
        <!-- Grille de produits avec compteur -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                <i class="bi bi-box-seam me-1"></i> {{ $ruptures->count() }} produit(s) en rupture
            </div>
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('stock.print') }}" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-filetype-pdf me-1"></i> Exporter en PDF
            </a>
            @endif
        </div>

        <div class="row g-4">
            @foreach($ruptures as $produit)
            <div class="col-lg-4 col-md-6">
                <div class="card card-rupture border-start border-3 border-danger shadow-sm h-100 transition-all">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="icon-circle-sm bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-exclamation-octagon-fill"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title fw-bold mb-1">{{ $produit->nom }}</h5>
                                <p class="text-muted small mb-2">Référence: {{ $produit->reference }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                        <i class="bi bi-lightning-charge-fill me-1"></i> Rupture
                                    </span>
                                    <div class="text-end">
                                        <small class="text-muted d-block">Dernière commande</small>
                                        <span class="fw-bold">{{ optional($produit->updated_at)->format('d/m/Y') ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 pt-0">
                        <a href="{{ route('achats.create', ['produit_id' => $produit->id]) }}" class="btn btn-sm btn-outline-danger w-100">
                            <i class="bi bi-cart-plus me-1"></i> Commander
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination et actions globales -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                </ul>
            </nav>
            
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Script pour gérer les actions si nécessaire
    document.addEventListener('DOMContentLoaded', function() {
        // Vous pouvez ajouter ici des gestionnaires d'événements JavaScript
        // pour des actions plus complexes que de simples liens
    });
</script>
@endpush

@push('styles')
<style>
    /* Style personnalisé */
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .icon-circle-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    .card-rupture {
        border-radius: 10px;
        transition: all 0.3s ease;
        border-top: 1px solid rgba(220, 53, 69, 0.1);
    }
    
    .card-rupture:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(220, 53, 69, 0.1);
    }
    
    .alert-elegant {
        border: none;
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.1), white);
        color: #198754;
        font-weight: 500;
    }
    
    .transition-all {
        transition: all 0.3s ease;
    }
    
    .bg-opacity-10 {
        background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
    }
</style>
@endpush