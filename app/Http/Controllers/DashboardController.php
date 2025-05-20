<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Facture;
use App\Models\Vente;
use App\Models\Achat;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques de base
        $stats = [
            'totalClients' => Client::count(),
            'totalFournisseurs' => Fournisseur::count(),
            'totalProduits' => Produit::count(),
            'totalFactures' => Facture::count(),

            // Nombre de transactions de vente aujourd'hui
            'nombreVentes' => Vente::whereDate('created_at', today())->count(),

            // Quantité totale des produits vendus aujourd'hui
            'quantiteVendue' => Vente::whereDate('created_at', today())
                ->join('vente_produit', 'ventes.id', '=', 'vente_produit.vente_id')
                ->sum('vente_produit.quantite') ?? 0,

            // Total des achats (quantités achetées) aujourd'hui
            'totalAchats' => Achat::whereDate('created_at', today())->sum('quantite') ?? 0,
        ];

        // Total de toutes les quantités en stock
        $stats['totalQuantiteProduits'] = Stock::sum('quantite') ?? 0;

        // Produits en rupture de stock
        $stats['outOfStock'] = Produit::withSum('stocks as quantite_totale', 'quantite')
            ->get()
            ->filter(fn($produit) => $produit->quantite_totale <= 0)
            ->count();

        // Produits en faible stock
        $stats['lowStock'] = Produit::withSum('stocks as quantite_totale', 'quantite')
            ->get()
            ->filter(fn($produit) => $produit->quantite_totale > 0 && $produit->quantite_totale < 5)
            ->count();

        return view('dashboard', $stats);
    }
}