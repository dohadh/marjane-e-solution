<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'nom',
        'reference',
        'type',
        'description',
        'prix_unitaire',
        'quantite_en_stock',
        'image', // Ajout de l'image dans le tableau $fillable
    ];

    // Fonction pour gérer l'enregistrement de l'image
    public static function boot()
    {
        parent::boot();

        static::saving(function ($produit) {
            if (request()->hasFile('image')) {
                // Gérer le fichier image téléchargé
                $image = request()->file('image');
                $imagePath = $image->store('public/produits'); // Stocke dans storage/app/public/produits
                $produit->image = basename($imagePath); // Enregistre seulement le nom du fichier
            }
        });
    }



    // Relation avec les ventes
    public function ventes()
    {
        return $this->belongsToMany(Vente::class, 'vente_produit')
                    ->withPivot('quantite', 'prix_vente')
                    ->withTimestamps();
    }

    // Relation avec les achats
    public function achats()
    {
        return $this->hasMany(Achat::class);
    }

    

    // Relation avec le stock
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // Relation avec les images (table produit_images)
   // public function images()
    //{
    //    return $this->hasMany(ProduitImage::class); 
    //}

    // Méthode pour obtenir la quantité totale
    public function getQuantiteTotaleAttribute()
    {
        return $this->stocks()->sum('quantite');
    }
}
