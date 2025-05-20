<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $fillable = [
        'client_id',
        'fournisseur_id',
        'produit_id',
        'quantite',
        'prix_achat',
        'date_achat'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
