<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar tahun dan nama obat untuk filter
        $years = Prediksi::selectRaw('YEAR(STR_TO_DATE(bulan_tahun, "%b-%Y")) as year')
                         ->distinct()
                         ->orderBy('year')
                         ->pluck('year');


        $namaObats = Prediksi::select('nama_obat')->distinct()->pluck('nama_obat');
        
        // Query data prediksi dengan filter jika diterapkan
        $query = Prediksi::query();
        
        if ($request->has('year') && $request->year !== 'all') {
            $query->whereYear('bulan_tahun', $request->year);
        }

        if ($request->has('nama_obat') && $request->nama_obat !== 'all') {
            $query->where('nama_obat', $request->nama_obat);
        }

        $prediksis = $query->get()->groupBy('nama_obat');
        
        return view('laporan.index', compact('prediksis', 'years', 'namaObats'));
    }

    public function downloadPDF(Request $request)
{
   
    $query = Prediksi::query();

    if ($request->has('filterYear') && $request->filterYear !== 'all') {
        $query->whereRaw('YEAR(STR_TO_DATE(bulan_tahun, "%b-%Y")) = ?', [$request->filterYear]);
    }

    if ($request->has('nama_obat') && $request->nama_obat !== 'all') {
        $query->where('nama_obat', $request->nama_obat);
    }

    $prediksis = $query->get();
    $prediksisGrouped = $prediksis->groupBy('nama_obat');

    $prediksisPerYear = [];
    foreach ($prediksisGrouped as $namaObat => $prediksiObat) {
        $prediksisPerYear[$namaObat] = $prediksiObat->groupBy(function($item) {
            return \Carbon\Carbon::createFromFormat('M-Y', $item->bulan_tahun)->format('Y');
        });
    }

    $years = $prediksis->map(function($item) {
        return \Carbon\Carbon::createFromFormat('M-Y', $item->bulan_tahun)->format('Y');
    })->unique()->values();
    

    $html = view('prediksi.pdf', [
        'prediksis' => $prediksisGrouped,
        'prediksisPerYear' => $prediksisPerYear,
        'years' => $years
    ])->render();

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    return $dompdf->stream('laporan_prediksi.pdf');
}

}
