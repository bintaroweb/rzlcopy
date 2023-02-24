@extends('layouts.app')

@section('header_styles')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-md-10">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800">Pelanggan</h1>
    </div>
    <div class="col-md-2 d-md-flex justify-content-md-end">
        <a href="{{ url('/customers') }}" class="btn btn-secondary btn-md mb-3"><i class="fa-solid fa-arrow-left"></i> Kembeli</a>
        <a href="{{ url('/customers/create') }}" class="btn btn-primary btn-md mb-3"><i class="fas fa-plus"></i> Tambah</a>
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
                        <th>Nama Pelanggan</th>
                        <th>Nama Usaha/Perusahaan</th>
                        <!-- <th>Alamat</th> -->
                        <th>Kota/Kab</th>
                        <th>Telpon</th>
                        <th>Status</th>
                        <th></th>
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
        console.log('Button Delete');
        $('#dataTable').DataTable( {
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "{{ url('customers/datatable') }}",
            columns: [
                // {"mRender": function ( data, type, row ) {
                //         return '<a href="#">'+row.customer_name+'</a>';}
                // }
                { data: "customer_name", className: "customer_name"},
                { data: "customer_company", className: "customer_company"},
                // { data: "customer_address", className: "customer_address"},
                { data: "customer_city", className: "customer_city"},
                { data: "customer_phone", className: "customer_phone"},
                { data: "customer_status", className: "customer_status"},
                {"mRender": function ( data, type, row ) {
                        return '<div class="d-md-flex justify-content-md-end"><a href="{{url("customers")}}/'+row.uuid+'" class="btn btn-success btn-sm btn-edit me-2"><i class="fa-solid fa-eye"></i> Detail</a> <a href="{{url("customers")}}/'+row.uuid+'/edit" class="btn btn-primary btn-sm btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a></div>';}
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
    });
    
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