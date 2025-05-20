<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Facture;
use App\Models\Produit;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Achat;
use App\Models\Vente;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        // Recherche dans les utilisateurs
        $users = User::where('name', 'like', "%$searchTerm%")
                   ->orWhere('email', 'like', "%$searchTerm%")
                   ->orWhere('role', 'like', "%$searchTerm%")
                   ->get();

        // Recherche dans les factures avec relation client
        $factures = Facture::where('numero', 'like', "%$searchTerm%")
                 ->orWhere('montant_total', 'like', "%$searchTerm%")
                 ->orWhereHas('client', function($query) use ($searchTerm) {
                     $query->where('nom', 'like', "%$searchTerm%");
                 })
                 ->with('client')
                 ->get();

        // Recherche dans les produits
// Dans SearchController.php
        $produits = Produit::where('nom', 'like', "%$searchTerm%")
                ->orWhere('description', 'like', "%$searchTerm%")
                ->orWhere('prix_unitaire', 'like', "%$searchTerm%")
                ->select(['id', 'nom', 'description', 'prix_unitaire', 'quantite_en_stock']) // Exclure image
                ->get();
                // Recherche dans les clients
        $clients = Client::where('nom', 'like', "%$searchTerm%")
                 ->orWhere('email', 'like', "%$searchTerm%")
                 ->orWhere('telephone', 'like', "%$searchTerm%")
                 ->get();

        // Recherche dans les fournisseurs
        $fournisseurs = Fournisseur::where('nom', 'like', "%$searchTerm%")
                         ->orWhere('email', 'like', "%$searchTerm%")
                         ->orWhere('telephone', 'like', "%$searchTerm%")
                         ->get();

        // Recherche dans les achats avec relations
        $achats = Achat::where('quantite', 'like', "%$searchTerm%")
                ->orWhere('prix_achat', 'like', "%$searchTerm%")
                ->orWhere('date_achat', 'like', "%$searchTerm%")
                ->orWhereHas('fournisseur', function($query) use ($searchTerm) {
                    $query->where('nom', 'like', "%$searchTerm%");
                })
                ->orWhereHas('produit', function($query) use ($searchTerm) {
                    $query->where('nom', 'like', "%$searchTerm%");
                })
                ->with(['fournisseur', 'produit'])
                ->get();

        // Recherche dans les ventes avec relations 
        $ventes = Vente::where('total', 'like', "%$searchTerm%")
               ->orWhere('date_vente', 'like', "%$searchTerm%")
               ->orWhereHas('client', function($query) use ($searchTerm) {
                   $query->where('nom', 'like', "%$searchTerm%");
               })
               ->orWhereHas('produits', function($query) use ($searchTerm) {
                   $query->where('nom', 'like', "%$searchTerm%");
               })
               ->with(['client', 'produits'])
               ->get();

        // Recherche dans les stocks avec relation produit
        $stocks = Stock::where('quantite', 'like', "%$searchTerm%")
               ->orWhere('type', 'like', "%$searchTerm%")
               ->orWhereHas('produit', function($query) use ($searchTerm) {
                   $query->where('nom', 'like', "%$searchTerm%");
               })
               ->with('produit')
               ->get();

        return view('search.results', compact(
            'users', 
            'factures', 
            'produits', 
            'clients', 
            'fournisseurs', 
            'achats', 
            'ventes', 
            'stocks'
        ));
    }
}