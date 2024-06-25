<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil semua data prediksi
        $prediksi = Prediksi::all();

        // Return view dengan data prediksi
        return view('laporan.index', [
            'prediksi' => $prediksi
        ]);
    }
    
}
