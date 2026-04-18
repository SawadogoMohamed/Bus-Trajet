<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'ligne_id',
        'numero_bus',
        'etat',
        'occupe',
    ];

    // 🔗 Chaque bus appartient à une ligne
    public function ligne()
    {
        return $this->belongsTo(Ligne::class);
    }

    // 🔗 Un bus a un conducteur
    public function conducteur()
    {
        return $this->hasOne(Conducteur::class);
    }

    // 🔗 Un bus a plusieurs positions GPS
    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}

