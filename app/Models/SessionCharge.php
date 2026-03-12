<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCharge extends Model
{
    /** @use HasFactory<\Database\Factories\SessionChargeFactory> */
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'debut_session',
        'fin_session',
        'energie_delivree'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
