@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary-emphasis">
            <i class="bi bi-person-circle me-2"></i> Mon Profil
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left-circle me-1"></i> Retour au tableau de bord
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Informations utilisateur -->
            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Nom :</div>
                {{-- {{dd(Auth::user())}} --}}
                <div class="col-md-9 text-dark">{{ Auth::user()->name }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Email :</div>
                <div class="col-md-9 text-dark">{{ Auth::user()->email ?? 'Non renseigné' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Date d'inscription :</div>
                <div class="col-md-9 text-dark">{{ Auth::user()->created_at->format('d/m/Y') }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-semibold text-dark-emphasis">Rôle :</div>
                <div class="col-md-9 text-dark">{{ Auth::user()->role ?? 'Non renseigné' }}</div>
            </div>

        </div>
    </div>
</div>
@endsection
