@extends('layouts.app')

@section('header_styles')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-md-10">
        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800">Outlet</h1>
    </div>
    <div class="col-md-2 d-md-flex justify-content-md-end">
        <a href="{{ url('/outlets/create') }}" class="btn btn-primary mb-3" id="tambah">Tambah</a>
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
                        <th>Nama Outlet</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
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
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable( {
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "{{ url('outlets/datatable') }}",
            columns: [
                { data: "name", className: "name"},
                { data: "address", className: "address"},
                { data: "phone", className: "phone"},
                {"mRender": function ( data, type, row ) {
                        return '<a href="{{url("outlets")}}/'+row.uuid+'/edit" class="btn btn-primary btn-sm btn-edit">Edit</a>';}
                }
            ], 
        });
    });
</script>

<script>
introJs().setOptions({
  steps: [{
    intro: "Ini adalah halaman untuk mengelola outlet anda"
  }, {
    element: document.querySelector('#tambah'),
    intro: "Klik disini untuk menambahkan outlet baru"
  }]
}).start();    
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