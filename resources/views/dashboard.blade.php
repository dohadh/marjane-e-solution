@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Titre --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-0">Tableau de Bord</h2>
            <hr>
        </div>
    </div>

    {{-- Statistiques Rapides --}}
    <div class="row mb-4">
        @php
            $stats = [
                ['title' => 'Clients', 'count' => $totalClients, 'color' => 'primary', 'icon' => 'users'],
                ['title' => 'Fournisseurs', 'count' => $totalFournisseurs, 'color' => 'success', 'icon' => 'truck'],
                ['title' => 'Produits', 'count' => $totalProduits, 'color' => 'info', 'icon' => 'box-open'],
                ['title' => 'Factures', 'count' => $totalFactures, 'color' => 'warning', 'icon' => 'file-invoice'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-{{ $stat['color'] }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                    {{ $stat['title'] }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stat['count'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-{{ $stat['icon'] }} fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Statistiques de Stock --}}
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card 
                title="Stock Total"
                :count="$totalQuantiteProduits"
                color="secondary"
                icon="boxes"
            />
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card 
                title="Ruptures de Stock"
                :count="$outOfStock"
                color="danger"
                icon="exclamation-triangle"
            />
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <x-dashboard-card 
                title="Stock Faible (<5)"
                :count="$lowStock"
                color="warning"
                icon="box-open"
            />
        </div>
    </div>

    {{-- Transactions Aujourd'hui --}}
    <div class="row mb-4">
        <div class="col-xl-6 col-md-6 mb-4">
            <x-transaction-card 
                title="Quantite de Ventes Aujourd'hui"
                :count="$totalVentes"
                color="primary"
                icon="shopping-cart"
                unit="unités"
            />
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <x-transaction-card 
                title="Achats Aujourd'hui"
                :count="$totalAchats"
                color="success"
                icon="shopping-basket"
                unit="unités"
            />
        </div>
    </div>

    {{-- Actions Rapides --}}
    <div class="row">
        @php
            $actions = [
                ['title' => 'Nouveau Client', 'route' => 'clients.create', 'icon' => 'user-plus', 'color' => 'primary'],
                ['title' => 'Nouveau Produit', 'route' => 'produits.create', 'icon' => 'box-open', 'color' => 'info'],
                ['title' => 'Nouveau Fournisseur', 'route' => 'fournisseurs.create', 'icon' => 'truck', 'color' => 'success'],
                ['title' => 'Nouvelle Facture', 'route' => 'factures.create', 'icon' => 'file-invoice', 'color' => 'warning'],

                // 🚀 Nouveaux accès rapides demandés :
                ['title' => 'Ventes', 'route' => 'ventes.index', 'icon' => 'shopping-cart', 'color' => 'primary'],
                ['title' => 'Stock', 'route' => 'stock.index', 'icon' => 'boxes', 'color' => 'secondary'],
                ['title' => 'Rupture de Stock', 'route' => 'stock.rupture', 'icon' => 'exclamation-triangle', 'color' => 'danger'],
                ['title' => 'Rapports', 'route' => 'rapports.index', 'icon' => 'chart-bar', 'color' => 'info'],
            ];
        @endphp

        @foreach ($actions as $action)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow text-center">
                    <div class="card-body">
                        <i class="fas fa-{{ $action['icon'] }} fa-3x mb-3 text-{{ $action['color'] }}"></i>
                        <h5 class="card-title">{{ $action['title'] }}</h5>
                        <a href="{{ route($action['route']) }}" class="btn btn-{{ $action['color'] }} btn-block">
                            <i class="fas fa-{{ in_array($action['title'], ['Stock', 'Rupture de Stock', 'Rapports']) ? 'eye' : 'plus' }} mr-2"></i>
                            {{ in_array($action['title'], ['Stock', 'Rupture de Stock', 'Rapports']) ? 'Voir' : 'Ajouter' }}
                        </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
