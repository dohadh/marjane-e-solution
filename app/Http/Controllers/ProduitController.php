<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
    
        $produits = Produit::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nom', 'like', '%'.$search.'%')
                             ->orWhere('reference', 'like', '%'.$search.'%');
            })
            ->when($type, function($query) use ($type) {
                return $query->where('type', $type);
            })
            ->orderBy('nom')
            ->paginate(100000);
    
        return view('produits.index', compact('produits', 'search', 'type'));
    }


    //filtrer par type
    public function byType($type)
    {
        $produits = Produit::where('type', $type)
                    ->orderBy('nom')
                    ->paginate(100);

        return view('produits.index', compact('produits'));
    }

    public function __construct()
    {
        $this->middleware('isAdmin')->only(['create', 'store', 'edit', 'update', 'destroy']);
         app()->setLocale('fr');
    }
    

    public function checkStock()
    {
        // Trouver tous les produits en rupture de stock
        $produits = Produit::where('quantite_en_stock', 0)->get();

        foreach ($produits as $produit) {
            // Envoyer la notification aux administrateurs
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ProduitRuptureDeStock($produit));
            }
        }

        return response()->json(['message' => 'Notifications envoyées']);
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'reference' => 'required|string|unique:produits|max:255',
        'description' => 'required|string',
        'type' => 'required|in:boissons,alimentaire,produits_laitiers,produits_menagers,cosmetiques,technologie,electromenager,papeterie,bureautique,jouets,quincaillerie,autre',
        'prix_unitaire' => 'required|numeric|min:0',
        'quantite_en_stock' => 'required|integer|min:0',
        'seuil_alerte' => 'required|integer|min:0',
        'image' => 'required|string|max:255',
    ], 
    
    [
        'required' => 'Le champ :attribute est obligatoire.',
        'reference.unique' => 'Cette référence existe déjà.',
        'min' => 'Le champ :attribute doit être au moins :min.',
        'numeric' => 'Le champ :attribute doit être un nombre.',
        'integer' => 'Le champ :attribute doit être un entier.',
        'type.in' => 'Le type sélectionné est invalide.'

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['image'] = 'produits/' . $data['image'];

        Produit::create($data);

        return redirect()->route('produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
{
    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'reference' => 'required|string|max:100|unique:produits,reference,'.$produit->id,
        'description' => 'nullable|string',
        'prix_unitaire' => 'required|numeric|min:0',
        'quantite_en_stock' => 'required|integer|min:0',
        'seuil_alerte' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'type' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $data = $validator->validated();

    // Gestion du fichier image s’il est envoyé
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('produits', 'public');
        $data['image'] = $imagePath;
    } else {
        unset($data['image']); // Ne pas toucher à l’image si elle n’est pas modifiée
    }

    $produit->update($data);

    return redirect()->route('produits.index')
        ->with('success', 'Produit mis à jour avec succès.');
}


    

    public function destroy(Produit $produit)
    {
        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}