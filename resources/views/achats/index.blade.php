@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
        <div>
            <span class="text-muted">Total : <strong>{{ $achats->count() }}</strong> achats</span><br>
            <span class="text-muted">Montant total : <strong>{{ number_format($achats->sum('prix_achat'), 2) }} MAD</strong></span>
        </div>
        <form method="GET" action="{{ route('achats.index') }}" class="d-flex" role="search">
            <input type="text" name="search" class="form-control form-control-sm me-2" 
                placeholder="Rechercher..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-search"></i>
            </button>
        </form>


    </div>

    @if(request('search'))
        <div class="mb-3 px-2">
            <i class="bi bi-info-circle me-1"></i> Résultats pour : <strong>"{{ request('search') }}"</strong>
            <a href="{{ route('achats.index') }}" class="btn btn-sm btn-secondary ms-3">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    @endif

    

    

    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Fournisseur</th>
                    <th>Client</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix d'achat</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($achats as $achat)
                <tr>
                    <td>{{ $achat->id }}</td>
                    <td>{{ $achat->fournisseur->nom }}</td>
                    <td>{{ $achat->client->nom ?? '—' }}</td>
                    <td>{{ $achat->produit->nom }}</td>
                    <td>{{ $achat->quantite }}</td>
                    <td>{{ number_format($achat->prix_achat, 2) }} MAD</td>
                    <td>{{ $achat->date_achat }}</td>
                    <td class="text-center">
                        <!-- Bouton Voir - visible pour tous -->
                        <a href="{{ route('achats.show', $achat) }}" class="btn btn-sm btn-info me-1" title="Voir">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        
                        <!-- Boutons Modifier/Supprimer - seulement pour admin -->
                        @can('admin')
                        <a href="{{ route('achats.edit', $achat) }}" class="btn btn-sm btn-warning me-1" title="Modifier">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" title="Supprimer"
                            data-bs-toggle="modal" data-bs-target="#deleteModal" 
                            data-id="{{ $achat->id }}" data-name="Achat n°{{ $achat->id }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Aucun achat enregistré.</td>
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
          Êtes-vous sûr de vouloir supprimer cet achat ?
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
                const achatId = button.getAttribute('data-id');
                const deleteForm = document.getElementById('deleteForm');
                
                // Solution recommandée utilisant les routes Laravel
                deleteForm.action = "{{ route('achats.destroy', '') }}/" + achatId;
                
                // Version alternative si nécessaire:
                // deleteForm.action = `{{ url('achats') }}/${achatId}`;
            });
        }
    });
</script>
@endsection
