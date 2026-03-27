<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Borne;
use Carbon\Carbon;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $user = auth()->user();
        $borne = Borne::findOrFail($request->borne_id);

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = $dateDebut->copy()->addMinutes($request->duree_minutes);

        $conflit = Reservation::where('borne_id', $borne->id)
            ->whereIn('statut', ['en_attente','active'])
            ->where(function($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('date_debut', [$dateDebut, $dateFin])
                      ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                      ->orWhere(function($q) use ($dateDebut, $dateFin){
                          $q->where('date_debut','<=',$dateDebut)
                            ->where('date_fin','>=',$dateFin);
                      });
            })
            ->exists();

        if($conflit){
            return response()->json([
                'message' => 'La borne est déjà réservée à ce créneau.'
            ], 409);
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'borne_id' => $borne->id,
            'date_debut' => $dateDebut,
            'duree_minutes' => $request->duree_minutes,
            'date_fin' => $dateFin,
            'statut' => 'en_attente'
        ]);

        $borne->update(['statut' => 'occupee']);

        return response()->json($reservation, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $user = auth()->user();

        if ($reservation->user_id !== $user->id) {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $dateDebut = $request->date_debut 
            ? \Carbon\Carbon::parse($request->date_debut)
            : $reservation->date_debut;

        $duree = $request->duree_minutes ?? $reservation->duree_minutes;

        $dateFin = $dateDebut->copy()->addMinutes($duree);

        $conflit = Reservation::where('borne_id', $reservation->borne_id)
            ->where('id', '!=', $reservation->id) // exclure elle-même
            ->whereIn('statut', ['en_attente','active'])
            ->where(function($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('date_debut', [$dateDebut, $dateFin])
                    ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                    ->orWhere(function($q) use ($dateDebut, $dateFin){
                        $q->where('date_debut','<=',$dateDebut)
                            ->where('date_fin','>=',$dateFin);
                    });
            })
            ->exists();

        if($conflit){
            return response()->json([
                'message' => 'Conflit avec une autre réservation'
            ], 409);
        }

        $reservation->update([
            'date_debut' => $dateDebut,
            'duree_minutes' => $duree,
            'date_fin' => $dateFin,
        ]);

        return response()->json($reservation);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $user = auth()->user();

        if ($reservation->user_id !== $user->id) {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $reservation->update([
            'statut' => 'annulee'
        ]);

        return response()->json([
            'message' => 'Réservation annulée'
        ]);

    }
}
