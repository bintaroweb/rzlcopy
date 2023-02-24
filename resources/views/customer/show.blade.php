@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-10">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800">{{ $customer->customer_name }}</h1>
    </div>
    <div class="col-md-2 d-md-flex justify-content-md-end">
        <a href="{{url('customers/'.$customer->uuid.'/edit')}}/" class="btn btn-primary btn-md mb-3"><i class="fa-regular fa-pen-to-square"></i> Ubah</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table table-striped">
            <tr>
                <td>ID Pelanggan</td>
                <td>{{ $customer->id }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>{{ $status }}</td>
            </tr>
            <tr>
                <td>Tanggal Instal</td>
                <td><span id="date">{{ date('d-m-Y', strtotime($customer->date)) }}</span></td>
            </tr>
            <tr>
                <td>Usaha/Perusahaan</td>
                <td>{{ $customer->customer_company }}</td>
            </tr>
            
        </table>
    </div>
    <div class="col-md-6">
    <table class="table table-striped">
            <tr>
                <td>Alamat</td>
                <td>{{ $customer->customer_address }}</td>
            </tr>
            <tr>
                <td>Kota/Kabupaten</td>
                <td>{{ $customer->city }}</td>
            </tr>
            <tr>
                <td>Telpon</td>
                <td>{{ $customer->customer_phone }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $customer->customer_email }}</td>
            </tr>
            
        </table>
    </div>
</div>

<div class="row mt-4">
<div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <i class="fa-solid fa-print fa-2xl"></i>
                <h5 class="card-title mt-2">Machine</h5>
                <p class="card-text">Informasi semua daftar mesin fotocopy yang disewa pelanggan</p>
                <a href="{{ url('/machines') }}/?id={{ $customer->uuid }}" class="btn btn-primary btn-sm mt-2">Lihat</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <i class="fa-regular fa-clipboard fa-2xl"></i>
                <h5 class="card-title mt-2">Machine Record</h5>
                <p class="card-text">Informasi semua catatan machine record & masalah pada mesin pelanggan</p>
                <a href="{{ url('/records') }}/?id={{ $customer->uuid }}" class="btn btn-primary btn-sm mt-2">Lihat</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <i class="fa-solid fa-file-invoice-dollar fa-2xl"></i>
                <!-- <i class="fa-regular fa-money-check-dollar "></i> -->
                <h5 class="card-title mt-2">Kwintansi</h5>
                <p class="card-text">Informasi semua kwintansi pembayaran yang sudah dikirimkan kepada pelanggan</p>
                <a href="{{ url('/invoices') }}/?id={{ $customer->id }}" class="btn btn-primary btn-sm">Lihat</a>
            </div>
        </div>
    </div>

    <!-- <div class="col-md-3">
        <div class="card" >
            <div class="card-body">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <h5 class="card-title mt-2">Pengiriman</h5>
                <p class="card-text">Informasi semua dokumen pengiriman mesin kepada pelanggan</p>
                <a href="#" class="btn btn-primary btn-sm">Lihat</a>
            </div>
        </div>
    </div> -->

    <div class="col-md-3">
        <div class="card">
            <!-- <img src="..." class="card-img-top" alt="..."> -->
            <div class="card-body">
                <i class="fa-solid fa-truck-fast fa-2xl"></i>
                <h5 class="card-title mt-2">Surat Jalan</h5>
                <p class="card-text">Informasi semua dokumen surat jalan untuk pengiriman mesin kepada pelanggan</p>
                <a href="#" class="btn btn-primary btn-sm">Lihat</a>
                <!-- <a href="{{ url('/deliveries') }}/?id={{ $customer->id }}" class="btn btn-primary btn-sm">Lihat</a> -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        var date = $('#date').text(); 
        if(!empty(date)){
            $('#date').text(tampilTanggal(date));
        }       
        

        // window.print();
    });

    getWeekday = s => {
        const [yyyy, mm, dd] = s.split('-'),
                date = new Date(yyyy, mm-1, dd)
        return date.toLocaleDateString('id-ID', {weekday: 'long'})
    }
      
    function tampilTanggal(date){
        var
        str = date,
        parts = str.split('-'),
        tahun = parseInt(parts[0], 10),
        bulan = parseInt(parts[1], 10) - 1, // NB: month is zero-based!
        tanggal = parseInt(parts[2], 10);
    
        switch(bulan) {
            case 0: bulan = "Januari"; break;
            case 1: bulan = "Februari"; break;
            case 2: bulan = "Maret"; break;
            case 3: bulan = "April"; break;
            case 4: bulan = "Mei"; break;
            case 5: bulan = "Juni"; break;
            case 6: bulan = "Juli"; break;
            case 7: bulan = "Agustus"; break;
            case 8: bulan = "September"; break;
            case 9: bulan = "Oktober"; break;
            case 10: bulan = "November"; break;
            case 11: bulan = "Desember"; break;
        }
    
        return tanggal + " " + bulan + " " + tahun;
    }
</script>

@endpush