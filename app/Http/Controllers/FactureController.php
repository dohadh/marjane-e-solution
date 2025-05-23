<?php
namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Produit;
use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all invoices, and handle search functionality
        $factures = Facture::when($request->search, function ($query) use ($request) {
            return $query->where('numero', 'like', '%' . $request->search . '%')
                         ->orWhereHas('client', function ($query) use ($request) {
                             $query->where('nom', 'like', '%' . $request->search . '%');
                         });
        })->get();

        // Calculate the total amount of all invoices
        $totalAmount = $factures->sum('montant_total');

        return view('factures.index', compact('factures', 'totalAmount'));
    }
    
    public function __construct()
    {
        $this->middleware('isAdmin')->only([ 'edit', 'update', 'destroy']);
         app()->setLocale('fr');
    }
    
    public function create()
    {
        $clients = Client::all(); // Récupérer tous les clients
        $produits = Produit::all();
        return view('factures.create', compact('clients', 'produits'));

        
    }

    public function exportPdf()
    {
        $factures = Facture::with('client')->get();
        $date = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView('factures.pdf', compact('factures', 'date'));
        return $pdf->download('liste_factures.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|unique:factures|alpha_num|max:255',
            'client_id' => 'required|exists:clients,id',
            'date_facture' => 'required|date',
            'montant_total' => 'required|numeric|min:0',
            'statut' => 'required|in:en attente,payée',
            'description' => 'required|string',
            'date_echeance' => 'required|date|after_or_equal:date_facture',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:produits,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ], [
            'products.required' => 'Vous devez ajouter au moins un produit',
            'products.*.product_id.required' => 'Le produit est obligatoire',
            'products.*.quantity.required' => 'La quantité est obligatoire',
            'products.*.price.required' => 'Le prix est obligatoire',
            'date_echeance.after_or_equal' => 'La date d\'échéance doit être postérieure ou égale à la date de facture'
        ]);

        Facture::create([
            'numero' => $request->numero,
            'client_id' => $request->client_id,
            'date_facture' => $request->date_facture,
            'montant_total' => $request->montant_total,
            'statut' => $request->statut,
        ]);

        return redirect()->route('factures.index')->with('success', 'Facture créée avec succès');
    }

    public function show(Facture $facture)
    {
        return view('factures.show', compact('facture'));
    }

    public function edit(Facture $facture)
    {
        $clients = Client::all();
        return view('factures.edit', compact('facture', 'clients'));
    }

    public function update(Request $request, Facture $facture)
    {
        $request->validate([
            'numero' => 'required|alpha_num|max:255',
            'client_id' => 'required|exists:clients,id',
            'date_facture' => 'required|date',
            'montant_total' => 'required|numeric|min:0',
            'statut' => 'required|in:en attente,payée',
        ]);

        $facture->update([
            'numero' => $request->numero,
            'client_id' => $request->client_id,
            'date_facture' => $request->date_facture,
            'montant_total' => $request->montant_total,
            'statut' => $request->statut,
        ]);

        return redirect()->route('factures.index')->with('success', 'Facture mise à jour avec succès');
    }
    public function destroy(Facture $facture)
    {
        // Suppression de la facture
        $facture->delete();

        // Redirection après suppression
        return redirect()->route('factures.index')->with('success', 'Facture supprimée avec succès.');
    }
}

