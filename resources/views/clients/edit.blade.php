@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Modifier le client : {{ $client->nom }}</h2>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            {{-- 🟡 Carte 1 : Infos client --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Modifier les informations du client</h5>
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

                    <form action="{{ route('clients.update', $client) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $client->nom) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $client->telephone) }}">
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea name="adresse" id="adresse" class="form-control" rows="3">{{ old('adresse', $client->adresse) }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save2-fill me-1"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ⚫ Carte 2 : Modifier le mot de passe --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Modifier le mot de passe</h5>
                </div>
                <div class="card-body">
                    @if (session('password_status'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-1"></i> {{ session('password_status') }}
                        </div>
                    @endif

                    <form action="{{ route('clients.updatePassword', $client) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-key-fill me-1"></i> Mettre à jour le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
