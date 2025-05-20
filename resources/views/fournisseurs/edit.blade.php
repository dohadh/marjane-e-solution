@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Modifier le fournisseur : {{ $fournisseur->nom }}</h2>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Modifier les informations du fournisseur</h5>
                </div>
                <div class="card-body">
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

                    <form action="{{ route('fournisseurs.update', $fournisseur) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $fournisseur->nom) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $fournisseur->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $fournisseur->telephone) }}">
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea name="adresse" id="adresse" class="form-control" rows="3">{{ old('adresse', $fournisseur->adresse) }}</textarea>
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
