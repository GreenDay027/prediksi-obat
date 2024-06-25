@extends('layouts.admin')

@section('content')
    <div class="container">
        <h4 class="fw-bold">Prediksi</h4>
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <span>Prediksi hasil simulasi, silakan pilih obat untuk diprediksi</span>
        </div>

        <form action="{{ route('prediksi.predict') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Obat</label>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <select name="data_obat_id" class="select">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($dataObats as $dataObat)
                                        <option value="{{ $dataObat->id }}">{{ $dataObat->nama_obat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Tahun</label>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <select name="tahun" class="select">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = 2020; $i <= 2030; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Hitung Prediksi</button>
        </form>

        @if (isset($prediksi))
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header">Prediksi per Bulan</div>
                        <div class="card-body">
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="align-middle">Tahun</th>
                                        <th rowspan="2" class="align-middle">Nama Obat</th>
                                        <th colspan="12" class="text-center">Bulan</th>
                                    </tr>
                                    <tr>
                                        @for ($month = 1; $month <= 12; $month++)
                                            <th>{{ $month }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataObats as $dataObat)
                                        <tr>
                                            <td>{{ $validated['tahun'] + 1 }}</td>
                                            <td>{{ $dataObat->nama_obat }}</td>
                                            @for ($month = 1; $month <= 12; $month++)
                                                @php
                                                    $found = false;
                                                @endphp
                                                @foreach ($prediksi as $p)
                                                    @if ($p['nama_obat'] == $dataObat->nama_obat && $p['bulan'] == $month)
                                                        <td>{{ round($p['prediksi']) }}</td>
                                                        @php
                                                            $found = true;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$found)
                                                    <td>0</td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header">Detail Prediksi per Bulan</div>
                        <div class="card-body">
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>S1</th>
                                        <th>S2</th>
                                        <th>S3</th>
                                        <th>at</th>
                                        <th>bt</th>
                                        <th>ct</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prediksi as $p)
                                        <tr>
                                            <td>{{ $p['bulan'] }}</td>
                                            <td>{{ round($p['s1'], 2) }}</td>
                                            <td>{{ round($p['s2'], 2) }}</td>
                                            <td>{{ round($p['s3'], 2) }}</td>
                                            <td>{{ round($p['at'], 2) }}</td>
                                            <td>{{ round($p['bt'], 2) }}</td>
                                            <td>{{ round($p['ct'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card shadow border-0 mt-5">
                        <div class="card-header fw-bold text-dark fs-5">Prediksi per Tahun</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Tahun</th>
                                        <th>Prediksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prediksiPerTahun as $p)
                                        <tr>
                                            <td>{{ $p['nama_obat'] }}</td>
                                            <td>{{ $p['tahun'] }}</td>
                                            <td>{{ isset($p['total_prediksi']) ? round($p['total_prediksi']) : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
