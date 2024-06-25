@extends('layouts.admin')
@section('content')
<div class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="obat-tab" data-bs-toggle="tab" data-bs-target="#obat" type="button" role="tab" aria-controls="obat" aria-selected="true">Data Obat</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="obat-masuk-tab" data-bs-toggle="tab" data-bs-target="#obat-masuk" type="button" role="tab" aria-controls="obat-masuk" aria-selected="false">Obat Masuk</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="obat-keluar-tab" data-bs-toggle="tab" data-bs-target="#obat-keluar" type="button" role="tab" aria-controls="obat-keluar" aria-selected="false">Obat Keluar</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Data Obat Tab -->
        <div class="tab-pane fade show active" id="obat" role="tabpanel" aria-labelledby="obat-tab">
            <div class="d-flex gap-2 mt-3">
                <h4>Data Obat</h4>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDataObat">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
            <div class="card shadow border-0 mt-3">
                <div class="card-body">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Obat</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Stok Masuk</th>
                                <th>Stok Keluar</th>
                                <th>Sisa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataObat as $obat)
                            <tr>
                                <td>{{ $obat->id }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->jenis }}</td>
                                <td>{{ $obat->satuan }}</td>
                                <td>{{ $obat->stok_masuk }}</td>
                                <td>{{ $obat->stok_keluar }}</td>
                                <td>{{ $obat->sisa }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditDataObat{{ $obat->id }}"><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="jenis_form" value="data_obat">
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
        
                            <!-- Modal Edit Data Obat -->
                            <div class="modal fade" id="modalEditDataObat{{ $obat->id }}" tabindex="-1" aria-labelledby="modalEditDataObatLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditDataObatLabel">Edit Data Obat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="jenis_form" value="data_obat">
                                                <div class="mb-3">
                                                    <label for="nama_obat" class="form-label">Nama Obat</label>
                                                    <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="{{ $obat->nama_obat }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">Jenis</label>
                                                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ $obat->jenis }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="satuan" class="form-label">Satuan</label>
                                                    <select class="form-control" id="satuan" name="satuan">
                                                        <option value="botol" {{ $obat->satuan == 'botol' ? 'selected' : '' }}>Botol</option>
                                                        <option value="kapsul" {{ $obat->satuan == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                                                        <option value="tablet" {{ $obat->satuan == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="periode" class="form-label">Periode</label>
                                                    <input type="text" class="form-control" id="periode" name="periode" value="{{ $obat->periode }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Tambah Data Obat -->
            <div class="modal fade" id="modalTambahDataObat" tabindex="-1" aria-labelledby="modalTambahDataObatLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahDataObatLabel">Tambah Data Obat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('obat.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="jenis_form" value="data_obat">
                                <div class="mb-3">
                                    <label for="nama_obat" class="form-label">Nama Obat</label>
                                    <input type="text" class="form-control" id="nama_obat" name="nama_obat">
                                </div>
                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis">
                                </div>
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <select class="form-control" id="satuan" name="satuan">
                                        <option value="botol">Botol</option>
                                        <option value="kapsul">Kapsul</option>
                                        <option value="tablet">Tablet</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="periode" class="form-label">Periode</label>
                                    <input type="text" class="form-control" id="periode" name="periode">
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Obat Masuk Tab -->
        <div class="tab-pane fade" id="obat-masuk" role="tabpanel" aria-labelledby="obat-masuk-tab">
            <div class="d-flex gap-2 mt-3">
                <h4>Obat Masuk</h4>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahObatMasuk">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataObatMasuk as $obatMasuk)
                    <tr>
                        <td>{{ $obatMasuk->id }}</td>
                        <td>{{ $obatMasuk->dataObat->nama_obat }}</td>
                        <td>{{ $obatMasuk->jumlah }}</td>
                        <td>{{ $obatMasuk->tanggal }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditObatMasuk{{ $obatMasuk->id }}"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('obat.destroy', $obatMasuk->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="jenis_form" value="obat_masuk">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit Obat Masuk -->
                    <div class="modal fade" id="modalEditObatMasuk{{ $obatMasuk->id }}" tabindex="-1" aria-labelledby="modalEditObatMasukLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditObatMasukLabel">Edit Obat Masuk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('obat.update', $obatMasuk->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="jenis_form" value="obat_masuk">
                                        <div class="mb-3">
                                            <label for="obat_id" class="form-label">Nama Obat</label>
                                            <select class="form-control" id="obat_id" name="obat_id">
                                                @foreach($dataObat as $obat)
                                                    <option value="{{ $obat->id }}" {{ $obat->id == $obatMasuk->obat_id ? 'selected' : '' }}>{{ $obat->nama_obat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jumlah" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $obatMasuk->jumlah }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $obatMasuk->tanggal }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal Tambah Obat Masuk -->
            <div class="modal fade" id="modalTambahObatMasuk" tabindex="-1" aria-labelledby="modalTambahObatMasukLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahObatMasukLabel">Tambah Obat Masuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('obat.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="jenis_form" value="obat_masuk">
                                <div class="mb-3">
                                    <label for="obat_id" class="form-label">Nama Obat</label>
                                    <select class="form-control" id="obat_id" name="obat_id">
                                        @foreach($dataObat as $obat)
                                            <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Obat Keluar Tab -->
        <div class="tab-pane fade" id="obat-keluar" role="tabpanel" aria-labelledby="obat-keluar-tab">
            <div class="d-flex gap-2 mt-3">
                <h4>Obat Keluar</h4>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahObatKeluar">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataObatKeluar as $obatKeluar)
                    <tr>
                        <td>{{ $obatKeluar->id }}</td>
                        <td>{{ $obatKeluar->dataObat->nama_obat }}</td>
                        <td>{{ $obatKeluar->jumlah }}</td>
                        <td>{{ $obatKeluar->tanggal }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditObatKeluar{{ $obatKeluar->id }}"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('obat.destroy', $obatKeluar->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="jenis_form" value="obat_keluar">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit Obat Keluar -->
                    <div class="modal fade" id="modalEditObatKeluar{{ $obatKeluar->id }}" tabindex="-1" aria-labelledby="modalEditObatKeluarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditObatKeluarLabel">Edit Obat Keluar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('obat.update', $obatKeluar->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="jenis_form" value="obat_keluar">
                                        <div class="mb-3">
                                            <label for="obat_id" class="form-label">Nama Obat</label>
                                            <select class="form-control" id="obat_id" name="obat_id">
                                                @foreach($dataObat as $obat)
                                                    <option value="{{ $obat->id }}" {{ $obat->id == $obatKeluar->obat_id ? 'selected' : '' }}>{{ $obat->nama_obat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jumlah" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $obatKeluar->jumlah }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $obatKeluar->tanggal }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal Tambah Obat Keluar -->
            <div class="modal fade" id="modalTambahObatKeluar" tabindex="-1" aria-labelledby="modalTambahObatKeluarLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahObatKeluarLabel">Tambah Obat Keluar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('obat.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="jenis_form" value="obat_keluar">
                                <div class="mb-3">
                                    <label for="obat_id" class="form-label">Nama Obat</label>
                                    <select class="form-control" id="obat_id" name="obat_id">
                                        @foreach($dataObat as $obat)
                                            <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection