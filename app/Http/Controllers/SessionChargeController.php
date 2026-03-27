<?php

namespace App\Http\Controllers;

use App\Models\SessionCharge;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SessionChargeController extends Controller
{


    public function startSession($reservationId)
    {
        DB::beginTransaction();

        try{
            $reservation = Reservation::findOrFail($reservationId);

            if ($reservation->sessionCharge) {
                return response()->json([
                    'message' => 'Session déjà démarrée'
                ], 400);
            }
            $session = SessionCharge::create([
                'reservation_id' => $reservation->id,
                'debut_session' => now(),
                'fin_session' => null,
            ]);

            $reservation->update([
                'statut' => 'active'
            ]);

            DB::commit();

            return response()->json($session, 201);
        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'message' => 'Erreur lors du démarrage de la session',
                'error' => $e->getMessage()
            ], 500);
        }
    }

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

        return [
            'id' => $session->id,
            'borne' => $borne->nom,
            'localisation' => $borne->localisation,
            'debut' => $session->debut_session,
            'fin' => $session->fin_session,
            'energie delivree' => $session->energie_delivree,
            'statut' => is_null($session->fin_session) ? 'en cours' : 'terminée'
        ];
    }

}
