@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
<div class="container py-4">
    <h1>Mon profil</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $client->nom }}</p>
            <p><strong>Email :</strong> {{ $client->email }}</p>
            <!-- Ajoute d'autres infos selon ton modèle Client -->
        </div>
    </div>

</div>
@endsection
