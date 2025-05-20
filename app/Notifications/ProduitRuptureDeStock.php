<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProduitRuptureDeStock extends Notification
{
    use Queueable;

    protected $produit;

    public function __construct($produit)
    {
        $this->produit = $produit;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Canaux de notification : base de données et email
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Le produit ' . $this->produit->name . ' est en rupture de stock.',
            'produit_id' => $this->produit->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Le produit ' . $this->produit->name . ' est en rupture de stock.')
            ->action('Voir Produit', url('/produits/' . $this->produit->id));
    }
}
