<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'latitude',
        'longitude',
    ];

    // 🔗 La position appartient à un bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}

