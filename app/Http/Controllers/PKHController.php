<?php

namespace App\Http\Controllers;

use App\Models\PKH;
use Illuminate\Http\Request;

class PKHController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kebutuhanhewan = PKH::all();
        return view('backend.pkh.index', compact('kebutuhanhewan'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PKH $pKH)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PKH $pKH)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PKH $pKH)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PKH $pKH)
    {
        //
    }
}
