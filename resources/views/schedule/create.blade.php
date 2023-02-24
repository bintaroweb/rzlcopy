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
                    <h4 class="card-title">Tambah Jadwal Baru</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/schedules') }}">
                        @csrf
                        <div class="form-group">
                            <label for="address">Tanggal Kunjungan Teknisi</label>
                            <input name="date" type="date" class="form-control" id="date" value="{{ old('date') }}"required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- <small class="form-text text-muted">Pilih rencana tanggal berapa teknisi akan melakukan kunjungan ke tempat pelanggan</small> -->
                        </div>
                        <div class="form-group">
                            <label for="customer" class="required mb-1">Pilih Pelanggan</label>
                            <select class="form-control" id="search" name="customer" required></select>
                            @error('customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="required">Alamat/Lokasi</label>
                            <input name="address" class="form-control" id="address" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Harap ketik alamat jika di database masih kosong</small>
                        </div>
                        <div class="form-group">
                            <label for="contact" class="required">Kontak</label>
                            <input name="contact" class="form-control" id="contact" required>
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="technician">Pilih Teknisi</label>
                            <select class="form-control" id="search" name="technician">
                                <option value="0"></option>
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                @endforeach
                            </select>
                            @error('customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Kosongkan jika belum tahu</small>
                        </div>
                        <div class="form-group">
                            <label for="problem" class="required">Masalah</label>
                            <textarea class="form-control @error('problem') is-invalid @enderror" name="problem" id="problem">{{ old('problem') }}</textarea>
                            @error('problem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer" class="mb-1">Type Mesin</label>
                            <select class="form-control" id="product" name="product"></select>
                            @error('product')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/schedules') }}">Batal</a>
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