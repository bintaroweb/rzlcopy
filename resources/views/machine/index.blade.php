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
        <h1 class="h3 mb-3 text-gray-800" id="title">Daftar Mesin Fotocopy <strong>{{ $customer->customer_name }}</strong></h1>
    </div>
    <div class="col-md-4 d-md-flex justify-content-md-end">
        <!-- <a href="#" id="import" class="btn btn-primary btn-md mb-3 mx-2"><i class="fa-solid fa-file-import"></i> Import</a> -->
        <a href="{{ url('/machines/create/?id=') }}{{$customer->uuid}}" class="btn btn-primary btn-md mb-3"><i class="fas fa-plus"></i> Tambah</a>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-2">
        <!-- Pilih Mesin -->
        <label>Pilih Mesin :</label>
        <select name="machine" id="machine" class="form-select mt-1">
            <option value="">Semua</option>
            @foreach ($machines as $machine)
                <option value="{{ $machine->id }}">{{ $machine->name }}</option>
            @endforeach
        </select>
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
                        <th>Tanggal Instal</th>
                        <th>Mesin</th>
                        <th>Status</th>
                        <th>Description</th>
                        <!-- <th>Counter</th> -->
                        <!-- <th>Teknisi</th> -->
                        <th style="width: 130px"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modal-import" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import CSV Machine Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="import-form" method="post" action="{{ url('/records/import') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="customer" value="{{ $customer->id }}" /> 
        
        <div class="form-group">
            <label>Pilih Mesin</label>
            <select name="machine" id="machine" class="form-select mt-1">
                @foreach ($machines as $machine)
                    <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name" class="required">Pilih File CSV</label>
            <input type="file" class="form-control-file form-control @error('upload') is-invalid @enderror" id="upload" name ="upload" required>
            <!-- <small class="form-text text-muted">Bisa input nama usaha/perusahaan jika memang tidak diketahui Contact Personnya</small> -->
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="confirm-import">Import</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }} "></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        $('#import').click(function(e){
           e.preventDefault();
           $('#modal-import').modal('show');
        })

        $('#confirm-import').click(function(){
            // document.getElementById('logout-form').submit();
            $('#import-form').submit();
        })
    })
</script>

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
            ajax: "{{ url('machines/datatable/?id=') }}" + getUrlParameter('id'),
            lengthMenu: [25, 50, 100],
            columns: [
                { data: "date", className: "date"},
                { data: "machine", className: "machine"},
                { data: "status", className: "status"},
                { data: "description", className: "description"},
                // { data: "counter", className: "counter"},
                // { data: "technician", className: "technician"},
                {"mRender": function ( data, type, row ) {
                        return ' <div class="d-md-flex justify-content-md-end"><a href="{{url("machines")}}/'+row.uuid+'/edit" class="btn btn-primary btn-sm btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a></div>';}
                }
            ], 
            language: {
                processing: "Mohon tunggu ..."
            }
        });

        $('#machine').change(function() {
            var machine = $(this).val();
            var technician = $('#technician').val();

            $('#dataTable tbody').empty();

            var table = $('#dataTable').DataTable();
            table
                .clear()
                .draw()
                .destroy()
                
                $('#dataTable').DataTable( {
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: "{{ url('records/datatable/?id=') }}" + getUrlParameter('id') + "&machine=" + machine,
                    lengthMenu: [25, 50, 100],
                    columns: [
                        { data: "date", className: "date"},
                        { data: "machine", className: "machine"},
                        { data: "problem", className: "no"},
                        { data: "description", className: "description"},
                        { data: "counter", className: "counter"},
                        { data: "technician", className: "technician"},
                        {"mRender": function ( data, type, row ) {
                                return ' <div class="d-md-flex justify-content-md-end"><a href="{{url("records")}}/'+row.uuid+'/edit" class="btn btn-primary btn-sm btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a></div>';}
                        }
                    ], 
                    language: {
                        processing: "Mohon tunggu ..."
                    }
                });
        })
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