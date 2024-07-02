@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="c">
            <div class="d-flex gap-2">
                <h4>Laporan Prediksi</h4>
                <a href="{{ route('download_pdf') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download"></i> Download PDF
                </a>
            </div>
            <div class="card shadow border-0">
                <div class="card-body">
                    <table class="table mt-3" id="myTable">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle">Nama Obat</th>
                                <th rowspan="2" class="align-middle">Tahun</th>
                                <th colspan="12" class="text-center">Bulan</th>
                            </tr>
                            <tr>
                                @for ($month = 1; $month <= 12; $month++)
                                    <th>{{ $month }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prediksis as $namaObat => $prediksiObat)
                            <tr>
                                <td>{{ $namaObat }}</td>
                                <td>2024</td>
                                @for ($month = 1; $month <= 12; $month++)
                                    <td>
                                        @php
                                            $found = false;
                                            foreach ($prediksiObat as $prediksi) {
                                                if (\Carbon\Carbon::parse($prediksi->bulan_tahun)->format('Y') == 2024 &&
                                                    \Carbon\Carbon::parse($prediksi->bulan_tahun)->format('m') == str_pad($month, 2, '0', STR_PAD_LEFT)) {
                                                    echo $prediksi->hasil_prediksi;
                                                    $found = true;
                                                    break;
                                                }
                                            }
                                            if (!$found) {
                                                echo '-';
                                            }
                                        @endphp
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
           
        </div>
    </div>
@endsection
