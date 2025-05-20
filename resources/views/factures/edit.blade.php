@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Modifier la facture #{{ $facture->numero }}</h2>
        <a href="{{ route('factures.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Modifier les informations de la facture</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('factures.update', $facture->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="numero" class="form-label">Numéro de facture</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero', $facture->numero) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="client_id" class="form-label">Client</label>
                            <select class="form-select" id="client_id" name="client_id" required>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ $client->id == old('client_id', $facture->client_id) ? 'selected' : '' }}>
                                        {{ $client->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date_facture" class="form-label">Date de la facture</label>
                            <input type="date" class="form-control" id="date_facture" name="date_facture" value="{{ old('date_facture', $facture->date_facture) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="montant_total" class="form-label">Montant total</label>
                            <input type="number" class="form-control" id="montant_total" name="montant_total" value="{{ old('montant_total', $facture->montant_total) }}" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select class="form-select" id="statut" name="statut" required>
                                <option value="en attente" {{ $facture->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <option value="payée" {{ $facture->statut == 'payée' ? 'selected' : '' }}>Payée</option>
                            </select>
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
    </div>
</div>
@endsection
