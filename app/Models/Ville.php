<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'latitude',
        'longitude'
    ];

    public function lignes()
    {
        return $this->hasMany(Ligne::class);
    }
}

