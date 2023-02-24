<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootstrap-5.2.0/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @yield ('header_styles')
</head>
<body>
    <!-- Page Wrapper -->
    <div id="wrapper">

    @auth
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <!-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> -->
                <div class="sidebar-brand-text mx-3">
                    <img src="{{ asset('images/logo.png') }}" width="50px"/>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('home') || request()->is('/')) ? 'text-info' : '' }}" href="{{ url('/home') }}" title="Dashboard">
                    <div class="menu-icon">
                        <i class="fas fa-fw fa-tachometer-alt {{ (request()->is('home') || request()->is('/')) ? 'text-info' : '' }}"></i>
                    </div>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link dropdown-toggle collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSchedules"
                    aria-expanded="{{ (request()->is('categories') || request()->is('discounts')) ? 'true' : 'false' }}" aria-controls="collapsePages">
                    <div class="menu-icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span>Jadwal</span>
                </a>
                <div id="collapseSchedules" class="collapse {{ (request()->routeIs('schedules.*') || request()->is('schedules/print')) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded">
                        <a class="collapse-item {{ (request()->routeIs('schedules.*')) ? 'text-info' : '' }}" href="{{ url('/schedules') }}">Jadwal</a>
                        <a class="collapse-item {{ (request()->is('schedules/print')) ? 'text-info' : '' }}" href="{{ url('/schedules/print') }}">Print</a>
                    </div>
                </div>
            </li>

            
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('worksheets*')) ? 'text-info' : '' }}" href="{{ url('/worksheets') }}" title="Worksheet">
                    <div class="menu-icon">
                        <i class="fa-solid fa-print {{ (request()->is('worksheets*')) ? 'text-info' : '' }}"></i>
                    </div>
                    <span>Worksheet</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('customers*') || request()->is('records*')) ? 'text-info' : '' }}" title="Pelanggan" href="{{ url('/customers') }}">
                    <div class="menu-icon">
                        <i class="fa-solid fa-user-tag {{ (request()->is('customers*') || request()->is('records*')) ? 'text-info' : '' }}""></i>
                    </div>
                    <span>Pelanggan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('products*')) ? 'text-info' : '' }}" href="{{ url('/products') }}" title="Produk">
                    <div class="menu-icon">
                        <i class="fa-solid fa-box {{ (request()->is('products')) ? 'text-info' : '' }}"></i>
                    </div>
                    <span>Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('technicians*')) ? 'text-info' : '' }}" href="{{ url('/technicians') }}" title="Teknisi">
                    <div class="menu-icon">
                        <i class="fa-solid fa-users-gear {{ (request()->is('technicians')) ? 'text-info' : '' }}"></i>
                    </div>
                    <span>Teknisi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('users')) ? 'text-info' : '' }}" href="#" title="Pengguna">
                    <div class="menu-icon">
                        <i class="fa-solid fa-user {{ (request()->is('users')) ? 'text-info' : '' }}"></i>
                    </div>
                    <span>Pengguna</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <!-- <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div> -->

        </ul>
        <!-- End of Sidebar -->
    @endauth

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            @auth
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav align-items-center ms-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> {{ Auth::user()->name }}</span>
                                <i class="fas fa-user-circle fa-fw fa-2x"></i>
                                <!-- <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg"> -->
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a> -->
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
            @endauth
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white mt-4">
                <div class="container my-auto">
                    <div class="copyright my-auto">
                        <!-- <span>Copyright &copy; 2022 Rekap. All Right Reserved.</span> -->
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Jquery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-5.2.0/js/bootstrap.bundle.min.js') }}"></script>

     <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/9386dbefe1.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/script.min.js') }}" ></script>

    @stack('scripts')
</body>
</html>
