@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="c">
            <div class="d-flex gap-2 mb-3">
                <h4>Laporan Prediksi</h4>
                <form id="downloadForm" method="POST" action="{{ route('download_pdf') }}">
                    @csrf
                    <input type="hidden" name="filterYear" id="filterYearInput">
                    <input type="hidden" name="nama_obat" id="namaObatInput">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                </form>                
            </div>
            <div class="card shadow border-0">
                <div class="card-body">
                    <!-- Form Select untuk Filter Tahun dan Nama Obat -->
                    <div class="form-group mb-3">
                        <label for="filterYear">Filter Tahun:</label>
                        <select id="filterYear" class="form-control">
                            <option value="all">Semua Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_obat">Pilih Nama Obat:</label>
                        <select name="nama_obat" id="nama_obat" class="form-control">
                            <option value="all">Semua Obat</option>
                            @foreach($namaObats as $namaObat)
                                <option value="{{ $namaObat }}">{{ $namaObat }}</option>
                            @endforeach
                        </select>
                    </div>
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
                                @foreach ($years as $year)
                                    <tr class="data-row" data-year="{{ $year }}" data-obat="{{ $namaObat }}">
                                        <td>{{ $namaObat }}</td>
                                        <td>{{ $year }}</td>
                                        @for ($month = 1; $month <= 12; $month++)
                                            <td>
                                                @php
                                                    $found = false;
                                                    foreach ($prediksiObat as $prediksi) {
                                                        if (\Carbon\Carbon::createFromFormat('M-Y', $prediksi->bulan_tahun)->format('Y') == $year &&
                                                            \Carbon\Carbon::createFromFormat('M-Y', $prediksi->bulan_tahun)->format('m') == str_pad($month, 2, '0', STR_PAD_LEFT)) {
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript untuk Filter Tahun dan Nama Obat
        document.getElementById('filterYear').addEventListener('change', function() {
            filterData();
            updateDownloadForm();
        });

        document.getElementById('nama_obat').addEventListener('change', function() {
            filterData();
            updateDownloadForm();
        });

        function filterData() {
            var selectedYear = document.getElementById('filterYear').value;
            var selectedObat = document.getElementById('nama_obat').value;
            var rows = document.querySelectorAll('.data-row');

            rows.forEach(function(row) {
                var yearMatch = (selectedYear === 'all' || row.getAttribute('data-year') === selectedYear);
                var obatMatch = (selectedObat === 'all' || row.getAttribute('data-obat') === selectedObat);

                if (yearMatch && obatMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function updateDownloadForm() {
            document.getElementById('filterYearInput').value = document.getElementById('filterYear').value;
            document.getElementById('namaObatInput').value = document.getElementById('nama_obat').value;
        }

        // Inisialisasi form filter saat halaman dimuat
        updateDownloadForm();
    </script>
@endsection
