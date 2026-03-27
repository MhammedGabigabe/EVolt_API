<?php

namespace App\Http\Controllers;

use App\Models\SessionCharge;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SessionChargeController extends Controller
{
    public function mySessions()
    {
        $user = auth()->user();

        $sessions = SessionCharge::whereHas('reservation', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('reservation.borne')
        ->get();

        $actuelles = $sessions->filter(function($session) {
            return is_null($session->fin_session);
        })->values();

        $passees = $sessions->filter(function($session) {
            return !is_null($session->fin_session);
        })->values();

        return response()->json([
            'actuelles' => $actuelles->map(fn($s) => $this->formatSession($s)),
            'passees' => $passees->map(fn($s) => $this->formatSession($s)),
        ]);
    }

    private function formatSession($session)
    {
        $borne = $session->reservation->borne;

        $debut = Carbon::parse($session->debut_session);

        $fin = $session->fin_session
            ? Carbon::parse($session->fin_session)
            : now();

        $dureeMinutes = $debut->diffInMinutes($fin);
        $dureeHeures = $dureeMinutes / 60;

        $energie = $borne->puissance_kw * $dureeHeures;

        return [
            'id' => $session->id,
            'borne' => $borne->nom,
            'localisation' => $borne->localisation,
            'debut' => $session->debut_session,
            'fin' => $session->fin_session,
            'energie delivree' => round($energie, 2),
            'statut' => is_null($session->fin_session) ? 'en cours' : 'terminée'
        ];
    }
}
