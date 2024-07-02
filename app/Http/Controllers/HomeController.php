<?php

namespace App\Http\Controllers;

use App\Models\DataObat;
use App\Models\ObatKeluar;
use App\Models\ObatMasuk;
use App\Models\Prediksi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataObatCount = DataObat::count();
        $dataObatMasukCount = ObatMasuk::count();
        $dataObatKeluarCount = ObatKeluar::count();
        $dataPrediksiCount = Prediksi::count();
        return view('home', compact('dataObatCount', 'dataObatMasukCount', 'dataObatKeluarCount', 'dataPrediksiCount'));
    }
}
