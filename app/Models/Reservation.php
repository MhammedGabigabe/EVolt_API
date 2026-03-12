<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'borne_id',
        'date_debut',
        'duree_minutes',
        'date_fin',
        'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function borne()
    {
        return $this->belongsTo(Borne::class);
    }

    public function sessionCharge()
    {
        return $this->hasOne(SessionCharge::class);
    }
}
