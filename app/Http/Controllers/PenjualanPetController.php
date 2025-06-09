<?php

namespace App\Http\Controllers;

use App\Models\PenjualanPet;
use Illuminate\Http\Request;

class PenjualanPetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualan = PenjualanPet::all();
        return view('backend.jubel.index', compact('penjualan'));
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
    public function show(PenjualanPet $penjualanPet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenjualanPet $penjualanPet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenjualanPet $penjualanPet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenjualanPet $penjualanPet)
    {
        //
    }
}
