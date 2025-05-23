@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Créer un Achat</h2>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- Formulaire de création d'achat -->
    <form method="POST" action="{{ route('clients.achats.store') }}">
    @csrf
    
    <!-- Produit -->
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <label for="produit_id" class="form-label">Produit</label>
            <input type="text" class="form-control" value="{{ $produit->nom }}" readonly>
            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
        </div>

        <!-- Prix d'achat -->
        <div class="col-md-6 mb-3">
            <label for="prix_achat" class="form-label">Prix d'achat</label>
            <input type="text" class="form-control" value="{{ number_format($produit->prix_unitaire, 2) }} MAD" readonly>
            <!-- Champ caché ajouté pour envoyer le prix d'achat -->
            <input type="hidden" name="prix_achat" value="{{ $produit->prix_unitaire }}">
        </div>
    </div>

    <!-- Quantité -->
    <div class="col-md-6 mb-3">
        <label for="quantite" class="form-label">Quantité</label>
        <input type="number" name="quantite" id="quantite" class="form-control @error('quantite') is-invalid @enderror" value="{{ old('quantite') }}" min="1">
        @error('quantite')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>



    
    <!-- Fournisseur -->
    <div class="col-md-6 mb-3">
        <label for="fournisseur_id" class="form-label">Fournisseur</label>
        <select name="fournisseur_id" id="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror">
            <option value="" disabled selected>Sélectionner un fournisseur</option>
            @foreach($fournisseurs as $fournisseur)
                <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                    {{ $fournisseur->id }} - {{ $fournisseur->nom }}
                    </option>
            @endforeach
        </select>
        @error('fournisseur_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Date d'achat -->
    <div class="col-md-6 mb-3">
        <label for="date_achat" class="form-label">Date d'achat</label>
        <input type="date" name="date_achat" id="date_achat" class="form-control @error('date_achat') is-invalid @enderror" value="{{ old('date_achat') }}">
        @error('date_achat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Soumettre -->
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </div>
    </form>

    <!-- Retour à la liste -->
    <div class="mt-3">
        <a href="{{ route('produits.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste des produits
        </a>
    </div>
</div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Erreur(s) :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li><i class="bi bi-x-circle-fill me-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
@endsection
