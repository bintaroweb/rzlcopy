<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>
<body>

<!-- Data Pelanggan -->
<div class="card mb-4" id="card">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-2"><img class="mx-auto d-block" src="https://i.ibb.co/tCtZcpb/rs.jpg" width="100px"/></div>
            <div class="col-md-5">
                <h3 class="m-0 font-weight-bold">CV Restu Jaya Sentosa</h3>
                <p>Jl. Bangka Blok DII No 3 Vila Bintaro Indah   <br/>
                    Ciputat, Tangerang Selatan 15153  <br/>
                    Telp. (021) 74861939 / (021) 7457959 
                </p>
            </div>
            <div class="col-md-5">
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
        <div class="row">
            <div class="col-md-6">
                Tanda Terima <br> <br> <br>
                ( ........................... )
            </div>
            <div class="col-md-6">
                Hormat Kami <br> <br> <br>
                ( Sartini ) 
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-5.2.0/js/bootstrap.bundle.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var date = $('#date').val();        
        $('#tanggal').text(tampilTanggal(date));

        window.print();
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

</body>
</html>
