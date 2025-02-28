<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Prediksi Obat</title>
    <link rel="stylesheet" href="{{ asset('assets') }}css/dataTables.bootstrap5.min.css">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon.jpg">

    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/css/animate.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>

<body style="background-color: rgb(218, 218, 218)">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active ">
                <a href="index.html" class="logo mt-2">
                    <img src="{{ asset('assets') }}/img/logo-prediksi.png" alt="" style="width: 180px; height: auto;>
                </a>
                <a href="index.html" class="logo-small">
                    <img src="{{ asset('assets') }}/img/logo-prediksi.png" alt="" style="width: 180px; height: auto;>
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

              

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="{{ asset('assets') }}/img/profiles/avator1.jpg"
                                alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="{{ asset('assets') }}/img/profiles/avator1.jpg"
                                        alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ Auth::user()->name }}</h6>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i>
                                My Profile</a>
                            <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0">

                            <a class="dropdown-item logout pb-0" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                <img src="{{ asset('assets') }}/img/icons/log-out.svg" class="me-2"
                                    alt="img">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="{{ Request::is('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}"><img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt="img"><span>Dashboard</span></a>
                        </li>
                        <li class="{{ Request::is('obat*') ? 'active' : '' }}">
                            <a href="{{ route('obat.index') }}"><img src="{{ asset('assets/img/icons/product.svg') }}" alt="img"><span>Kelola Data Obat</span></a>
                        </li>
                        @if (Auth::user()->name == 'Admin')
                    
                        <li class="{{ Request::is('prediksi*') ? 'active' : '' }}">
                            <a href="{{ route('prediksi.index') }}"><img src="{{ asset('assets/img/icons/scanners.svg') }}" alt="img"><span>Data Prediksi</span></a>
                        </li>
                        @endif
                        <li class="{{ Request::is('laporan') ? 'active' : '' }}">
                            <a href="{{ route('laporan') }}"><img src="{{ asset('assets/img/icons/transcation.svg') }}" alt="img"><span>Laporan</span></a>
                        </li>
                        {{-- <li class="{{ Request::is('historis') ? 'active' : '' }}">
                            <a href="{{ route('historis') }}"><img src="{{ asset('assets/img/icons/transcation.svg') }}" alt="img"><span>Historis</span></a>
                        </li> --}}
                    
                    </ul>
                    
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{asset('assets')}}/js/jquery.dataTables.min.js" type="8e1ca45de172389332816fb4-text/javascript"></script>
    <script src="{{asset('assets')}}/js/dataTables.bootstrap5.min.js" type="8e1ca45de172389332816fb4-text/javascript"></script>
    <script src="{{ asset('assets') }}/js/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets') }}/js/feather.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script src="{{ asset('assets') }}/js/jquery.slimscroll.min.js"></script>

    <script src="{{ asset('assets') }}/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <script src="{{ asset('assets') }}/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('assets') }}/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('assets') }}/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/apexchart/chart-data.js"></script>

    <script src="{{ asset('assets') }}/js/script.js"></script>
</body>

</html>
