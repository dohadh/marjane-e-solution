@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-person-plus me-2"></i> Ajouter un nouvel utilisateur
        </h2>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
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

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nom</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nom complet" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="exemple@mail.com" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Rôle</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">-- Sélectionnez un rôle --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
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
