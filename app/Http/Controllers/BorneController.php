<?php

namespace App\Http\Controllers;

use App\Models\Borne;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBorneRequest;
use App\Http\Requests\UpdateBorneRequest;
use Illuminate\Http\Request;

class BorneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorneRequest $request)
    {
        $borne = Borne::create($request->validated());

        return response()->json($borne, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Borne $borne)
    {
       return response()->json($borne);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorneRequest $request, Borne $borne)
    {
        $borne->update($request->validated());

        return response()->json($borne);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borne $borne)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Accès refusé : seulement un administrateur peut supprimer une borne.'
            ], 403);
        }

        $borne->delete();

        return response()->json([
            'message' => 'Borne supprimée'
        ]);
    }

}
