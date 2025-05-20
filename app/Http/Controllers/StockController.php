<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $produits = Produit::when($search, function ($query, $search) {
            return $query->where('nom', 'like', "%{$search}%");
        })->get();

        return view('stock.index', compact('produits'));
    }

    public function rupture()
    {
        // Récupérer les produits en rupture de stock (quantité <= 0)
        $ruptures = Produit::where('quantite_en_stock', '<=', 0)->get();

        // Passer la variable $ruptures à la vue
        return view('stock.rupture', compact('ruptures'));
    }

    public function print()
    {
        $date = now()->format('d-m-Y');
        $ruptures = Produit::where('quantite_en_stock', '<=', 0)
                     ->orderBy('nom')
                     ->get(['reference', 'nom', 'quantite_en_stock', 'updated_at']);
    
        $pdf = Pdf::loadView('stock.print', compact('ruptures', 'date'));
        
        // Option 1 : Téléchargement direct
        return $pdf->download("ruptures-stock-{$date}.pdf");
        
        // Option 2 : Affichage dans le navigateur
        // return $pdf->stream("ruptures-stock-{$date}.pdf");
    }

    public function export()
    {
        $produits = Produit::orderBy('nom')->get();
        $date = now()->format('d-m-Y');
        
        $pdf = PDF::loadView('stock.export', compact('produits', 'date'));
        return $pdf->download("inventaire-stock-$date.pdf");
    }
}
