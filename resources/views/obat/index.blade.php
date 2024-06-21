@extends('layouts.admin')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="obat-tab" data-bs-toggle="tab" data-bs-target="#obat" type="button"
                    role="tab" aria-controls="obat" aria-selected="true">Data Obat</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="obat-masuk-tab" data-bs-toggle="tab" data-bs-target="#obat-masuk"
                    type="button" role="tab" aria-controls="obat-masuk" aria-selected="false">Obat Masuk</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="obat-keluar-tab" data-bs-toggle="tab" data-bs-target="#obat-keluar"
                    type="button" role="tab" aria-controls="obat-keluar" aria-selected="false">Obat Keluar</button>
            </li>
        </ul>
        <div class="card p-3">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="obat" role="tabpanel" aria-labelledby="obat-tab">
                    <div class="d-flex gap-2">
                        <h4>Data Obat</h4>
                        <button class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> Tambah</button>
                        <button class="btn btn-outline-primary btn-sm"><i class="fas fa-print"></i> Laporan</button>
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
                                <th>Selisih</th>
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
                                            <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane fade" id="obat-masuk" role="tabpanel" aria-labelledby="obat-masuk-tab">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>jdkfhkj </td>
                                <td>jdfhjk</td>
                                <td>jsfbj</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="obat-keluar" role="tabpanel" aria-labelledby="obat-keluar-tab">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>dsfsd</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
