<?php

namespace App\Http\Controllers;

use App\Models\Borne;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBorneRequest;
use App\Http\Requests\UpdateBorneRequest;

class BorneController extends Controller
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
    public function store(StoreBorneRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Borne $borne)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorneRequest $request, Borne $borne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borne $borne)
    {
        //
    }
}
