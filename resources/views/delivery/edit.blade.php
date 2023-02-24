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
                    <h4 class="card-title">Edit Pelanggan</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/schedules/'. $schedule->uuid . '') }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="address" class="required">Tanggal</label>
                            <input name="date" type="date" class="form-control" id="date" value="{{ $schedule->date }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer" class="required">Pilih Pelanggan</label>
                            <select class="form-control" id="search" name="customer" value="{{ $schedule->id }}" required>
                                <option value="{{ $schedule->customer_id }}" selected>{{ $customer->customer_name }}</option>
                            </select>
                            @error('customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="required">Alamat/Lokasi</label>
                            <input name="address" class="form-control" id="address" value="{{ $schedule->address }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="contact" class="required">Kontak</label>
                            <input name="contact" class="form-control" id="contact" value="{{ $schedule->contact }}" required>
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="technician">Pilih Teknisi</label>
                                <select class="form-control" id="search" name="technician">
                                    <option>Pilih Teknisi</option>
                                    @foreach ($technicians as $technician)
                                        <option value="{{ $technician->id }}" {{ $schedule->technician_id == $technician->id  ? 'selected' : ''}}>{{ $technician->name }}</option>
                                    @endforeach
                                </select>
                            
                            @error('customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="problem" class="required">Masalah</label>
                            <textarea class="form-control @error('problem') is-invalid @enderror" name="problem" id="problem">{{ $schedule->problem }}</textarea>
                            @error('problem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/schedules') }}">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Update</button>
                        </div>
                    </form>
                    <div class="col text-center">
                        <a class="btn-link" id="delete" href="#">
                            {{ __('Hapus Jadwal') }}
                        </a>
                    </div>
                    <form id="delete-form" action="{{ route('schedules.destroy', $schedule->uuid) }}" method="POST" class="d-none">
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
        <h5 class="modal-title" id="exampleModalLabel">Hapus Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Anda yakin akan menghapus jadwal ini?
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
    var path = "{{ url('/schedules/autocomplete') }}";
  
    $('#search').select2({
        theme: 'bootstrap-5',
        placeholder: 'Ketik Nama Pelanggan',
        ajax: {
          url: path,
          dataType: 'json',
          delay: 50,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.customer_name,
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
  
</script>
@endpush
