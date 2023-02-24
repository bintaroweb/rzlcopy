@extends('layouts.app')

@section('header_styles')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800" id="title">Invoice <strong>{{ $customer->customer_name }}</strong></h1>
    </div>
    <div class="col-md-4 d-md-flex justify-content-md-end">
        <a href="{{ url('/invoices/create/?id=') }}{{$customer->id}}" class="btn btn-primary btn-md mb-3"><i class="fas fa-plus"></i> Tambah</a>
    </div>
</div>


<!-- Data Pelanggan -->
<div class="card shadow mb-4">
    <!-- <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
    </div> -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 100px">Tanggal</th>
                        <th>No</th>
                        <!-- <th>Jumlah</th> -->
                        <!-- <th>Nama Barang</th> -->
                        <th style="width: 130px"></th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // dataTables plugin
    $(document).ready(function() {

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };
        
        $('#dataTable').DataTable( {
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "{{ url('invoices/datatable/?id=') }}" + getUrlParameter('id'),
            columns: [
                // {"mRender": function ( data, type, row ) {
                //         return '<a href="#">'+row.customer_name+'</a>';}
                // }
                { data: "date", className: "date"},
                { data: "no", className: "no"},
                // { data: "description", className: "description"},
                // { data: "product", className: "product"},
                {"mRender": function ( data, type, row ) {
                        return ' <div class="d-md-flex justify-content-md-end"><a href="{{url("deliveries")}}/'+row.uuid+'" class="btn btn-secondary btn-sm btn-edit"><i class="fa-solid fa-eye"></i> Detail</a></div>';}
                }
                // {
                //     data: 'action', 
                //     name: 'action',  
                //     orderable: false, 
                //     searchable: true,
                //     attr:  {
                //         title: 'Copy',
                //         id: 'copyButton'
                //     }
                // },
            ], 
            language: {
                processing: "Mohon tunggu ..."
            }
        });
    })
    
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