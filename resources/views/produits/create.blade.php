@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary"><i class="bi bi-plus-circle me-2"></i>Ajouter un produit</h2>

    <form action="{{ route('produits.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                           id="nom" name="nom" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="reference" class="form-label">Référence</label>
                    <input type="text" class="form-control @error('reference') is-invalid @enderror" 
                           id="reference" name="reference" value="{{ old('reference') }}" required>
                    @error('reference')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="type" class="form-label">Type de produit</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="">-- Choisir un type --</option>
                    <option value="boissons" {{ old('type') == 'boissons' ? 'selected' : '' }}>Boissons</option>
                    <option value="alimentaire" {{ old('type') == 'alimentaire' ? 'selected' : '' }}>Alimentaire (Fruits , legumes ...)</option>
                    <option value="produits_laitiers" {{ old('type') == 'produits_laitiers' ? 'selected' : '' }}>Produits laitiers</option>
                    <option value="produits_menagers" {{ old('type') == 'produits_menagers' ? 'selected' : '' }}>Produits ménagers</option>
                    <option value="cosmetiques" {{ old('type') == 'cosmetiques' ? 'selected' : '' }}>Cosmétiques</option>
                    <option value="technologie" {{ old('type') == 'technologie' ? 'selected' : '' }}>Technologie</option>
                    <option value="electromenager" {{ old('type') == 'electromenager' ? 'selected' : '' }}>Électroménager</option>
                    <option value="papeterie" {{ old('type') == 'papeterie' ? 'selected' : '' }}>Papeterie</option>
                    <option value="bureautique" {{ old('type') == 'bureautique' ? 'selected' : '' }}>Bureautique</option>
                    <option value="jouets" {{ old('type') == 'jouets' ? 'selected' : '' }}>Jouets</option>
                    <option value="quincaillerie" {{ old('type') == 'quincaillerie' ? 'selected' : '' }}>Quincaillerie</option>
                    <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>

                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="prix_unitaire" class="form-label">Prix unitaire (DH)</label>
                    <input type="number" step="0.01" class="form-control @error('prix_unitaire') is-invalid @enderror" 
                           id="prix_unitaire" name="prix_unitaire" value="{{ old('prix_unitaire') }}" required>
                    @error('prix_unitaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="quantite_en_stock" class="form-label">Quantité en stock</label>
                    <input type="number" class="form-control @error('quantite_en_stock') is-invalid @enderror" 
                           id="quantite_en_stock" name="quantite_en_stock" value="{{ old('quantite_en_stock') }}" required>
                    @error('quantite_en_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="seuil_alerte" class="form-label">Seuil d'alerte</label>
                    <input type="number" class="form-control @error('seuil_alerte') is-invalid @enderror" 
                           id="seuil_alerte" name="seuil_alerte" value="{{ old('seuil_alerte') }}" required>
                    @error('seuil_alerte')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="mb-4">
                    <label for="image" class="form-label">Nom de l'image</label>
                    <input type="text" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" value="{{ old('image') }}" required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Image déjà présente dans <code>storage/app/public/produits/</code> (ex: <code>exemple.jpg</code>)</div>
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle-fill me-1"></i> Enregistrer
                    </button>
                </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
