@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary"><i class="bi bi-boxes me-2"></i>Gestion du Stock</h2>

    <!-- Barre de recherche et bouton d'export -->
    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('stock.index') }}" method="GET" class="w-75 me-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Rechercher un produit" value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Rechercher
                </button>
            </div>
        </form>
        @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('stock.export') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i> Exporter PDF
        </a>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des produits en stock</h5>
            <span class="badge bg-white text-primary">{{ $produits->count() }} produits</span>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Produit</th>
                        <th scope="col" class="text-center">Quantité en Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                    <tr>
                        <td>{{ $produit->nom }}</td>
                        <td class="text-center">{{ $produit->quantite_en_stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($produits->isEmpty())
            <div class="alert alert-warning mt-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>Aucun produit disponible en stock.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection