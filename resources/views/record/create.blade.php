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
                    <h4 class="card-title">Tambah Machine Record Baru</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/records') }}">
                        @csrf
                        <input type="hidden" name="customer" value="{{ $customer }}" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date" class="required">Tanggal</label>
                                    <input name="date" type="date" class="form-control" id="date" value="{{ old('date') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="technician" class="required" class="mb-1">Pilih Mesin</label>
                                    <select name="machine" class="form-select mt-1">
                                        @foreach ($machines as $machine)
                                            <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('technician')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="technician" class="required" class="mb-1">Pilih Teknisi</label>
                                    <select name="technician" class="form-select mt-1">
                                        @foreach ($technicians as $technician)
                                            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- <select class="form-control" id="technician" name="technician" required>
                                    </select> -->
                                    @error('technician')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="counter" class="required">Counter</label>
                                    <input name="counter" class="form-control" id="counter" required>
                                    @error('counter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="problem">Problem</label>
                            <input name="problem" class="form-control" id="problem">
                            @error('problem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="required">Replace / Adjustment/Comment/Attantion</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/records/?id=') }}{{ $customer }}">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
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