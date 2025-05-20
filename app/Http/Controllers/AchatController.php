<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Client;
use Illuminate\Http\Request;



class AchatController extends Controller
{
    public function index(Request $request)
    {
        $query = Achat::with('fournisseur', 'produit');
    
        if ($request->filled('search')) {
            $searchTerm = '%'.$request->search.'%';
            
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('fournisseur', function($q) use ($searchTerm) {
                    $q->where('nom', 'LIKE', $searchTerm);
                })
                ->orWhereHas('produit', function($q) use ($searchTerm) {
                    $q->where('nom', 'LIKE', $searchTerm);
                })
                ->orWhere('quantite', 'LIKE', $searchTerm)
                ->orWhere('prix_achat', 'LIKE', $searchTerm)
                ->orWhere('date_achat', 'LIKE', $searchTerm);
            });
        }
    
        $achats = $query->orderBy('date_achat', 'desc')->get();
    
        return view('achats.index', compact('achats'));
    }

    public function __construct()
    {
        // Seules les actions sensibles sont protégées (modifier ou supprimer un achat)
        $this->middleware('isAdmin')->only(['edit', 'update', 'destroy']);
        
        // Les actions comme create et store sont accessibles à tous les utilisateurs connectés
       $this->middleware('auth')->only(['create', 'store']);

        app()->setLocale('fr');

    }
    
        
    
    public function create(Request $request)
    {
        // Récupérer le produit à partir de l'ID passé dans l'URL
        $produit = Produit::findOrFail($request->produit_id);
        $fournisseurs = Fournisseur::all();
        $clients = Client::all();
        
        // Passer le produit et les fournisseurs à la vue
        return view('achats.create', compact('fournisseurs','clients', 'produit'));
    }


    public function edit(Achat $achat)
    {
        $fournisseurs = Fournisseur::all();
        $produits = Produit::all();
        return view('achats.edit', compact('achat', 'fournisseurs', 'produits'));
    }

    public function update(Request $request, Achat $achat)
    {
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
            'prix_achat' => 'required|numeric',
            'date_achat' => 'required|date',
        ]);

        $achat->update($request->all());

        return redirect()->route('achats.index')->with('success', 'Achat mis à jour.');
    }

    public function show(Achat $achat)
    {
        return view('achats.show', compact('achat'));
    }

    public function store(Request $request)
{
    // Valider les données
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'fournisseur_id' => 'required|exists:fournisseurs,id',
        'produit_id' => 'required|exists:produits,id',
        'quantite' => 'required|integer|min:1',
        'prix_achat' => 'required|numeric',
        'date_achat' => 'required|date',
    ]);

    // Créer l'achat
    $achat = Achat::create([
        'client_id' => $request->client_id,
        'fournisseur_id' => $request->fournisseur_id,
        'produit_id' => $request->produit_id,
        'quantite' => $request->quantite,
        'prix_achat' => $request->prix_achat * $request->quantite,
        'date_achat' => $request->date_achat,
    ]);
    
    // Mise à jour du stock
    $produit = Produit::find($request->produit_id);
    $produit->quantite_en_stock -= $request->quantite;
    $produit->save();

    // Rediriger avec un message de succès
    return redirect()->route('achats.index')->with('success', 'Achat enregistré avec succès.');
}


    public function destroy(Achat $achat)
    {
        $achat->delete();
        return redirect()->route('achats.index')->with('success', 'Achat supprimé.');
    }
}
