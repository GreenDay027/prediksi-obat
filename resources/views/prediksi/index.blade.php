@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Prediksi Pemakaian Obat</h2>
        <form action="{{ route('prediksi.predict') }}" method="POST">
            @csrf
            <div class="col-md-4">
                <div class="form-group">
                    <label for="obat_id">Pilih Obat:</label>
                    <select name="obat_id" id="obat_id" class="form-control">
                        @foreach ($dataObat as $obat)
                            <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="bulan">Jumlah Bulan untuk Prediksi:</label>
                    <input type="number" name="bulan" id="bulan" class="form-control" min="1" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Prediksi</button>
        </form>

        @if (isset($predictions))
            <div class="mt-4">
                <h3>Hasil Prediksi untuk 
                    {{ is_array($namaObatFix) ? json_encode($namaObatFix) : $namaObatFix }}</h3>
                <div class="card shadow border-0">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Prediksi Pemakaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($predictions as $prediction)
                                    <tr>
                                        <td>{{ $prediction['date'] }}</td>
                                        <td>{{ $prediction['value'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <form action="{{ route('save') }}" method="POST">
                @csrf
                <input type="hidden" name="nama_obat" 
                       value="{{ is_array($namaObatFix) ? json_encode($namaObatFix) : $namaObatFix }}">
                <input type="hidden" name="predictions" value="{{ json_encode($predictions) }}">
                <input type="hidden" name="ftms" value="{{ json_encode($ftms) }}">
                <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Simpan Perhitungan
                </button>
            </form>

            <div class="mt-4">
                <h3>Nilai Perhitungan</h3>
                <div class="card shadow border-0">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Data Aktual</th>
                                    <th>S1</th>
                                    <th>S2</th>
                                    <th>S3</th>
                                    <th>a_t</th>
                                    <th>b_t</th>
                                    <th>c_t</th>
                                    <th>Ft+m</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $bulanArray = [
                                        'Januari',
                                        'Februari',
                                        'Maret',
                                        'April',
                                        'Mei',
                                        'Juni',
                                        'Juli',
                                        'Agustus',
                                        'September',
                                        'Oktober',
                                        'November',
                                        'Desember',
                                    ];
                                @endphp
                                @for ($i = 0; $i < min(count($St1s), count($xts)); $i++)
                                    <tr>
                                        <td>{{ $bulanArray[$i % 12] }}</td>
                                        <td>{{ $xts[$i] }}</td>
                                        <td>{{ $St1s[$i] }}</td>
                                        <td>{{ $St2s[$i] }}</td>
                                        <td>{{ $St3s[$i] }}</td>
                                        <td>{{ $ats[$i] ?? '0' }}</td>
                                        <td>{{ $bts[$i] ?? '0' }}</td>
                                        <td>{{ $cts[$i] ?? '0' }}</td>
                                        <td>
                                            @if ($i === 0)
                                                {{ '-' }}
                                            @else
                                                {{ $ftms[$i - 1] ?? '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h3 class="mb-2">Penjelasan Karakteristik Data</h3>
                <div class="card shadow border-0">
                    <div class="card-body">
                        <p>{{ is_array($karakteristikData) ? json_encode($karakteristikData) : $karakteristikData }}
                            <span class="fw-bold text-danger">Nilai Alpha = {{ $alpha }}</span></p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h3>Hasil Error Prediksi</h3>
                <div class="card shadow border-0">
                    <div class="card-body">
                        <p>MAD: {{ number_format($mad ?? 0, 2) }}<br>
                        MSE: {{ number_format($mse ?? 0, 2) }}<br>
                        MAPE: {{ number_format($mape ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-4">
                <div class="card-body">
                    <canvas id="dataChart" width="600" height="400"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('dataChart').getContext('2d');
                const data = {
                    labels: @json($xts),
                    datasets: [
                        {
                            label: 'Data Aktual',
                            data: @json($dataAktual),
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.2)',
                            fill: true,
                        },
                        {
                            label: 'Prediksi',
                            data: @json(array_column($predictions, 'value')),
                            borderColor: 'green',
                            backgroundColor: 'rgba(0, 255, 0, 0.2)',
                            fill: true,
                        }
                    ]
                };

                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                };

                new Chart(ctx, config);
            </script>
        @endif
    </div>
@endsection
