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
                    'satuan' => 'required|in:botol,kapsul,tablet',
                    'periode' => 'required|string|max:4',
                ]);

                DataObat::create($request->all());
            } elseif ($request->jenis_form == 'obat_masuk') {
                $request->validate([
                    'obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'required|integer|min:1',
                    'tanggal' => 'required|date',
                ]);

                $obatMasuk = ObatMasuk::create($request->all());
                $dataObat = DataObat::find($request->obat_id);
                $dataObat->increment('stok_masuk', $request->jumlah);
                $dataObat->increment('sisa', $request->jumlah);
            } elseif ($request->jenis_form == 'obat_keluar') {
                $request->validate([
                    'obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'required|integer|min:1',
                    'tanggal' => 'required|date',
                ]);

                $obatKeluar = ObatKeluar::create($request->all());
                $dataObat = DataObat::find($request->obat_id);
                $dataObat->increment('stok_keluar', $request->jumlah);
                $dataObat->decrement('sisa', $request->jumlah);
            }
        }

        return redirect()->route('obat.index');
    }

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

    public function update(Request $request, $id)
    {
        if ($request->has('jenis_form')) {
            if ($request->jenis_form == 'data_obat') {
                $request->validate([
                    'nama_obat' => 'required|string|max:255',
                    'jenis' => 'required|string|max:255',
                    'satuan' => 'required|in:botol,kapsul,tablet',
                    'periode' => 'required|string|max:4',
                ]);

                $dataObat = DataObat::find($id);
                $dataObat->update($request->all());
            } elseif ($request->jenis_form == 'obat_masuk') {
                $request->validate([
                    'obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'required|integer|min:1',
                    'tanggal' => 'required|date',
                ]);

                $obatMasuk = ObatMasuk::find($id);
                $dataObat = DataObat::find($obatMasuk->obat_id);
                $dataObat->decrement('stok_masuk', $obatMasuk->jumlah);
                $dataObat->decrement('sisa', $obatMasuk->jumlah);
                $obatMasuk->update($request->all());
                $dataObat->increment('stok_masuk', $request->jumlah);
                $dataObat->increment('sisa', $request->jumlah);
            } elseif ($request->jenis_form == 'obat_keluar') {
                $request->validate([
                    'obat_id' => 'required|exists:data_obat,id',
                    'jumlah' => 'required|integer|min:1',
                    'tanggal' => 'required|date',
                ]);

                $obatKeluar = ObatKeluar::find($id);
                $dataObat = DataObat::find($obatKeluar->obat_id);
                $dataObat->increment('stok_keluar', $obatKeluar->jumlah);
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
                $dataObat = DataObat::find($obatMasuk->obat_id);
                $dataObat->decrement('stok_masuk', $obatMasuk->jumlah);
                $dataObat->decrement('sisa', $obatMasuk->jumlah);
                $obatMasuk->delete();
            } elseif (request()->jenis_form == 'obat_keluar') {
                $obatKeluar = ObatKeluar::find($id);
                $dataObat = DataObat::find($obatKeluar->obat_id);
                $dataObat->increment('stok_keluar', $obatKeluar->jumlah);
                $dataObat->increment('sisa', $obatKeluar->jumlah);
                $obatKeluar->delete();
            }
        }

        return redirect()->route('obat.index');
    }
}
