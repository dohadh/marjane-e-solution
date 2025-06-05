@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Liste des Livreurs</h2>
        @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Ajouter un Livreur
        </a>
        @endif
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
                <span class="text-muted">Total : <strong>{{ $fournisseurs->count() }}</strong> Livreurs</span>
            </div>
            <form method="GET" action="{{ route('fournisseurs.index') }}" class="d-flex" role="search">
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
                <a href="{{ route('fournisseurs.index') }}" class="btn btn-sm btn-secondary ms-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>
        @endif

        <table class="table table-hover align-middle table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fournisseurs as $fournisseur)
                <tr>
                    <td>{{ $fournisseur->id }}</td>
                    <td>{{ $fournisseur->nom }}</td>
                    <td>{{ $fournisseur->email }}</td>
                    <td>{{ $fournisseur->telephone }}</td>
                    <td>{{ $fournisseur->adresse }}</td>
                    <td class="text-center">
                        <a href="{{ route('fournisseurs.show', $fournisseur) }}" class="btn btn-sm btn-info me-1" title="Voir">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn btn-sm btn-warning me-1" title="Modifier">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" title="Supprimer"
                            data-bs-toggle="modal" data-bs-target="#deleteModal" 
                            data-route="{{ route('fournisseurs.destroy', $fournisseur) }}"
                            data-name="{{ $fournisseur->nom }}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Aucun client enregistré.</td>
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
          Êtes-vous sûr de vouloir supprimer ce Livreur?
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

<!-- Script JS pour configurer dynamiquement le formulaire -->
<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var route = button.getAttribute('data-route');
        var deleteForm = document.getElementById('deleteForm');
        deleteForm.action = route;
    });
</script>
@endsection
