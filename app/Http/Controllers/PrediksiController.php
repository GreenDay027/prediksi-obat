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
        $dataObats = DataObat::all();
        return view('prediksi.index', compact('dataObats'));
    }
    public function predict(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'data_obat_id' => 'required|exists:data_obat,id',
            'tahun' => 'required|integer|min:2020|max:2030',
        ]);

        // Ambil data obat berdasarkan ID
        $dataObat = DataObat::find($validated['data_obat_id']);
        if (!$dataObat) {
            return redirect()->back()->with('error', 'Data obat tidak ditemukan.');
        }

        // Nilai alpha untuk peramalan eksponensial
        $alpha = 0.5;

        // Ambil data stok keluar obat berdasarkan obat_id dan tahun
        $dataStok = ObatKeluar::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->where('obat_id', $validated['data_obat_id'])
            ->whereYear('tanggal', $validated['tahun'])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        // Inisialisasi variabel untuk perhitungan eksponensial smoothing
        $s1 = 0;
        $s2 = 0;
        $s3 = 0;
        $prediksi = [];
        $totalPrediksiTahun = 0;

        foreach ($dataStok as $index => $data) {
           
            $bulan = $data->bulan;

            if ($index == 0) {
                // Inisialisasi nilai awal
                $s1 = $data->total;
                $s2 = $s1;
                $s3 = $s1;
            } else {
                // Perhitungan eksponensial smoothing
                $s1_new = $alpha * $data->total + (1 - $alpha) * $s1;
                $s2_new = $alpha * $s1_new + (1 - $alpha) * $s2;
                $s3_new = $alpha * $s2_new + (1 - $alpha) * $s3;

                // Perhitungan komponen at, bt, ct
                $at = 3 * $s1_new - 3 * $s2_new + $s3_new;
                $bt = ($alpha / (2 * pow((1 - $alpha), 2))) * ((6 - 5 * $alpha) * $s1_new - (10 - 8 * $alpha) * $s2_new + (4 - 3 * $alpha) * $s3_new);
                $ct = (pow($alpha, 2) / pow((1 - $alpha), 2)) * ($s1_new - 2 * $s2_new + $s3_new);

                // Simpan hasil prediksi dalam array
                $prediksi[] = [
                    'data_obat_id' => $validated['data_obat_id'],
                    'nama_obat' => $dataObat->nama_obat,
                    'bulan' => $bulan,
                    'tahun' => $validated['tahun'] + 1,
                    's1' => $s1,
                    's2' => $s2,
                    's3' => $s3,
                    'at' => $at,
                    'bt' => $bt,
                    'ct' => $ct,
                    'prediksi' => $at + $bt * ($index + 1) + 0.5 * $ct * pow(($index + 1), 2)
                ];

                // Update total prediksi tahunan
                $totalPrediksiTahun += $at + $bt * ($index + 1) + 0.5 * $ct * pow(($index + 1), 2);

                // Update nilai s1, s2, s3 untuk iterasi selanjutnya
                $s1 = $s1_new;
                $s2 = $s2_new;
                $s3 = $s3_new;
            }
        }

        // dd($prediksi);
       
        // Simpan total prediksi tahunan ke dalam array prediksi
        $prediksiPerTahun[] = [
            'nama_obat' => $dataObat->nama_obat,
            'bulan' => 'Total',
            'tahun' => $validated['tahun'] + 1,
            'total_prediksi' => $totalPrediksiTahun,
        ];

        foreach ($prediksi as $dataPrediksi) {
            Prediksi::create($dataPrediksi);
        }
        // dd($prediksiPerTahun);
        
        // Return view dengan data prediksi
        return view('prediksi.index', [
            'dataObats' => DataObat::all(),
            'prediksi' => $prediksi,
            'prediksiPerTahun' => $prediksiPerTahun,
            'validated' => $validated
        ])->with('success', 'Prediksi berhasil dihitung.');
    }
}


