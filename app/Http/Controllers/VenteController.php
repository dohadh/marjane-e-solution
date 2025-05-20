<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class VenteController extends Controller
{
    public function index(Request $request)
    {
        $query = Vente::with(['client', 'produits']);
        
        // Recherche textuelle
        if ($request->filled('search')) {
            $searchTerm = '%'.$request->search.'%';
            
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('client', function($q) use ($searchTerm) {
                    $q->where('nom', 'LIKE', $searchTerm);
                     
                })
                ->orWhereHas('produits', function($q) use ($searchTerm) {
                    $q->where('nom', 'LIKE', $searchTerm);
                })
                ->orWhere('total', 'LIKE', $searchTerm)
                ->orWhere('date_vente', 'LIKE', $searchTerm);
            });
        }
        
        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->where('date_vente', '>=', $request->date_debut);
        }
        
        if ($request->filled('date_fin')) {
            $query->where('date_vente', '<=', $request->date_fin);
        }
        
        // Tri et pagination
        $ventes = $query->orderBy('date_vente', 'desc')->paginate(10);
        
        return view('ventes.index', compact('ventes'));
    }

    public function export()
    {
        $ventes = Vente::with(['client', 'produits'])->get();
        
        $pdf = PDF::loadView('ventes.export', [
            'ventes' => $ventes,
            'total' => $ventes->sum(function($vente) {
                return $vente->produits->sum(function($produit) {
                    return $produit->pivot->prix_vente * $produit->pivot->quantite;
                });
            })
        ]);
        
        return $pdf->download('ventes-'.now()->format('Y-m-d').'.pdf');
    }

    public function create()
    {
        $clients = Client::all();
        $produits = Produit::all();
        return view('ventes.create', compact('clients', 'produits'));
    }
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'produits' => 'required|array|min:1',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.prix_vente' => 'required|numeric|min:0.01',
            'date_vente' => 'required|date|before_or_equal:today',
            
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'produits.required' => 'Vous devez sélectionner au moins un produit.',
            'produits.*.quantite.min' => 'La quantité doit être d\'au moins 1.',
            'produits.*.prix_vente.min' => 'Le prix de vente doit être supérieur à 0.',
            'date_vente.before_or_equal' => 'La date de vente ne peut pas être future.',
            'exists' => 'Le :attribute sélectionné est invalide.'
            
        ]);
    
        // Création de la vente
        $vente = new Vente();
        $vente->client_id = $request->client_id;
        $vente->date_vente = $request->date_vente;
        $vente->total = 0;  // Le total sera calculé plus tard
        $vente->save();
    
        $total = 0;  // Initialisation du total de la vente
    
        // Parcourir chaque produit et ajuster le stock
        foreach ($request->produits as $produitData) {
            $produit = Produit::findOrFail($produitData['id']);
            $quantiteVendue = $produitData['quantite'];
            $prixVente = $produitData['prix_vente'];
    
            // Vérification de la disponibilité du stock
            if ($produit->quantite_en_stock < $quantiteVendue) {
                return redirect()->back()->with('error', "Le produit {$produit->nom} n'a pas suffisamment de stock.");
            }
    
            // Mise à jour du stock
            $produit->quantite_en_stock -= $quantiteVendue;
            $produit->save();
    
            // Calcul du total
            $total += $prixVente * $quantiteVendue;
    
            try {
                // Ajout des produits à la vente via la table pivot
                $vente->produits()->attach($produit->id, [
                    'quantite' => $quantiteVendue,
                    'prix_vente' => $prixVente
                ]);
            } catch (\Exception $e) {
                // Si une erreur se produit lors de l'ajout d'un produit, on redirige avec un message d'erreur
                return redirect()->back()->with('error', 'Erreur lors de l\'ajout des produits à la vente: ' . $e->getMessage());
            }
        }
    
        // Mise à jour du total de la vente
        $vente->total = $total;
        $vente->save();
    
        // Redirection vers la liste des ventes avec un message de succès
        return redirect()->route('ventes.index')->with('success', 'Vente enregistrée avec succès');
    }

    public function __construct()
    {
        $this->middleware('isAdmin')->only(['create', 'store', 'edit', 'update', 'destroy']);
         app()->setLocale('fr');
    }
    
       

    public function show($id)
    {
        $vente = Vente::with(['client', 'produits'])->findOrFail($id);
        return view('ventes.show', compact('vente'));
    }

    public function edit($id)
    {
        $vente = Vente::findOrFail($id);
        $clients = Client::all();
        $produits = Produit::all();
        return view('ventes.edit', compact('vente', 'clients', 'produits'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_vente' => 'required|date',
            'produits' => 'required|array|min:1',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'produits.*.prix_vente' => 'required|numeric|min:0'
        ]);
    
        $vente = Vente::findOrFail($id);
        
        // Mise à jour des infos de base
        $vente->update([
            'client_id' => $validated['client_id'],
            'date_vente' => $validated['date_vente']
        ]);
    
        // Calcul du nouveau total (en multipliant prix_vente par quantité)
        $total = collect($validated['produits'])->sum(function($produit) {
            return $produit['prix_vente'] * $produit['quantite'];
        });
    
        // Synchronisation des produits
        $produitsData = [];
        foreach ($validated['produits'] as $produit) {
            $produitsData[$produit['id']] = [
                'quantite' => $produit['quantite'],
                'prix_vente' => $produit['prix_vente']
            ];
        }
        $vente->produits()->sync($produitsData);
    
        // Mise à jour du total
        $vente->total = $total;
        $vente->save();
    
        return redirect()->route('ventes.index')
                       ->with('success', 'Vente mise à jour avec succès');
    }
    public function destroy($id)
    {
        $vente = Vente::findOrFail($id);
        $vente->produits()->detach(); // Supprimer les produits associés
        $vente->delete();

        return redirect()->route('ventes.index')->with('success', 'Vente supprimée avec succès');
    }

    
}
