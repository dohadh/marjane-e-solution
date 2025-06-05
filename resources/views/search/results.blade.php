@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-dark">Résultats de la recherche pour : <strong>"{{ request('search') }}"</strong></h1>

    {{-- Utilisateurs --}}
    @if($users->count())
        <h4 class="mb-3 text-primary">Utilisateurs</h4>
        <ul class="list-group mb-4">
            @foreach($users as $user)
                <li class="list-group-item">
                    <strong>{{ $user->name }}</strong> ({{ $user->email }}) - Rôle : <span class="badge bg-info text-dark">{{ $user->role }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Factures --}}
    @if($factures->count())
        <h4 class="mb-3 text-primary">Factures</h4>
        <ul class="list-group mb-4">
            @foreach($factures as $facture)
                <li class="list-group-item">
                    Facture #<strong>{{ $facture->numero }}</strong> - Client ID: {{ $facture->client_id }} - Montant: <span class="badge bg-success">{{ $facture->montant_total }} MAD</span>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Produits --}}
@if($produits->count())
    <h4 class="mb-3 text-primary">Produits</h4>
    <div class="row mb-4">
        @foreach($produits as $produit)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produit->nom }}</h5>
                        <p class="card-text text-muted">{{ $produit->description }}</p>
                        <p class="card-text text-success fw-bold">{{ number_format($produit->prix_unitaire, 2) }} MAD</p>
                        <p class="card-text">Stock: {{ $produit->quantite_en_stock }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

    {{-- Clients --}}
    @if($clients->count())
        <h4 class="mb-3 text-primary">Clients</h4>
        <ul class="list-group mb-4">
            @foreach($clients as $client)
                <li class="list-group-item">
                    <strong>{{ $client->nom }}</strong> ({{ $client->email }}) - Téléphone : {{ $client->telephone }}
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Fournisseurs --}}
    @if($fournisseurs->count())
        <h4 class="mb-3 text-primary">Livreurs</h4>
        <ul class="list-group mb-4">
            @foreach($fournisseurs as $fournisseur)
                <li class="list-group-item">
                    <strong>{{ $fournisseur->nom }}</strong> - {{ $fournisseur->email }}
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Achats --}}
@if($achats->count())
    <h4 class="mb-3 text-primary">Achats</h4>
    <div class="table-responsive mb-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fournisseur</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                @foreach($achats as $achat)
                <tr>
                    <td>{{ $achat->id }}</td>
                    <td>{{ $achat->fournisseur->nom ?? 'N/A' }}</td>
                    <td>{{ $achat->produit->nom ?? 'N/A' }}</td>
                    <td>{{ $achat->quantite }}</td>
                    <td>{{ number_format($achat->prix_achat, 2) }} MAD</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

{{-- Ventes --}}
@if($ventes->count())
    <h4 class="mb-3 text-primary">Ventes</h4>
    <div class="table-responsive mb-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Produits</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventes as $vente)
                <tr>
                    <td>{{ $vente->id }}</td>
                    <td>{{ $vente->client->nom ?? 'N/A' }}</td>
                    <td>
                        @foreach($vente->produits as $produit)
                            {{ $produit->nom }} (x{{ $produit->pivot->quantite }})<br>
                        @endforeach
                    </td>
                    <td>{{ number_format($vente->total, 2) }} MAD</td>
                    <td>{{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

{{-- Stocks --}}
@if($stocks->count())
    <h4 class="mb-3 text-primary">Mouvements de stock</h4>
    <div class="table-responsive mb-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produit</th>
                    <th>Type</th>
                    <th>Quantité</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->produit->nom ?? 'N/A' }}</td>
                    <td>{{ $stock->type }}</td>
                    <td>{{ $stock->quantite }}</td>
                    <td>{{ $stock->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
    {{-- Aucun résultat trouvé --}}
    @if(
        !$users->count() &&
        !$factures->count() &&
        !$produits->count() &&
        !$clients->count() &&
        !$fournisseurs->count() &&
        !$achats->count() &&
        !$ventes->count() &&
        !$stocks->count()
    )
        <div class="alert alert-warning">Aucun résultat trouvé pour <strong>"{{ request('search') }}"</strong>.</div>
    @endif
</div>
@endsection
