@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Liste des factures</h2>
        @if(auth()->user()->role === 'admin')
            <div class="d-flex">
                <a href="{{ route('factures.export.pdf') }}" class="btn btn-danger me-2">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Exporter en PDF
                </a>
                <a href="{{ route('factures.create') }}" class="btn btn-primary">
                    <i class="bi bi-file-earmark-plus me-1"></i> Ajouter une facture
                </a>
            </div>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
        <div>
            <span class="text-muted">Total : <strong>{{ $factures->count() }}</strong> factures</span><br>
            <span class="text-muted">Montant total : <strong>{{ number_format($factures->sum('montant_total'), 2) }} MAD</strong></span>
        </div>
        <form method="GET" action="{{ route('factures.index') }}" class="d-flex" role="search">
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
            <a href="{{ route('factures.index') }}" class="btn btn-sm btn-secondary ms-3">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Numéro</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($factures as $facture)
                <tr>
                    <td>{{ $facture->id }}</td>
                    <td>{{ $facture->numero }}</td>
                    <td>{{ $facture->client->nom }}</td>
                    <td>{{ $facture->date_facture }}</td>
                    <td>{{ number_format($facture->montant_total, 2) }} MAD</td>
                    <td>{{ $facture->statut }}</td>
                    <td class="text-center">
                        <a href="{{ route('factures.show', $facture) }}" class="btn btn-sm btn-info me-1" title="Voir">
                            <i class="bi bi-eye-fill"></i>
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('factures.edit', $facture) }}" class="btn btn-sm btn-warning me-1" title="Modifier">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <button class="btn btn-sm btn-danger" title="Supprimer"
                                data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                data-id="{{ $facture->id }}" data-numero="{{ $facture->numero }}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Aucune facture enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmation de suppression (uniquement pour admin) -->
@if(auth()->user()->role === 'admin')
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
          Êtes-vous sûr de vouloir supprimer cette facture ?
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
@endif

<!-- Script pour transmettre l’ID au formulaire -->
@if(auth()->user()->role === 'admin')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteModal = document.getElementById('deleteModal');
        
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var factureId = button.getAttribute('data-id');
                var deleteForm = document.getElementById('deleteForm');
                
                // Solution robuste utilisant les helpers Laravel
                deleteForm.action = "{{ route('factures.destroy', '') }}/" + factureId;
                
                // Alternative si vous préférez :
                // deleteForm.action = "{{ url('factures') }}/" + factureId;
            });
        }
    });
</script>
@endif
@endsection
