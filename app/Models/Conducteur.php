<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // 👈 important si tu veux gérer une connexion
use Illuminate\Notifications\Notifiable;

class Conducteur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'bus_id',
        'nomPrenom',
        'email',
        'telephone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔗 Le conducteur conduit un bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}

