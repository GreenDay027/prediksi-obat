@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Historis Prediksi</h2>
    <div class="card shadow border-0">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Bulan & Tahun</th>
                        <th>Hasil Prediksi</th>
                        <th>Tanggal Penyimpanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historis as $item)
                        <tr>
                            <td>{{ $item->nama_obat }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->bulan_tahun)->format('M-Y') }}</td>
                            <td>{{ $item->hasil_prediksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
