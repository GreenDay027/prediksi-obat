@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>100</h4>
                    <h5>Customers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>$<span class="counters" data-count="307144.00">$307,144.00</span></h5>
                    <h6>Total Purchase Due</h6>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12">
            <h3 class="fw-bold">Selamat Datang {{ Auth::user()->name }}</h3>
        </div> --}}
    </div>
@endsection
