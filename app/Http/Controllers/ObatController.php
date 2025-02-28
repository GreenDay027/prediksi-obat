<?php

namespace App\Http\Controllers;

use App\Models\DataObat;
use App\Models\ObatKeluar;
use App\Models\ObatMasuk;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $dataObat = DataObat::all();
        $dataObatMasuk = ObatMasuk::with('dataObat')->get();
        $dataObatKeluar = ObatKeluar::with('dataObat')->get();
        return view('obat.index', compact('dataObat', 'dataObatMasuk', 'dataObatKeluar'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ($request->has('jenis_form')) {
            if ($request->jenis_form == 'data_obat') {
                $request->validate([
                    'nama_obat' => 'required|string|max:255',
                    'jenis' => 'required|string|max:255',
                    'satuan' => 'required|in:botol,kapsul,tablet,sachet',
                    'periode' => 'required|string|max:4',
                ]);

                DataObat::create($request->all());
            } elseif ($request->jenis_form == 'obat_masuk') {
                $request->validate([
                    'data_obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'nullable|integer',
                    'start' => 'nullable',
                    'tanggal' => 'date',
                    'kadaluarsa' => 'required|date',
                ]);

                $total = $request->jumlah + $request->start;
                $obatMasuk = ObatMasuk::create($request->all());
                $dataObat = DataObat::find($request->data_obat_id);
                $dataObat->increment('stok_masuk', $total);
                $dataObat->increment('sisa', $total);
            } elseif ($request->jenis_form == 'obat_keluar') {
                $validatedData = $request->validate([
                    'data_obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'required|integer',
                    'tanggal' => 'required|date',
                ]);
            
                // Cari data obat berdasarkan ID yang dipilih
                $dataObat = DataObat::findOrFail($request->data_obat_id);
            
                // Cek apakah jumlah yang dimasukkan melebihi stok yang tersedia
                if ($request->jumlah > $dataObat->sisa) {
                    return back()->with('error', 'Jumlah obat yang dimasukkan melebihi stok yang tersedia!')->withInput();
                }
            
                // Lanjutkan dengan penyimpanan jika validasi berhasil
                $obatKeluar = ObatKeluar::create($validatedData);
                $dataObat->increment('stok_keluar', $request->jumlah);
                $dataObat->decrement('sisa', $request->jumlah);
            }
        }

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        if ($request->has('jenis_form')) {
            if ($request->jenis_form == 'data_obat') {
                $request->validate([
                    'nama_obat' => 'required|string|max:255',
                    'jenis' => 'required|string|max:255',
                    'satuan' => 'required|in:botol,kapsul,tablet,sachet',
                    'periode' => 'required|string|max:4',
                ]);

                $dataObat = DataObat::find($id);
                $oldJenis = $dataObat->jenis;

                // Update DataObat
                $dataObat->update($request->all());

                // Handle changes for `stok_keluar` from the old type to the new type
                if ($dataObat->jenis !== $oldJenis) {
                    $obatKeluars = ObatKeluar::where('data_obat_id', $id)->get();
                    foreach ($obatKeluars as $obatKeluar) {
                        $dataObatLama = DataObat::where('jenis', $oldJenis)->first();
                        if ($dataObatLama) {
                            $dataObatLama->decrement('stok_keluar', $obatKeluar->jumlah);
                            $dataObatLama->increment('sisa', $obatKeluar->jumlah);
                        }

                        $dataObatBaru = DataObat::where('jenis', $dataObat->jenis)->first();
                        if ($dataObatBaru) {
                            $dataObatBaru->increment('stok_keluar', $obatKeluar->jumlah);
                            $dataObatBaru->decrement('sisa', $obatKeluar->jumlah);
                        }
                    }
                }
            } elseif ($request->jenis_form == 'obat_masuk') {
                $request->validate([
                    'data_obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'nullable|integer',
                    'tanggal' => 'required|date',
                    'start' => 'nullable'
                ]);

                $obatMasuk = ObatMasuk::find($id);
    
                // Ambil data obat terkait
                $dataObat = DataObat::find($obatMasuk->data_obat_id);
            
                // Hitung total stok yang akan dikurangi dari data_obat (stok lama)
                $totalLama = ($obatMasuk->jumlah ?? 0) + ($obatMasuk->start ?? 0);
                
                // Kurangi stok dari data_obat berdasarkan total stok lama
                $dataObat->decrement('stok_masuk', $totalLama);
                $dataObat->decrement('sisa', $totalLama);
            
                // Inisialisasi array data yang akan diupdate
                $updateData = [
                    'data_obat_id' => $request->data_obat_id,
                    'tanggal' => $request->tanggal,
                ];
            
                // Periksa jika 'jumlah' tidak null, tambahkan ke array update
                if (!is_null($request->jumlah)) {
                    $updateData['jumlah'] = $request->jumlah;
                }
                if (!is_null($request->tangal)) {
                    $updateData['tangal'] = $request->tangal;
                }
            
                // Periksa jika 'start' tidak null, tambahkan ke array update
                if (!is_null($request->start)) {
                    $updateData['start'] = $request->start;
                }
            
                // Update data obat masuk dengan data yang sudah difilter
                $obatMasuk->update($updateData);
            
                // Hitung total stok baru yang akan ditambahkan ke data_obat (stok baru)
                $totalBaru = ($request->jumlah ?? 0) + ($request->start ?? 0);
            
                // Tambahkan stok baru ke data_obat
                $dataObat->increment('stok_masuk', $totalBaru);
                $dataObat->increment('sisa', $totalBaru);
            
            } elseif ($request->jenis_form == 'obat_keluar') {
                $request->validate([
                    'data_obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'required|integer',
                    'tanggal' => 'required|date',
                ]);

                
                $obatKeluar = ObatKeluar::find($id);
                $dataObat = DataObat::find($obatKeluar->data_obat_id);
                $dataObat->decrement('stok_keluar', $obatKeluar->jumlah);
                $dataObat->increment('sisa', $obatKeluar->jumlah);
                $obatKeluar->update($request->all());
                $dataObat->increment('stok_keluar', $request->jumlah);
                $dataObat->decrement('sisa', $request->jumlah);
            }
        }

        return redirect()->route('obat.index');
    }

    public function destroy($id)
    {
        if (request()->has('jenis_form')) {
            if (request()->jenis_form == 'data_obat') {
                DataObat::destroy($id);
            } elseif (request()->jenis_form == 'obat_masuk') {
                $obatMasuk = ObatMasuk::find($id);
                $total = $obatMasuk->jumlah + $obatMasuk->start;
                $dataObat = DataObat::find($obatMasuk->data_obat_id);
                $dataObat->decrement('stok_masuk',$total);
                $dataObat->decrement('sisa',$total);
                $obatMasuk->delete();
            } elseif (request()->jenis_form == 'obat_keluar') {
                $obatKeluar = ObatKeluar::find($id);
                $dataObat = DataObat::find($obatKeluar->data_obat_id);
                $dataObat->decrement('stok_keluar', $obatKeluar->jumlah);
                $dataObat->increment('sisa', $obatKeluar->jumlah);
                $obatKeluar->delete();
            }
        }

        return redirect()->route('obat.index');
    }
}
