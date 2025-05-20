<?php

// app/Models/Stock.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['produit_id', 'quantite', 'type', 'date_mouvement'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}