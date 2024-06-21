@extends('layouts.admin')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="obat-tab" data-bs-toggle="tab" data-bs-target="#obat" type="button"
                    role="tab" aria-controls="obat" aria-selected="true">Laporan Prediksi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="obat-masuk-tab" data-bs-toggle="tab" data-bs-target="#obat-masuk"
                    type="button" role="tab" aria-controls="obat-masuk" aria-selected="false">Laporan Permintaan</button>
            </li>
        </ul>
        <div class="card p-3">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="obat" role="tabpanel" aria-labelledby="obat-tab">
                    <div class="d-flex gap-2">
                        <h4>Laporan Prediksi</h4>
                        <button class="btn btn-outline-primary btn-sm"><i class="fas fa-download"></i> Download</button>
                    </div>
                    <table class="table mt-3" id="myTable">
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
                            @for ($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td>202{{ $i }}</td>
                                    <td>Obat {{ $i }}</td>
                                    @for ($month = 1; $month <= 12; $month++)
                                        <td>{{ rand(10, 100) }}</td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                   
                </div>
                <div class="tab-pane fade" id="obat-masuk" role="tabpanel" aria-labelledby="obat-masuk-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <h4>Permintaan Rutin</h4>
                                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i> Tambah Baru</button>
                            </div>
                            <table class="table mt-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Obat</th>
                                        <th>Jenis</th>
                                        <th>Satuan</th>
                                        <th>Periode</th>
                                        <th>Stok Masuk</th>
                                        <th>Stok Keluar</th>
                                        <th>Sisa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>Obat {{ $i }}</td>
                                            <td>Jenis {{ $i }}</td>
                                            <td>Satuan {{ $i }}</td>
                                            <td>Periode {{ $i }}</td>
                                            <td>{{ rand(10, 100) }}</td>
                                            <td>{{ rand(1, 10) }}</td>
                                            <td>{{ rand(1, 100) - rand(1, 10) }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-primary btn-sm "><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                            <button class="float-end mt-3 btn btn-primary btn-sm mx-5">
                               <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <h4>Permintaan Khusus</h4>
                                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i> Tambah Baru</button>
                            </div>
                            <table class="table mt-3" id="myTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Obat</th>
                                        <th>Jenis</th>
                                        <th>Satuan</th>
                                        <th>Periode</th>
                                        <th>Stok Masuk</th>
                                        <th>Stok Keluar</th>
                                        <th>Sisa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>Obat {{ $i }}</td>
                                            <td>Jenis {{ $i }}</td>
                                            <td>Satuan {{ $i }}</td>
                                            <td>Periode {{ $i }}</td>
                                            <td>{{ rand(10, 100) }}</td>
                                            <td>{{ rand(1, 10) }}</td>
                                            <td>{{ rand(1, 100) - rand(1, 10) }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-primary btn-sm btn-sm"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                            <button class="float-end mt-3 btn btn-primary btn-sm mx-5">
                                <i class="fas fa-print"></i> Cetak
                             </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
