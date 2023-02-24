@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Profile Akun</h5>
                <p class="card-text">Pengaturan akun seperti nama, email dan password</p>
                <a href="{{ url('account/edit')}}" class="btn btn-primary">Ubah</a>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informasi Bisnis</h5>
                <p class="card-text">Pengaturan bisnis seperti nama bisnis, alamat, metode pembayaran, dll</p>
                <a href="{{ url('settings/company/edit')}}" class="btn btn-primary">Ubah</a>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tagihan</h5>
                <p class="card-text">Pengaturan langganan dan riwayat pembayaran</p>
                <a href="#" class="btn btn-primary">Ubah</a>
            </div>
        </div>
    </div>
</div>


@endsection