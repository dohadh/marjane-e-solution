<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public const ROLES = [
        'admin' => 'Administrateur',
        'user' => 'Utilisateur standard',
        'client' => 'Client'
    ];

    /**
     * Les attributs qui peuvent être affectés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Les attributs à masquer pour les tableaux.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à convertir en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    /**
     * Vérifie si l'utilisateur est un administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur a le rôle spécifié.
     *
     * @throws \InvalidArgumentException
     */
    public function hasRole(string $role): bool
    {
        // if (!array_key_exists($role, self::ROLES)) {
        //     throw new \InvalidArgumentException("Rôle invalide : $role");
        // }
        return $this->role === $role;
    }

    /**
     * Définit un rôle pour l'utilisateur.
     *
     * @throws \InvalidArgumentException
     */
    public function assignRole(string $role): bool
    {
        if (!array_key_exists($role, self::ROLES)) {
            throw new \InvalidArgumentException(
                "Rôle invalide. Valides : " . implode(', ', array_keys(self::ROLES))
            );
        }
        
        return $this->update(['role' => $role]);
    }

    /**
     * Vérifie si l'utilisateur est un utilisateur standard.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Change le mot de passe de l'utilisateur.
     */
    public function changePassword(string $newPassword): void
    {
        $this->update(['password' => Hash::make($newPassword)]);
    }

    /**
     * Scope pour les administrateurs.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Get the human-readable role name.
     */
    public function getRoleNameAttribute(): string
    {
        return self::ROLES[$this->role] ?? 'Inconnu';
    }

    public function promoteToAdmin(): bool
    {
        return $this->assignRole('admin');
    }
}