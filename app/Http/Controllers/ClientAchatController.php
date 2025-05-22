<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achat;
use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Auth;

class ClientAchatController extends Controller
{


    public function index()
    {
        $achats = Achat::where('client_id', Auth::guard('client')->id())
                        ->with('produit', 'fournisseur')
                        ->latest()
                        ->get();

        return view('clients.achats.index', compact('achats'));
    }
    public function create(Request $request)
    {
        $produit = Produit::findOrFail($request->produit_id);
        $fournisseurs = Fournisseur::all();
        return view('client.achats.create', compact('produits','fournisseurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'client_id' => 'required|exists:clients,id',
        'fournisseur_id' => 'required|exists:fournisseurs,id',
        'produit_id' => 'required|exists:produits,id',
        'quantite' => 'required|integer|min:1',
        'prix_achat' => 'required|numeric',
        'date_achat' => 'required|date',
        ]);

        Achat::create([
            'client_id' => Auth::id(), // l’utilisateur connecté
            'fournisseur_id' => $request->fournisseur_id,
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'prix_achat' => $request->prix_achat * $request->quantite,
            'date_achat' => now(),
        ]);

            $produit = Produit::find($request->produit_id);
            $produit->quantite_en_stock -= $request->quantite;
            $produit->save();

        return redirect()->route('clients.achats.index')->with('success', 'Achat effectué avec succès.');
    }
}
