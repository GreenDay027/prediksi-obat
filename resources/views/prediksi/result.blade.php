@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Hasil Prediksi Pemakaian Obat</h2>
    <h3>Obat: {{ $obat->nama }}</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Prediksi Pemakaian (Ft+m)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($predictions as $prediction)
                <tr>
                    <td>{{ $prediction['date'] }}</td>
                    <td>{{round($prediction['value']) }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('prediksi.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
