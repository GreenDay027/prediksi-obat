@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="dash-widget">
            <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="{{ $dataObatCount }} ">{{ $dataObatCount }} </span></h5>
                    <h6>Total Data Obat</h6>
                </div>
            </div>
        </div>
    </div>
@endsection
