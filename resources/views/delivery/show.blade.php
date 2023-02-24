@extends('layouts.app')

@section('header_styles')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<style>
@media print {
  @page {
    size: auto;
    margin: 0mm;
  }

  /* in case @page {margin: 5cm 0 5cm 0;} doesn't work */
  body {
    padding: 1cm !important;
  }
}
</style>
@endsection


@section('content')

<div class="row">
    <div class="col-md-8">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800">Detail Surat Jalan</h1>
    </div>
    <div class="col-md-4 d-md-flex justify-content-md-end">
        <!-- <a href="{{ url('/schedules/print') }}" class="btn btn-secondary btn-md mb-3 me-3"><i class="fas fa-print"></i> Print</a> -->
        <a href="{{ url('/deliveries/cetak') }}/?id={{ $id }}" target="_blank" class="btn btn-success btn-md mb-3 me-3"><i class="fas fa-print"></i> Print</a>
    </div>
</div>

<!-- Data Pelanggan -->
<div class="card shadow mb-4" id="card">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-2 align-self-center"><img class="mx-auto d-block" src="https://i.ibb.co/tCtZcpb/rs.jpg" width="85px"/></div>
            <div class="col-md-4">
                <h3 class="m-0 font-weight-bold">CV Restu Jaya Sentosa</h3>
                <p>Jl. Bangka Blok DII No 3 Vila Bintaro Indah   <br/>
                    Ciputat, Tangerang Selatan 15153  <br/>
                    Telp. (021) 74861939 / (021) 7457959 
                </p>
            </div>
            <div class="col-md-6">
                <input type="hidden" id="date" value="{{ $delivery->date }}" />
                <p>Tangerang, <span id="tanggal"></span></p>
                <table>
                    <!-- <tr>
                        <td></td>
                        <td></td>
                    </tr> -->
                    <tr>
                        <td>No</td>
                        <td style="width: 10px" class="text-center">:</td>
                        <td>{{ $delivery->no }}</td>
                    </tr>
                    <tr>
                        <td class="align-top">Kepada</td>
                        <td style="width: 10px" class="text-center align-top">:</td>
                        <td class="align-top"><strong>{{ $customer->customer_name }}<br/>{{ $customer->customer_address }}<br/>{{ $customer->customer_phone }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- <div class="title text-center">
            
            
            <p id="tanggal" class="fs-5 mt-1 tanggal text-center"></p>
        </div> -->
    </div>
    <div class="card-body">
        <h3>SURAT JALAN</h3>
        <p>Kami kirimkan barang - barang tersebut di bawah ini dengan kendaraan Pick Up</p>
        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="jumlah">Total</th>
                        <th class="satuan">Satuan</th>
                        <th class="produk">Produk</th>
                        <th class="produk">Deskripsi</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td>{{ $detail['total'] }}</td>
                            <td>{{ $detail['type'] }}</td>
                            <td>{{ $detail['product'] }}</td>
                            <td>{{ $detail['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- <div class="row">
            <div class="col-md-6">
                Tanda Terima <br> <br> <br>
                (                    )
            </div>
            <div class="col-md-6">
                Hormat Kami <br> <br> <br>
                (                    ) 
            </div>
        </div> -->
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }} "></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var date = $('#date').val();
        console.log(date);
        
        $('#tanggal').text(tampilTanggal(date));

        // $('#dataTable tbody').empty();

        // var table = $('#dataTable').DataTable();
        // table
        //     .clear()
        //     .draw()
        //     .destroy()
            
        // $('#dataTable').dataTable( {
        //     "processing": true,
        //     "serverSide": true,
        //     "ordering": false,
        //     "searching": false,
        //     "paging": false,
        //     "info": false,
        //     "destroy": true,
        //     "ajax": {
        //         "url" : "{{ url('deliveries/cetak') }}",
        //         "type": "GET",
        //         "data": {
        //             "date": date
        //         }
        //     },
        //     "columns": [
        //         { data: "DT_RowIndex", className: "nomor"},
        //         { data: "customer", className: "customer"},
        //         { data: "address", className: "address"},
        //         { data: "contact", className: "contact"},
        //         { data: "problem", className: "problem"},
        //         { data: "technician", className: "technician"},
        //         // {"mRender": function ( data, type, row ) {
        //         //         return '<a href="{{url("schedules")}}/'+row.uuid+'/edit" class="btn btn-primary btn-sm btn-edit">Edit</a>';}
        //         // }
        //     ], 
        //     "language": {
        //         processing: "Mohon tunggu ..."
        //     }
        // });
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

<script>
    $('#print').click(function(){
        var tab = document.getElementById('card');
        var style = "<style>";
        style = style + "table {width: 100%; font: 14px Helvetica; margin-top: 20px}";
        style = style + ".title {text-align:center;}";
        style = style + "h3 {font: 23px Helvetica; font-weight: bold; margin: 10px 0px}";
        style = style + "td.text-center {text-align:center}";
        style = style + "td.text-end {text-align:right}";
        style = style + "td.address {vertical-align:top}";
        style = style + "th.no {width: 10px !important}";
        style = style + "th.masalah {width: 400px !important}";
        style = style + "th.name {width: auto}";
        style = style + ".tanggal {font: 18px Helvetica; font-weight: bold; margin: 10px 0px}";
        style = style + "div.box {display:flex; align-items:center; justify-content: center}";
        style = style + "td.text-uppercase {text-transform: uppercase}";
        style = style + "td.fs-2 {font-size: 25px; font-weight:bold; text-transform: uppercase}";
        style = style + "td.fs-3 {font-size: 28px; font-weight:bold; text-transform: uppercase}";
        style = style + "td.fs-4 {font-size: 20px; font-weight:bold; text-transform: uppercase}";
        style = style + "td.fs-5 {font-size: 14px; font-weight:bold; text-transform: uppercase}";
        style = style + "th {font-size: 15px; font-weight:bold; text-align:left}";
        style = style + "table, th, td {border: solid 1px #080808; border-collapse: collapse; padding: 5px;}";
        style = style + "</style>";

        var win = window.open('', '', 'height=700,width=700');
        win.document.write('<title>Print Jadwal Kunjungan Teknisi</title>');
        win.document.write(style);
        win.document.write(tab.outerHTML);
        win.document.close();
        win.print();
    })
    var myApp = new function () {
        this.printTable = function () {
            
        }
    }
</script>
@endpush