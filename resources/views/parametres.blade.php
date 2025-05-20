@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4>Paramètres du Compte</h4>
                </div>
                <div class="card-body">
                    <!-- Informations sur l'utilisateur -->
                    <div class="mb-4">
                        <h5 class="mb-3">Informations de votre compte</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nom :</strong> {{ auth()->user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email :</strong> {{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations sur les achats -->
                    <div class="mb-4">
                        <h5 class="mb-3">Informations sur les Achats</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Total des achats effectués :</strong> {{ $totalAchats }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Achats effectués aujourd'hui :</strong> {{ $totalAchatsToday }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Quantité totale achetée aujourd'hui :</strong> {{ $totalQuantiteAchatsToday }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Autres informations supplémentaires -->
                    <div class="mb-4">
                        <h5 class="mb-3">Autres informations</h5>
                       
                    </div>

                    <!-- Footer -->
                    <div class="mt-4 text-center">
                        <p>© 2025 Marjan Holding - Tous droits réservés.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
