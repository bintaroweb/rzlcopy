@extends('layouts.app')

@section('header_styles')

<!-- Custom styles for this page -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800">Metode Pembayaran</h1>
    </div>
    <!-- <div class="col-md-2 d-md-flex justify-content-md-end">
        <a href="{{ url('/outlets/create') }}" class="btn btn-primary mb-3" id="tambah">Tambah</a>
    </div> -->
</div>


<!-- Data Pelanggan -->
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        Pilih Outlet
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="outlet" id="outlet">
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 align-self-center d-flex justify-content-end">
        <a href="#" class="btn btn-primary mb-3" id="simpan">Simpan</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!--E-WALLET-->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">E-Wallet</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/ovo.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center">
                        OVO
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ovo">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/gopay.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center">
                        GOPAY
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gopay">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/dana.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        DANA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="dana">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/linkaja.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        LINK AJA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="linkaja">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/shopeepay.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        SHOPEE PAY
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="shopeepay">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center text-center">
                        
                    </div>
                    <div class="col-md-3 align-self-center ">
                        LAINNYA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="ewallet">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!--MESIN EDC-->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">EDC</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/bca.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center">
                        BCA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bca">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/mandiri.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center">
                        MANDIRI
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="mandiri">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/bni.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        BNI
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bni">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/bri.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        BRI
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bri">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/cimb.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        CIMB NIAGA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cimb">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        
                    </div>
                    <div class="col-md-3 align-self-center ">
                        LAINNYA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edc">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!--ONLINE DELIVERY-->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">ONLINE DELIVERY</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/gofood.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-6 align-self-center">
                        GOFOOD
                    </div>
                    <div class="col-md-3 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gofood">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/grabfood.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-6 align-self-center">
                        GRABFOOD
                    </div>
                    <div class="col-md-3 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="grabfood">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/shopeefood.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-6 align-self-center ">
                        SHOPEE FOOD
                    </div>
                    <div class="col-md-3 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="shopeefood">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/traveloka.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-6 align-self-center ">
                        TRAVELOKA EATS
                    </div>
                    <div class="col-md-3 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="traveloka">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        
                    </div>
                    <div class="col-md-6 align-self-center ">
                        LAINNYA
                    </div>
                    <div class="col-md-3 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="onlinedelivery">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!--ECOMMERCE-->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">ECOMMERCE</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/tokopedia.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center">
                        TOKOPEDIA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="tokopedia">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/shoppe.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center">
                        SHOPEE
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="shopee">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/lazada.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        LAZADA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lazada">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        <img src="{{ asset('images/blibli.png') }}" width="100px"/>
                    </div>
                    <div class="col-md-3 align-self-center ">
                        BLIBLI
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="blibli">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 align-self-center">
                        
                    </div>
                    <div class="col-md-3 align-self-center ">
                        LAINNYA
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ecommerce">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!--LAINNYA-->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">LAINNYA</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        TUNAI
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cash">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        BANK TRANSFER
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="banktransfer">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        GOJEK
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gojek">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        GRAB
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="grab">
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-bottom"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        HALODOC
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="halodoc">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="loading d-none">
    <div class="loader"></div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

<script>
    $(document).ready(function() {
        $('#outlet').change(function() { // Jika Select Box id provinsi dipilih
            $('.loading').removeClass('d-none');
            $('.loading').addClass('d-block');
            $('input[type=checkbox]').prop('checked', false); //Clear semua chechbox
            var outlet = $(this).val(); // Ciptakan variabel provinsi
            $.ajax({
                type: 'POST', // Metode pengiriman data menggunakan POST
                url: '{{ url("/payments/show") }}', // File yang akan memproses data
                data: {
                    id: outlet, // Data yang akan dikirim ke file pemroses
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) { // Jika berhasil
                    var payments = result.payment.payment_method;
                    var array = payments.split(",");
                    for(var i = 0; i < array.length; i++){
                        $('#'+array[i]+'').prop('checked', true);
                    }

                    $('.loading').addClass('d-none');
                    $('.loading').removeClass('d-block');
                }
            });
        }).change();

        $('#simpan').click(function(e){
            e.preventDefault();
            var outlet = $('#outlet').val();
            var selected = [];
            $('input:checked').each(function() {
                selected.push($(this).attr('id'));
            });
            $.ajax({
                type: 'PUT', // Metode pengiriman data menggunakan PUT
                url: "{{ url('/payments/update') }}", // File yang akan memproses data
                data: {
                    payments: selected, // Data yang akan dikirim ke file pemroses
                    outlet: outlet, 
                    _token: '{{csrf_token()}}'
                },
                success: function(result) { // Jika berhasil
                    // $('#nama').val('');
                    // $('#modal-edit').modal('hide');
                    // $('#dataTable').DataTable().ajax.reload();;

                    toastr.options = {
                        "closeButton" : true,
                        "positionClass": "toast-bottom-right",
                    }
                    toastr.success(result.success);
                }
            })
        })
    });
</script>

<script>
// introJs().setOptions({
//   steps: [{
//     intro: "Ini adalah halaman untuk mengelola outlet anda"
//   }, {
//     element: document.querySelector('#tambah'),
//     intro: "Klik disini untuk menambahkan outlet baru"
//   }]
// }).start();    
</script>

<script>
  @if(Session::has('success'))
    toastr.options =
    {
        "closeButton" : true,
        "positionClass": "toast-bottom-right",
    }
  	toastr.success("{{ session('success') }}");
  @endif
</script>

@endpush