@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary-emphasis">
            <i class="bi bi-person-badge me-2"></i> Détails du client
        </h2>
        <a href="{{ route('clients.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left-circle me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Nom :</div>
                <div class="col-md-9 text-dark">{{ $client->nom }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Email :</div>
                <div class="col-md-9 text-dark">{{ $client->email ?? 'Non renseigné' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Téléphone :</div>
                <div class="col-md-9 text-dark">{{ $client->telephone ?? 'Non renseigné' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Adresse :</div>
                <div class="col-md-9 text-dark">{{ $client->adresse ?? 'Non renseignée' }}</div>
            </div>

            <!-- Vérification du rôle utilisateur -->
            @if(auth()->user()->hasRole('admin')) <!-- Remplacez par la vérification de rôle que vous utilisez -->
                <div class="text-end mt-4">
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil-fill me-1"></i> Modifier
                    </a>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="{{ $client->id }}" data-name="{{ $client->nom }}">
                        <i class="bi bi-trash-fill me-1"></i> Supprimer
                    </button>
                </div>
            @endif
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
          Êtes-vous sûr de vouloir supprimer ce client ?
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

<!-- Script -->
<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var clientId = button.getAttribute('data-id');
        var deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "/clients/" + clientId;
    });
</script>
@endsection
