@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Liste des Ventes</h2>

        <a href="{{ route('ventes.create') }}" class="btn btn-primary">
            <i class="bi bi-cart-plus me-1"></i> Ajouter une Vente
        </a>

                <!-- Nouveau bouton d'export -->
      <!--   <a href="{{ route('ventes.export') }}" class="btn btn-sm btn-success" title="Exporter en PDF">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Exporter
            </a> -->
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="table-responsive shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3 px-2">
        <div>
            <span class="text-muted">Total : <strong>{{ $ventes->unique('id')->count() }}</strong> ventes</span>
        </div>

            <form method="GET" action="{{ route('ventes.index') }}" class="d-flex" role="search">
                <input type="text" name="search" class="form-control form-control-sm me-2" 
                    placeholder="Rechercher..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <!-- Affichage de la phrase de recherche -->
        @if(request('search'))
            <div class="mb-3 px-2">
                <i class="bi bi-info-circle me-1"></i> Résultats pour : <strong>"{{ request('search') }}"</strong>
                <!-- Bouton de retour à la liste complète -->
                <a href="{{ route('ventes.index') }}" class="btn btn-sm btn-secondary ms-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>
        @endif

        <table class="table table-hover align-middle table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Total</th>
                    <th>Date de Vente</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventes as $vente)
                    @foreach($vente->produits as $produit)  <!-- Boucle pour chaque produit associé à la vente -->
                        <tr>
                            <td>{{ $vente->id }}</td>
                            <td>{{ $vente->client->nom }}</td>
                            <td>{{ $produit->nom }}</td>
                            <td>{{ $produit->pivot->quantite }}</td>
                            <td>{{ number_format($produit->pivot->prix_vente * $produit->pivot->quantite, 2) }} MAD</td>
                            <td>{{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</td>
                            
                            <td class="text-center">
                                <a href="{{ route('ventes.show', $vente->id) }}" class="btn btn-sm btn-info me-1" title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('ventes.edit', $vente->id) }}" class="btn btn-sm btn-warning me-1" title="Modifier">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" title="Supprimer"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                    data-id="{{ $vente->id }}" data-name="Vente #{{ $vente->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Aucune vente enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
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
          Êtes-vous sûr de vouloir supprimer cette vente ?
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

<!-- Script pour transmettre l'ID au formulaire -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const venteId = button.getAttribute('data-id');
                const deleteForm = document.getElementById('deleteForm');
                
                // Solution recommandée utilisant les routes Laravel
                deleteForm.action = "{{ route('ventes.destroy', '') }}/" + venteId;
                
                // Version alternative si nécessaire:
                // deleteForm.action = `{{ url('ventes') }}/${venteId}`;
            });
        }
    });
</script>
@endsection
