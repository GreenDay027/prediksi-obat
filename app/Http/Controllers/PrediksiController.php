<?php

namespace App\Http\Controllers;

use App\Models\DataObat;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        
        $alpha = $this->determineAlpha($obatId); 
        
        $obat = DataObat::find($obatId);
        $dataKeluar = $obat->obatKeluar()->orderBy('tanggal', 'asc')->get();
        
        $dataAktual = $dataKeluar->pluck('jumlah')->toArray();
        $n = count($dataAktual);
    
        // Inisialisasi nilai awal
        $St1 = $dataAktual[0];
        $St2 = $St1;
        $St3 = $St1;
    
        $St1s = [$St1];
        $St2s = [$St2];
        $St3s = [$St3];
        $xts = [$St1];  // Tambahkan data aktual
    
        $ats = [];
        $bts = [];
        $cts = [];
        $ftms = [];
    
        for ($i = 1; $i < $n; $i++) {
            $St1 = $alpha * $dataAktual[$i] + (1 - $alpha) * $St1;
            $St2 = $alpha * $St1 + (1 - $alpha) * $St2;
            $St3 = $alpha * $St2 + (1 - $alpha) * $St3;
    
            $St1s[] = $St1;
            $St2s[] = $St2;
            $St3s[] = $St3;
            $xts[] = $dataAktual[$i];  // Simpan data aktual
        }
    
        $aT = $bT = $cT = 0; // Initializing for loop scope
        for ($i = 0; $i < $n; $i++) {
            $aT = 3 * $St1s[$i] - 3 * $St2s[$i] + $St3s[$i];
            $bT = ($alpha / (2 * (1 - $alpha) * (1 - $alpha))) * ((6 - 5 * $alpha) * $St1s[$i] - (10 - 8 * $alpha) * $St2s[$i] + (4 - 3 * $alpha) * $St3s[$i]);
            $cT = ($alpha * $alpha / ((1 - $alpha) * (1 - $alpha))) * ($St1s[$i] - 2 * $St2s[$i] + $St3s[$i]);
    
            $ats[] = $aT;
            $bts[] = $bT;
            $cts[] = $cT;
    
            if ($i === $n - 1) {
                $ftms[] = '-';
            } else {
                $ftms[] = ($aT + $bT * 1 + 0.5 * $cT * 1 * 1);
            }
        }
    
        $predictions = [];
        $lastDate = Carbon::parse($dataKeluar->last()->tanggal);
        $startMonth = $lastDate->copy()->addMonth();
    
        for ($m = 0; $m < $bulan; $m++) {
            $ftm = $aT + $bT * ($m + 1) + 0.5 * $cT * ($m + 1) * ($m + 1);
            $predictions[] = [
                'date' => $startMonth->copy()->addMonths($m)->format('M-Y'),
                'value' => round($ftm)
            ];
        }
    
        $dataObat = DataObat::all();
        $namaObatFix = $obat->nama_obat;
        $karakteristikData = $this->getDataCharacteristics($dataAktual, $alpha);

        // Calculate MAE, MSE, MAPE
        $mae = $this->calculateMAE($dataAktual, $alpha);
        $mse = $this->calculateMSE($dataAktual, $alpha);
        $mape = $this->calculateMAPE($dataAktual, $alpha);

        return view('prediksi.index', compact(
            'namaObatFix', 
            'obat', 
            'predictions', 
            'dataObat', 
            'St1s', 
            'St2s', 
            'St3s', 
            'xts', 
            'ats', 
            'bts', 
            'cts', 
            'ftms', 
            'dataAktual', 
            'alpha', 
            'karakteristikData',
            'mae',
            'mse',
            'mape'
        ));
    }
    
    private function determineAlpha($obatId)
    {
        $obat = DataObat::find($obatId);
        $dataKeluar = $obat->obatKeluar()->orderBy('tanggal', 'asc')->get();
    
        $dataAktual = $dataKeluar->pluck('jumlah')->toArray();
        $n = count($dataAktual);

        $alphas = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9];
        $bestAlpha = 0.5;
        $bestMAE = INF;

        foreach ($alphas as $alpha) {
            $mae = $this->calculateMAE($dataAktual, $alpha);
            if ($mae < $bestMAE) {
                $bestMAE = $mae;
                $bestAlpha = $alpha;
            }
        }

        // Debugging: Menampilkan hasil perhitungan MAE untuk setiap alpha
        foreach ($alphas as $alpha) {
            $mae = $this->calculateMAE($dataAktual, $alpha);
            // dd("Alpha: $alpha, MAE: $mae");
        }

        return $bestAlpha;
    }

    private function calculateMAE($dataAktual, $alpha)
    {
        $n = count($dataAktual);
        $St1 = $dataAktual[0];
        $St2 = $St1;
        $St3 = $St1;

        $St1s = [$St1];
        $St2s = [$St2];
        $St3s = [$St3];

        for ($i = 1; $i < $n; $i++) {
            $St1 = $alpha * $dataAktual[$i] + (1 - $alpha) * $St1;
            $St2 = $alpha * $St1 + (1 - $alpha) * $St2;
            $St3 = $alpha * $St2 + (1 - $alpha) * $St3;

            $St1s[] = $St1;
            $St2s[] = $St2;
            $St3s[] = $St3;
        }

        $mae = 0;
        for ($i = 1; $i < $n; $i++) {
            $aT = 3 * $St1s[$i] - 3 * $St2s[$i] + $St3s[$i];
            $bT = ($alpha / (2 * (1 - $alpha) * (1 - $alpha))) * ((6 - 5 * $alpha) * $St1s[$i] - (10 - 8 * $alpha) * $St2s[$i] + (4 - 3 * $alpha) * $St3s[$i]);
            $cT = ($alpha * $alpha / ((1 - $alpha) * (1 - $alpha))) * ($St1s[$i] - 2 * $St2s[$i] + $St3s[$i]);
            
            $ftm = $aT + $bT * 1 + 0.5 * $cT * 1 * 1;
            $mae += abs($dataAktual[$i] - $ftm);
        }

        return $mae / ($n - 1);
    }

    private function calculateMSE($dataAktual, $alpha)
    {
        $n = count($dataAktual);
        $St1 = $dataAktual[0];
        $St2 = $St1;
        $St3 = $St1;

        $St1s = [$St1];
        $St2s = [$St2];
        $St3s = [$St3];

        for ($i = 1; $i < $n; $i++) {
            $St1 = $alpha * $dataAktual[$i] + (1 - $alpha) * $St1;
            $St2 = $alpha * $St1 + (1 - $alpha) * $St2;
            $St3 = $alpha * $St2 + (1 - $alpha) * $St3;

            $St1s[] = $St1;
            $St2s[] = $St2;
            $St3s[] = $St3;
        }

        $mse = 0;
        for ($i = 1; $i < $n; $i++) {
            $aT = 3 * $St1s[$i] - 3 * $St2s[$i] + $St3s[$i];
            $bT = ($alpha / (2 * (1 - $alpha) * (1 - $alpha))) * ((6 - 5 * $alpha) * $St1s[$i] - (10 - 8 * $alpha) * $St2s[$i] + (4 - 3 * $alpha) * $St3s[$i]);
            $cT = ($alpha * $alpha / ((1 - $alpha) * (1 - $alpha))) * ($St1s[$i] - 2 * $St2s[$i] + $St3s[$i]);
            
            $ftm = $aT + $bT * 1 + 0.5 * $cT * 1 * 1;
            $mse += pow($dataAktual[$i] - $ftm, 2);
        }

        return $mse / ($n - 1);
    }

    private function calculateMAPE($dataAktual, $alpha)
    {
        $n = count($dataAktual);
        $St1 = $dataAktual[0];
        $St2 = $St1;
        $St3 = $St1;

        $St1s = [$St1];
        $St2s = [$St2];
        $St3s = [$St3];

        for ($i = 1; $i < $n; $i++) {
            $St1 = $alpha * $dataAktual[$i] + (1 - $alpha) * $St1;
            $St2 = $alpha * $St1 + (1 - $alpha) * $St2;
            $St3 = $alpha * $St2 + (1 - $alpha) * $St3;

            $St1s[] = $St1;
            $St2s[] = $St2;
            $St3s[] = $St3;
        }

        $mape = 0;
        for ($i = 1; $i < $n; $i++) {
            $aT = 3 * $St1s[$i] - 3 * $St2s[$i] + $St3s[$i];
            $bT = ($alpha / (2 * (1 - $alpha) * (1 - $alpha))) * ((6 - 5 * $alpha) * $St1s[$i] - (10 - 8 * $alpha) * $St2s[$i] + (4 - 3 * $alpha) * $St3s[$i]);
            $cT = ($alpha * $alpha / ((1 - $alpha) * (1 - $alpha))) * ($St1s[$i] - 2 * $St2s[$i] + $St3s[$i]);
            
            $ftm = $aT + $bT * 1 + 0.5 * $cT * 1 * 1;
            $mape += abs(($dataAktual[$i] - $ftm) / $dataAktual[$i]);
        }

        return ($mape / ($n - 1)) * 100;
    }

    private function getDataCharacteristics($dataAktual, $alpha)
    {
        $n = count($dataAktual);

        if ($n < 2) {
            return 'Data tidak cukup untuk analisis.';
        }

        // Hitung rata-rata perubahan
        $totalPerubahan = 0;
        for ($i = 1; $i < $n; $i++) {
            $totalPerubahan += abs($dataAktual[$i] - $dataAktual[$i - 1]);
        }
        $rataPerubahan = $totalPerubahan / ($n - 1);
        
        // Hitung deviasi standar
        $rataRata = array_sum($dataAktual) / $n;
        $totalKuadrat = 0;
        foreach ($dataAktual as $data) {
            $totalKuadrat += pow($data - $rataRata, 2);
        }
        
        $deviasiStandar = sqrt($totalKuadrat / $n);

        
        if ($alpha < 0.3) {
            // Kriteria untuk alpha kecil
            if ($rataPerubahan < 10) {
                return 'Karakteristik Data: Rendah (Perubahan minor dengan alpha rendah)';
            } elseif ($deviasiStandar < 50) {
                return 'Karakteristik Data: Rendah (Perubahan konsisten dengan alpha rendah)';
            } else {
                return 'Karakteristik Data: Rendah (Perubahan signifikan dengan alpha rendah)';
            }
        } elseif ($alpha < 0.6) {
            // Kriteria untuk alpha menengah
            if ($rataPerubahan < 20) {
                return 'Karakteristik Data: Stabil (Perubahan minor dengan alpha menengah)';
            } elseif ($deviasiStandar < 75) {
                return 'Karakteristik Data: Stabil (Perubahan konsisten dengan alpha menengah)';
            } else {
                return 'Karakteristik Data: Stabil (Perubahan signifikan dengan alpha menengah)';
            }
        } else {
            // Kriteria untuk alpha tinggi
            if ($rataPerubahan < 30) {
                return 'Karakteristik Data: Tinggi (Perubahan minor dengan alpha tinggi)';
            } elseif ($deviasiStandar < 100) {
                return 'Karakteristik Data: Tinggi (Perubahan konsisten dengan alpha tinggi)';
            } else {
                return 'Karakteristik Data: Tinggi (Perubahan signifikan dengan alpha tinggi)';
            }
        }
    }
}
