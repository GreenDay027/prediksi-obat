<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanController extends Controller
{
    public function index()
    {
        $prediksis = Prediksi::all()->groupBy('nama_obat');
        return view('laporan.index', compact('prediksis'));
    }

    public function downloadPDF()
    {
        $prediksis =  Prediksi::all()->groupBy('nama_obat'); 

        $html = view('prediksi.pdf',  ['prediksis' => $prediksis])->render();

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
