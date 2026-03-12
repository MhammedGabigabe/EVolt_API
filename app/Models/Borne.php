<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borne extends Model
{
    /** @use HasFactory<\Database\Factories\BorneFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'localisation',
        'type_connecteur',
        'puissance_kw',
        'statut'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
