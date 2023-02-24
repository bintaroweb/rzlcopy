@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-12">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-raised border-start border-info border-4">
                <div class="card-header">Hari Ini</div>
                <div class="card-body px-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="me-2">
                            <div class="display-5"><strong>{{ $today }}</strong></div>
                            <div class="card-text">Jadwal Kunjungan</div>
                        </div>
                        <div class="icon-circle bg-info text-white"><i class="fa-sharp fa-solid fa-clipboard"></i></div>
                    </div>
                    <!-- <div class="card-text">
                        <div class="d-inline-flex align-items-center">
                            <i class="material-icons icon-xs text-success">arrow_upward</i>
                            <div class="caption text-success fw-500 me-2">3%</div>
                            <div class="caption">from last month</div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-raised border-start border-primary border-4">
                <div class="card-header">Hari Ini</div>
                <div class="card-body px-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="me-2">
                            <div class="display-5"><strong>{{ $technician }}</strong></div>
                            <div class="card-text">Teknisi Kunjungan</div>
                        </div>
                        <div class="icon-circle bg-primary text-white"><i class="fa-solid fa-users-gear"></i></div>
                    </div>
                    <!-- <div class="card-text">
                        <div class="d-inline-flex align-items-center">
                            <i class="material-icons icon-xs text-success">arrow_upward</i>
                            <div class="caption text-success fw-500 me-2">3%</div>
                            <div class="caption">from last month</div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-raised border-start border-danger border-4">
                <div class="card-header">Besok</div>
                <div class="card-body px-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="me-2">
                            <div class="display-5"><strong>{{ $tommorow }}</strong></div>
                            <div class="card-text">Jadwal Kunjungan</div>
                        </div>
                        <div class="icon-circle bg-danger text-white"><i class="fa-solid fa-right-to-line"></i></div>
                    </div>
                    <!-- <div class="card-text">
                        <div class="d-inline-flex align-items-center">
                            <i class="material-icons icon-xs text-success">arrow_upward</i>
                            <div class="caption text-success fw-500 me-2">3%</div>
                            <div class="caption">from last month</div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


