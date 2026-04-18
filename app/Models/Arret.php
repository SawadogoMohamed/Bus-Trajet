<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arret extends Model
{
    use HasFactory;

    protected $fillable = [
        'ligne_id',
        'nom',
        'latitude',
        'longitude',
        'ordre',
    ];

    // 🔗 L'arrêt appartient à une ligne
    public function ligne()
    {
        return $this->belongsTo(Ligne::class);
    }
}
