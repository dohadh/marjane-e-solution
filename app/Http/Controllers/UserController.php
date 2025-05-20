<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
        })->latest()->paginate(10);
    
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté.');
    }


        public function __construct()
    {
        
        app()->setLocale('fr');
        
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:500'
        ]);

        $user->update($request->except('password'));

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function updatePreferences(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'notifications' => 'nullable|boolean',
        ]);

        $user->notifications_enabled = $validatedData['notifications'] ?? false;
        $user->save();

        return redirect()->route('parametres')->with('success', 'Préférences mises à jour avec succès');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}