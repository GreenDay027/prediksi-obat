@extends('layouts.admin')

@section('content')
    <div class="container">
        <h4 class="fw-bold">Prediksi </h4>
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <span>Prediksi hasil simulasi , silakan pilih obat untuk diprediksi</span>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Obat</label>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <select class="select ">
                                <option>Pilih Obat</option>
                                <option>Customer</option>
                                <option>Customer</option>
                                <option>Customer</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Bulan dan Tahun</label>
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <select class="select">
                                <option>Pilih Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <!-- Tambahkan opsi bulan lainnya -->
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6">
                            <select class="select">
                                <option>Pilih Tahun</option>
                                <option>2024</option>
                                <option>2023</option>
                                <option>2022</option>
                                <!-- Tambahkan opsi tahun lainnya -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex">
            <div class="col-md-4">
                <h6 class="fw-bold mb-1" >Data Obat yang dipilih</h6>
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mt-3 datatable" >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Obat</th>
                                        <th>Stok</th>
                                        <th>Bulan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>Obat {{ $i }}</td>
                                            <td> {{ rand($i * 10, $i * 100) }}</td>
                                            <td>{{ $i }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h6 class="fw-bold mb-1" >Prediksi</h6>
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mt-3 datatable" >
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>S1</th>
                                        <th>S2</th>
                                        <th>S3</th>
                                        <th>Prediksi</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ rand($i , 1000) }}</td>
                                            <td> {{ rand($i * 10, $i * 100) }}</td>
                                            <td> {{ rand($i * 10, $i * 100) }}</td>
                                            <td> {{ rand($i * 10, $i * 100) }}</td>
                                            <td>Stok {{ rand($i * 100 , $i *1000) }}</td>
                                        </tr>
                                       
                                    @endfor
                                    
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
