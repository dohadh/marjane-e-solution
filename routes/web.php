<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ClientAchatController;
use App\Http\Controllers\ClientProfileController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\Auth\ClientAuthenticatedSessionController;
use App\Http\Controllers\Client\Auth\ClientRegisteredUserController;


use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Facture;
use App\Models\Vente;
use App\Models\Achat;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|--------------------------------------------------------------------------
*/

// Route pour rediriger vers la page de connexion dès l'accès à la racine
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});



// Routes d'auth client (guest)
Route::middleware('guest:client')
    ->prefix('clients')
    ->name('clients.')
    ->group(function () {
        Route::get('/login', [ClientAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [ClientAuthenticatedSessionController::class, 'store'])->name('login');
        Route::get('/register', [ClientRegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [ClientRegisteredUserController::class, 'store'])->name('register');
});
    
    
// Routes protégées pour les clients (authentifiés)
Route::middleware('isClient')->prefix('clients')->name('clients.')->group(function () {
    Route::get('dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [ClientAuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/profile/edit', [ClientController::class, 'editProfile'])->name('profile.edit');
     Route::get('/profile', [ClientProfileController::class, 'show'])->name('profile');
    Route::get('/client/achats/index', [ClientAchatController::class, 'index'])->name('achats.index');
    Route::post('/client/achats', [ClientAchatController::class, 'store'])->name('achats.store');
    Route::get('/produits', [ProduitController::class, 'indexForClient'])->name('clients.produits');
    
    
});






// Password Reset
Route::middleware('guest')->group(function () {
    

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');


});

Route::middleware(['auth.user.or.client'])->group(function () {
    Route::resource('produits', ProduitController::class);
    // 
});

// Routes protégées par auth
Route::middleware(['auth'])->group(function () {


    // Dashboard - Version corrigée
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalClients' => Client::count(),
            'totalFournisseurs' => Fournisseur::count(),
            'totalProduits' => Produit::count(),
            'totalFactures' => Facture::count(),
            'totalQuantiteProduits' => Produit::sum('quantite_en_stock'),
            'outOfStock' => Produit::where('quantite_en_stock', 0)->count(),
            'lowStock' => Produit::whereBetween('quantite_en_stock', [1, 4])->count(),
            
            // Correction pour totalVentes - utilisation de la table pivot
            'totalVentes' => DB::table('vente_produit')
                ->join('ventes', 'vente_produit.vente_id', '=', 'ventes.id')
                ->whereDate('ventes.created_at', today())
                ->sum('vente_produit.quantite'),
            
            // Vérification pour totalAchats (si la structure est similaire)
            'totalAchats' => DB::table('achat_produit') // Supposons que vous avez une table similaire pour les achats
                ->join('achats', 'achat_produit.achat_id', '=', 'achats.id')
                ->whereDate('achats.created_at', today())
                ->sum('achat_produit.quantite') ?? Achat::whereDate('created_at', today())->sum('quantite'),
            
            // Option alternative avec Eloquent pour les ventes
            // 'totalVentes' => Vente::whereDate('created_at', today())
            //     ->withSum('produits as quantite_totale', 'vente_produit.quantite')
            //     ->get()
            //     ->sum('quantite_totale'),
        ]);
    })->name('dashboard');
    
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Gestion des entités principales
    Route::resource('clients', ClientController::class);
    Route::resource('fournisseurs', FournisseurController::class);
    // Route::resource('produits', ProduitController::class);
    Route::resource('factures', FactureController::class);
    Route::get('/factures/export/pdf', [FactureController::class, 'exportPDF'])->name('factures.export.pdf');
    Route::resource('achats', AchatController::class);
    
    
    
    
    Route::resource('ventes', VenteController::class);
    
    


    // Routes spécifiques


    // Recherche
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // Gestion des utilisateurs (admin seulement)
    Route::middleware('isAdmin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Gestion des images de produits
    Route::get('/produits/{produit}/edit-image', [ProduitController::class, 'editImage'])->name('produits.editImage');
    Route::put('/produits/{produit}/update-image', [ProduitController::class, 'updateImage'])->name('produits.updateImage');

    //filtrer par type
    Route::get('/produits/type/{type}', [ProduitController::class, 'byType'])
    ->name('produits.byType');

    // Paramètres
    Route::get('/parametres', [ProfileController::class, 'showSettings'])->name('parametres');
    Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::put('/preferences/update', [UserController::class, 'updatePreferences'])->name('preferences.update');

    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/rupture', [StockController::class, 'rupture'])->name('stock.rupture');

    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');


    Route::get('/stock/print', [StockController::class, 'print'])->name('stock.print');
    Route::get('/stock/export', [StockController::class, 'export'])->name('stock.export');
    Route::get('/ventes/export', [VenteController::class, 'export'])->name('ventes.export');
});

// Auth routes supplémentaires
require __DIR__.'/auth.php';