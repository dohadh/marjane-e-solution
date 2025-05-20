<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $fillable = [
        'client_id',
        'date_vente',
        'total'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // La relation many-to-many avec la table pivot 'vente_produit'
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'vente_produit')
                    ->withPivot('quantite', 'prix_vente')  // Champs supplémentaires dans la pivot table
                    ->withTimestamps();
    }
}
