<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Authenticatable 
{
    use HasFactory, Notifiable;
    

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse',
        'password',
    ];

    protected $guard = 'client';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relations
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

    public function achats()
    {
        return $this->hasMany(Achat::class);
    }
}
