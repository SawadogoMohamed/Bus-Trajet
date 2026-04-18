<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    use HasFactory;

    protected $fillable = [
        'ville_id',
        'nom',
        'code',
        'description',
    ];

    //  Une ligne appartient à une ville
    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    // (Déjà existant normalement)
    public function arrets()
    {
        return $this->hasMany(Arret::class);
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}
