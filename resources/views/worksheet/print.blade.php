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
    <div class="col-md-12">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800">Print Worksheet</h1>
        <!-- <p>Pilih tanggal keluhan terlebih dahulu sebelum klik tombol Print</p> -->
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <label>Pilih Tanggal</label>
        <input type="date" class="form-control" name="date" id="date">
    </div>
    <div class="col-md-2">
    <label for="technician">Pilih Teknisi</label>
    <select class="form-control" id="technician" name="technician">
        @foreach ($technicians as $technician)
            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
        @endforeach
    </select>
    </div>
    <div class="col-md-4">
        <a href="#" class="btn btn-secondary btn-md mb-3 me-3" id="show"  style="margin-top: 27px"><i class="fa-solid fa-folder-open"></i> Tampilkan</a>
    </div>
    <div class="col-md-4 d-md-flex justify-content-md-end">
        <a href="#" class="btn btn-success btn-md mb-3 me-3" id="print"  style="margin-top: 27px"><i class="fas fa-print"></i> Print</a>
    </div>
</div>

<!-- <div class="row">
    <div class="col-md-12 d-md-flex justify-content-md-end">
        <a href="#" class="btn btn-success btn-md mb-3 me-3" id="print"  style="margin-top: 27px"><i class="fas fa-print"></i> Print</a>
    </div>
</div> -->

<!-- Data Pelanggan -->
<div class="card shadow mb-4 mt-3" id="card">
    <div class="card-header py-3">
        <div class="title text-center">
            <img src="https://i.ibb.co/tCtZcpb/rs.jpg" width="65px"/>
            <h3 class="m-0 font-weight-bold text-center mt-2">Worksheet</h3>
            <p id="tanggal" class="fs-5 mt-2 mb-0 tanggal text-center"></p>
            <p id="teknisi" class="fs-5 teknisi text-center"></p>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="no">No</th>
                        <th class="name">Nama Pelanggan</th>
                        <th class="lokasi">Lokasi</th>
                        <th class="kontak">Kontak</th>
                        <th class="masalah">Masalah</th>
                        <th class="teknisi">Keterangan</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }} "></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#show').click(function() {
            var date = $('#date').val();
            var technician = $('#technician').val();

            console.log(technician);
            
            $('#teknisi').text($('#technician option:selected').text())
            
            $('#tanggal').text(getWeekday(date) + ', ' + tampilTanggal);

            $('#dataTable tbody').empty();

            var table = $('#dataTable').DataTable();
            table
                .clear()
                .draw()
                .destroy()
                
            $('#dataTable').dataTable( {
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "searching": false,
                "paging": false,
                "info": false,
                "destroy": true,
                "ajax": {
                    "url" : "{{ url('worksheets/cetak') }}",
                    "type": "GET",
                    "data": {
                        "date": date,
                        "technician": technician
                    }
                },
                "columns": [
                    { data: "DT_RowIndex", className: "no"},
                    { data: "customer", className: "customer"},
                    { data: "address", className: "address"},
                    { data: "contact", className: "contact"},
                    { data: "problem", className: "problem"},
                    { data: "description", className: "description"},
                    // { data: "", className: ""},
                    // { data: "technician", className: "technician"},
                    // {"mRender": function ( data, type, row ) {
                    //         return '<a href="{{url("schedules")}}/'+row.uuid+'/edit" class="btn btn-primary btn-sm btn-edit">Edit</a>';}
                    // }
                ], 
                "language": {
                    processing: "Mohon tunggu ..."
                }
            });
        })
    });

    getWeekday = s => {
    const [yyyy, mm, dd] = s.split('-'),
            date = new Date(yyyy, mm-1, dd)
    return date.toLocaleDateString('id-ID', {weekday: 'long'})
    }
      
    var
    str = '2022-10-25',
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

    var tampilTanggal = tanggal + " " + bulan + " " + tahun;
</script>

<script>
    $('#print').click(function(){
        var tab = document.getElementById('card');
        var style = "<style>";
        style = style + "table {width: 100%; font: 14px Helvetica; margin-top: 20px}";
        style = style + ".title {text-align:center;}";
        style = style + "h3 {font: 25px Helvetica; font-weight: bold; margin: 10px 0px}";
        style = style + "td.text-center {text-align:center}";
        style = style + "td.text-end {text-align:right}";
        style = style + "td.address {vertical-align:top}";
        style = style + "th.no, td.no {width: 10px !important; text-align: center}";
        style = style + "th.masalah {width: 400px !important}";
        style = style + "th.name {width: 100px !important}";
        style = style + ".tanggal {font: 17px Helvetica; font-weight: bold; margin: 10px 0px}";
        style = style + ".teknisi {font: 17px Helvetica; font-weight: bold; margin: 0px 0px 10px 0px}";
        style = style + "div.box {display:flex; align-items:center; justify-content: center}";
        style = style + "td.text-uppercase {text-transform: uppercase}";
        style = style + "td.fs-2 {font-size: 25px; font-weight:bold; text-transform: uppercase}";
        style = style + "td.fs-3 {font-size: 28px; font-weight:bold; text-transform: uppercase}";
        style = style + "td.fs-4 {font-size: 20px; font-weight:bold; text-transform: uppercase}";
        style = style + "td.fs-5 {font-size: 14px; font-weight:bold; text-transform: uppercase}";
        style = style + "th {font-size: 15px; font-weight:bold; text-align:left}";
        style = style + "table, th, td {border: solid 1px #080808; border-collapse: collapse; padding: 4px 4px;}";
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