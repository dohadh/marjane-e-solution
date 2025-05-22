@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="bg-white p-5 rounded shadow-sm text-center mb-5">
        <h2 class="fw-bold text-primary mb-3">Bienvenue, {{ Auth::guard('client')->user()->name }} ! 👋</h2>
        <p class="text-muted fs-5">Voici votre tableau de bord client. Vous pouvez consulter vos commandes, modifier vos informations, et bien plus encore.</p>
    </div>

    <div class="row g-4">
        {{-- Card Profil --}}
        <div class="col-md-6">
           <a href="{{ route('clients.profile') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow rounded cursor-pointer">
                    <div class="card-body bg-light rounded d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success">
                                <i class="bi bi-person-circle me-3 fs-2 align-middle"></i>
                                Mon profil
                            </h5>
                            <p class="card-text text-muted fs-6">Modifiez vos informations personnelles.</p>
                        </div>
                        <button class="btn btn-outline-success btn-sm mt-3 align-self-start">Modifier mon profil</button>
                    </div>
                </div>
            </a>
        </div>

        

        {{-- Card Commandes --}}
        <div class="col-md-6">
            {{--<a href="{{ route('client.commandes') }}" class="text-decoration-none">--}}
                <div class="card border-0 shadow-sm h-100 hover-shadow rounded cursor-pointer">
                    <div class="card-body bg-light rounded d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-primary">
                                <i class="bi bi-basket-fill me-3 fs-2 align-middle"></i>
                                Mes commandes
                            </h5>
                            <p class="card-text text-muted fs-6">Consultez l’historique de vos achats.</p>
                        </div>
                        <button class="btn btn-outline-primary btn-sm mt-3 align-self-start">Voir mes commandes</button>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.15) !important;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endpush
