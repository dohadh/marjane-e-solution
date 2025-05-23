@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Mes Achats</h1>

@if ($achats->isEmpty())
    <p>Aucun achat trouvé.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($achats as $achat)
            <div class="border rounded-xl p-4 shadow-md">
                <img 
                    src="{{ asset('storage/' . $achat->produit->image) }}" 
                    alt="Image du produit" 
                    class="h-28 object-cover mx-auto mb-2"
                >
                <h2 class="text-lg font-semibold">
                    {{ $achat->produit->nom ?? 'Produit inconnu' }}
                </h2>
                <p>Quantité : {{ $achat->quantite }}</p>
                <p>Prix : {{ $achat->prix_achat }} DH</p>
                <p>Date : {{ $achat->date_achat }}</p>
            </div>
        @endforeach
    </div>
@endif






@endsection
