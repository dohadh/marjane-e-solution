@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- En-tête avec icône et titre stylisé -->
    <div class="text-center mb-5">
        <div class="icon-report-header bg-gradient-primary text-white mb-4 mx-auto">
            <i class="bi bi-bar-chart-line-fill"></i>
        </div>
        <h1 class="text-primary fw-bold mb-2">Tableau de Bord Analytique</h1>
        <p class="text-muted">Accédez aux données clés de votre entreprise</p>
    </div>

    <div class="row g-4">
        <!-- Carte Ventes -->
        <div class="col-xl-6 col-md-6">
            <div class="card report-card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="report-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ms-4">
                            <h3 class="mb-1 fw-bold">Analyse des Ventes</h3>
                            <p class="text-muted mb-3">Performances commerciales et tendances</p>
                            <a href="{{ route('ventes.index') }}" class="btn btn-primary px-4">
                                Explorer <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <div class="d-flex justify-content-between text-muted small">
                        <span><i class="bi bi-calendar me-1"></i> Mise à jour: {{ now()->format('d/m/Y') }}</span>
                        <span><i class="bi bi-speedometer2 me-1"></i> Temps réel</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Stock -->
        <div class="col-xl-6 col-md-6">
            <div class="card report-card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="report-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="ms-4">
                            <h3 class="mb-1 fw-bold">Gestion du Stock</h3>
                            <p class="text-muted mb-3">Niveaux d'inventaire et alertes</p>
                            <a href="{{ route('stock.index') }}" class="btn btn-success px-4">
                                Explorer <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <div class="d-flex justify-content-between text-muted small">
                        <span><i class="bi bi-calendar me-1"></i> Mise à jour: {{ now()->format('d/m/Y') }}</span>
                        <span><i class="bi bi-speedometer2 me-1"></i> Synchronisé</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Options supplémentaires (cachées par défaut, apparaissent au survol) -->
        <div class="col-12 mt-4">
    <div class="card more-reports border-0 shadow-sm">
        <div class="card-body p-4 text-center">
            <h4 class="mb-3">Autres Rapports Disponibles</h4>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-people me-2"></i> Clients
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('fournisseurs.index') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-truck me-2"></i> Fournisseurs
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('factures.index') }}" class="btn btn-outline-warning w-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text me-2"></i> Factures
                    </a>
                </div>
                <div class="col-md-3">
                <a href="{{ route('stock.rupture') }}" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-triangle me-2"></i> Rupture de Stock
                </a>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Style personnalisé */
    .icon-report-header {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
    }
    
    .report-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    
    .report-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
    }
    
    .more-reports {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.5s ease;
    }
    
    .container:hover .more-reports {
        opacity: 1;
        max-height: 200px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }
    
    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
</style>
@endpush