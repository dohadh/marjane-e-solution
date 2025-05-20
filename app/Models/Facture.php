<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'client_id',
        'date_facture',
        'montant_total',
        'statut',
    ];

    // Définir la relation avec le modèle Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
