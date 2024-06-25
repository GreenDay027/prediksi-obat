<?php

namespace App\Http\Controllers;

use App\Models\DataObat;
use Illuminate\Http\Request;

class DataObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataObat = DataObat::all();
        return view('obat.index', compact('dataObat'));
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
        $dataObat = DataObat::create($request->all());
        return redirect()->route('data_obat.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataObat $dataObat)
    {
        $dataObat->update($request->all());
        return redirect()->route('data_obat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataObat $dataObat)
    {
        $dataObat->delete();
        return redirect()->route('data_obat.index');
    }
}
