<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Produit;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $clients = Client::when($search, function ($query, $search) {
            return $query->where('nom', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('telephone', 'like', "%{$search}%")
                         ->orWhere('adresse', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->get();
    
        return view('clients.index', compact('clients'));
    }

    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        
        // Récupère les produits avec stock > 0
        $produits = Produit::where('quantite_en_stock', '>', 0)
                    ->orderBy('nom')
                    ->get(['id', 'nom', 'prix_unitaire', 'image', 'quantite_en_stock']);
        
        return view('clients.dashboard', compact('client', 'produits'));
    }

    
        public function __construct()
    {
        $this->middleware('isAdmin')->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('auth:client')->only('dashboard'); // Changez 'auth' en 'auth:client'
         app()->setLocale('fr');
    }


        public function storeAchat(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id'
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        // Vérification du stock
        if($produit->quantite_en_stock <= 0) {
            return back()->with('error', 'Ce produit n\'est plus disponible');
        }

        DB::transaction(function () use ($produit) {
            // 1. Créer l'achat
            $achat = $produit->achats()->create([
                'client_id' => Auth::guard('client')->id(),
                'date_achat' => now(),
                'quantite' => 1,
                'prix_total' => $produit->prix_unitaire
            ]);

            // 2. Mettre à jour le stock
            $produit->decrement('quantite_en_stock');

            // 3. Vérifier le seuil d'alerte
            if($produit->quantite_en_stock <= $produit->seuil_alerte) {
                // Déclencher une notification
                event(new StockFaible($produit));
            }
        });

        return redirect()->route('client.dashboard')
            ->with('success', 'Achat effectué avec succès!');
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:clients,email', 
            'telephone' => 'required',
            'adresse' => 'required',
            'password' => 'required|min:8|confirmed', // confirmation = champ password_confirmation attendu dans le formulaire
        ]);

        // Création du client avec mot de passe chiffré
        Client::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'password' => Hash::make($request->password), // chiffrer le mot de passe
        ]);

        // Redirige vers la liste des clients avec un message de succès
        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'telephone' => 'required',
            'adresse' => 'required',
        ]);

        // Mise à jour du client
        $client->update($request->only(['nom', 'email', 'telephone', 'adresse']));


        // Redirige vers la liste des clients avec un message de succès
        return redirect()->route('clients.index')->with('success', 'Client mis à jour.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé.');
    }
}