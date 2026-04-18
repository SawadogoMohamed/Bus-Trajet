<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Departement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
        'pdf_path',
        'enregistrer',
        'modifier'

    ];

  


    //configuration pour la table pivot de departement_partenaire

   

}
