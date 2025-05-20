<?php

namespace App\Http\Controllers;
use App\Http\Requests\FournisseurRequest;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $fournisseurs = Fournisseur::when($search, function ($query, $search) {
            return $query->where('nom', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('telephone', 'like', "%{$search}%")
                         ->orWhere('adresse', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->get();
    
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function __construct()
    {
        $this->middleware('isAdmin')->only(['create', 'store', 'edit', 'update', 'destroy']);
         app()->setLocale('fr');
    }




    public function create()
    {
        return view('fournisseurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:fournisseurs,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
        ]);
    
        // Création d'un nouveau fournisseur
        $fournisseur = new Fournisseur();
        $fournisseur->nom = $request->nom;
        $fournisseur->email = $request->email;
        $fournisseur->telephone = $request->telephone;
        $fournisseur->adresse = $request->adresse;
        $fournisseur->save();
    
        // Redirection vers la liste des fournisseurs avec un message de succès
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur créé avec succès.');
    }
    

    public function show(Fournisseur $fournisseur)
    {
        return view('fournisseurs.show', compact('fournisseur'));
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:fournisseurs,email,' . $id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);
    
        // Trouver le fournisseur et mettre à jour ses données
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->nom = $request->nom;
        $fournisseur->email = $request->email;
        $fournisseur->telephone = $request->telephone;
        $fournisseur->adresse = $request->adresse;
        $fournisseur->save();
    
        // Redirection vers la liste des fournisseurs avec un message de succès
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur mis à jour avec succès.');
    }
    

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé.');
    }
}
