<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitationRequest;
use App\Http\Requests\UpdateCitationRequest;
use App\Models\Citation;

class CitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCitationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Citation $citation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Citation $citation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCitationRequest $request, Citation $citation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Citation $citation)
    {
        //
    }
}
