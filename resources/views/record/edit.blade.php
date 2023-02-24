@extends('layouts.app')

@section('header_styles')

<!-- Custom styles for this page -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Machine Record</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/records/'. $record->uuid . '') }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="customer" value="{{ $customer }}" />
                        <div class="form-group">
                            <label for="date" class="required">Tanggal</label>
                            <input name="date" type="date" class="form-control" id="date" value="{{ $record->date }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="problem">Problem</label>
                            <input name="problem" class="form-control" id="problem" value="{{ $record->problem }}">
                            @error('problem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="required">Replace / Adjustment/Comment/Attantion</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ $record->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="counter" class="required">Counter</label>
                            <input name="counter" class="form-control" id="counter" value="{{ $record->counter }}" required>
                            @error('counter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="technician" class="required" class="mb-1">Pilih Teknisi</label>
                            <select class="form-control" id="technician" name="technician" required>
                                <option value="{{ $technician->id }}" selected="selected">{{ $technician->name }}</option>
                            </select>
                            @error('technician')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/record/?id=') }}{{ $record->uuid }}">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Update</button>
                        </div>
                    </form>
                    <div class="col text-center">
                        <a class="btn-link" id="delete" href="#">
                            {{ __('Hapus Machine Record') }}
                        </a>
                    </div>
                    <form id="delete-form" action="{{ route('records.destroy', $record->uuid) }}" method="POST" class="d-none">
                        @method('delete')    
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modal-delete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Machine Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Anda yakin akan menghapus machine record ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#delete').click(function(e){
           e.preventDefault();
           $('#modal-delete').modal('show');
        })

        $('#confirm-delete').click(function(){
            // document.getElementById('logout-form').submit();
            $('#delete-form').submit();
        })
    })
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    var path = "{{ url('/records/autocomplete') }}";
  
    $('#technician').select2({
        theme: 'bootstrap-5',
        placeholder: 'Ketik Nama Teknisi',
        ajax: {
          url: path,
          dataType: 'json',
          delay: 50,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      }).on('select2:select', function (e) {
        var data = e.params.data;
        $.ajax({
            type: 'GET', // Metode pengiriman data menggunakan POST
            url: "{{ url('/schedules/address') }}", // File yang akan memproses data
            data: {
                customer: data.id, // Data yang akan dikirim ke file pemroses
                _token: '{{csrf_token()}}'
            },
            beforeSend: function(){
                $( "#address" ).prop( "disabled", true );
                $( "#contact" ).prop( "disabled", true );
            },
            success: function(result) { // Jika berhasil
                $('#address').val(result.customer_address);
                $('#contact').val(result.customer_phone);
                $( "#address" ).prop( "disabled", false );
                $( "#contact" ).prop( "disabled", false );
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $( "#address" ).prop( "disabled", false );
                $( "#contact" ).prop( "disabled", false );
            }
        })
      });

    var url = "{{ url('/products/autocomplete') }}";
  
    $('#product').select2({
        theme: 'bootstrap-5',
        placeholder: 'Ketik Nama Produk',
        ajax: {
          url: url,
          dataType: 'json',
          delay: 50,
          processResults: function (data) {
            console.log(data);
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      })
  
</script>
@endpush