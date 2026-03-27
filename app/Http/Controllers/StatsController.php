<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borne;

class StatsController extends Controller
{
        public function bornes()
        {
            if(auth()->user()->role !== 'admin'){
                return response()->json(['message' => 'Accès refusé'], 403);
            }

            $bornes = Borne::with('reservations.sessionCharge')->get();

            $stats = $bornes->map(function($borne) {

                $totalMinutes = 0;
                $usedMinutes = 0;
                $energieTotale = 0;

                foreach($borne->reservations as $reservation){
                    $minutesReservation = $reservation->duree_minutes;
                    $totalMinutes += $minutesReservation;

                    if($reservation->statut === 'terminee' || $reservation->statut === 'active'){
                        $usedMinutes += $minutesReservation;
                    }

                    $session = $reservation->sessionCharge;
                    if($session){
                        $energieTotale += $session->energie_delivree ?? 0;
                    }
                }

                $tauxOccupation = $totalMinutes > 0 
                    ? round(($usedMinutes / $totalMinutes) * 100, 2): 0;

                return [
                    'borne_id' => $borne->id,
                    'nom' => $borne->nom,
                    'localisation' => $borne->localisation,
                    'type_connecteur' => $borne->type_connecteur,
                    'puissance_kw' => $borne->puissance_kw,
                    'statut' => $borne->statut,
                    'taux_occupation' => $tauxOccupation . '%',
                    'energie_totale' => round($energieTotale, 2) . ' kWh',
                    'nombre_reservations' => $borne->reservations->count()
                ];
            });

            return response()->json($stats);
        }
}
