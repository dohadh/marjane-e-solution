@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-person-plus me-2"></i> Ajouter un nouveau Livreur
        </h2>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0">
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

            <form action="{{ route('fournisseurs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nom" class="form-label fw-semibold">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom complet" value="{{ old('nom') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="exemple@mail.com" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label for="telephone" class="form-label fw-semibold">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="form-control" placeholder="06XXXXXXXX" value="{{ old('telephone') }}">
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label fw-semibold">Adresse</label>
                    <textarea name="adresse" id="adresse" class="form-control" rows="3" placeholder="Adresse complète">{{ old('adresse') }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle-fill me-1"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
