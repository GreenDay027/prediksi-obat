<?php

// app/Http/Controllers/PrediksiController.php

namespace App\Http\Controllers;

use App\Models\DataObat;
use App\Models\ObatKeluar;
use App\Models\Prediksi;
use Illuminate\Http\Request;

class PrediksiController extends Controller
{
    public function index()
    {
        $dataObat = DataObat::all();
        return view('prediksi.index', compact('dataObat'));
    }
    public function predict(Request $request)
    {
        $obatId = $request->input('obat_id');
        $bulan = $request->input('bulan');
        $alpha = 0.2;

        $obat = DataObat::find($obatId);
        $dataKeluar = $obat->obatKeluar()->orderBy('tanggal', 'asc')->get();

        // Mengambil data aktual
        $dataAktual = $dataKeluar->pluck('jumlah')->toArray();
        $n = count($dataAktual);

        // Inisialisasi nilai awal
        $St1 = $dataAktual[0];
        $St2 = $St1;
        $St3 = $St1;

        $St1s = [$St1];
        $St2s = [$St2];
        $St3s = [$St3];

        $ats = [];
        $bts = [];
        $cts = [];

        $aT = 0;
        $bT = 0;
        $cT = 0;

        // Melakukan perhitungan untuk tiap periode
        for ($i = 1; $i < $n; $i++) {
            $St1 = $alpha * $dataAktual[$i] + (1 - $alpha) * $St1;
            $St2 = $alpha * $St1 + (1 - $alpha) * $St2;
            $St3 = $alpha * $St2 + (1 - $alpha) * $St3;

            $St1s[] = $St1;
            $St2s[] = $St2;
            $St3s[] = $St3;

            $aT = 3 * $St1 - 3 * $St2 + $St3;
            $bT = ($alpha / (2 * (1 - $alpha) * (1 - $alpha))) * ((6 - 5 * $alpha) * $St1 - (10 - 8 * $alpha) * $St2 + (4 - 3 * $alpha) * $St3);
            $cT = ($alpha * $alpha / ((1 - $alpha) * (1 - $alpha))) * ($St1 - 2 * $St2 + $St3);

            $ats[] = $aT;
            $bts[] = $bT;
            $cts[] = $cT;
        }

        // Membuat prediksi untuk beberapa bulan ke depan
        $predictions = [];
        $lastDate = \Carbon\Carbon::parse($dataKeluar->last()->tanggal);
        $startMonth = $lastDate->copy()->startOfMonth()->addMonthNoOverflow();

        for ($m = 0; $m < $bulan; $m++) {
            $ftm = $aT + $bT * ($m + 1) + 0.5 * $cT * ($m + 1) * ($m + 1);
            $predictions[] = [
                'date' => $startMonth->copy()->addMonths($m)->format('M-Y'),
                'value' => round($ftm)
            ];
        }

        $dataObat = DataObat::all();
        $namaObatFix = $obat->nama_obat;
        return view('prediksi.index', compact('namaObatFix','obat', 'predictions', 'dataObat', 'St1s', 'St2s', 'St3s', 'ats', 'bts', 'cts'));
    }


    public function savePrediction(Request $request)
    {
        $predictions = json_decode($request->input('predictions'), true);
        $namaObat = $request->input('nama_obat');


        foreach ($predictions as $prediction) {
            Prediksi::create([
                'nama_obat' => $namaObat,
                'bulan_tahun' => $prediction['date'],
                'hasil_prediksi' => $prediction['value']
            ]);
        }

        return redirect()->route('prediksi.index')->with('success', 'Hasil prediksi berhasil disimpan.');
    }
    public function getBulanTahunAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('M-Y', $value);
    }


}