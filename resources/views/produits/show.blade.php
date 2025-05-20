@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary-emphasis">
            <i class="bi bi-box me-2"></i> Détails du produit
        </h2>
        <a href="{{ route('produits.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left-circle me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Nom :</div>
                <div class="col-md-9 text-dark">{{ $produit->nom }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Référence :</div>
                <div class="col-md-9 text-dark">{{ $produit->reference }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Description :</div>
                <div class="col-md-9 text-dark">{{ $produit->description ?? 'Non renseignée' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Type :</div>
                <div class="col-md-9 text-dark">{{ $produit->type }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Prix unitaire :</div>
                <div class="col-md-9 text-dark">{{ $produit->prix_unitaire }} DH</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Quantité en stock :</div>
                <div class="col-md-9 text-dark">{{ $produit->quantite_en_stock }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Image :</div>
                <div class="col-md-9">
                    @if($produit->image)
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="Image du produit" class="img-fluid">
                    @else
                        <p>Aucune image disponible.</p>
                    @endif
                </div>
            </div>

            <div class="text-end mt-4">
                @can('update', $produit)
                    <a href="{{ route('produits.edit', $produit) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil-fill me-1"></i> Modifier
                    </a>
                @endcan
                
                @can('delete', $produit)
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $produit->id }}" data-name="{{ $produit->nom }}">
                        <i class="bi bi-trash-fill me-1"></i> Supprimer
                    </button>
                @endcan
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-danger shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmation de suppression
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
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var produitId = button.getAttribute('data-id');
        var deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "/produits/" + produitId;
    });
</script>
@endsection
