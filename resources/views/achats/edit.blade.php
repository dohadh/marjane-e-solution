@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Modifier un achat</h2>
        <a href="{{ route('achats.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0 col-md-6">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Détails de l'achat</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('achats.update', $achat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="fournisseur_id" class="form-label">Fournisseur</label>
                    <select name="fournisseur_id" id="fournisseur_id" class="form-select" required>
                        @foreach($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}" {{ $achat->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="produit_id" class="form-label">Produit</label>
                    <select name="produit_id" id="produit_id" class="form-select" required>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}" {{ $achat->produit_id == $produit->id ? 'selected' : '' }}>
                                {{ $produit->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" name="quantite" id="quantite" class="form-control" value="{{ $achat->quantite }}" required min="1">
                </div>

                <div class="mb-3">
                    <label for="prix_achat" class="form-label">Prix d'achat (MAD)</label>
                    <input type="number" name="prix_achat" id="prix_achat" class="form-control" value="{{ $achat->prix_achat }}" required min="0">
                </div>

                <div class="mb-3">
                    <label for="date_achat" class="form-label">Date d'achat</label>
                    <input type="date" name="date_achat" id="date_achat" class="form-control" value="{{ $achat->date_achat }}" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save2-fill me-1"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
