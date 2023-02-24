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
                    <h4 class="card-title">Tambah Mesin Fotocopy</h4>
                    <p class="text-secondary">{{ $customer_name }}</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/machines') }}">
                        <input type="hidden" name="customer" value="{{ $customer_id }}" />
                        @csrf
                        <div class="form-group">
                            <label for="name" class="required">Pilih Produk</label>
                            <select class="form-control" id="machine" name="machine" required></select>
                                @error('machine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="cogs">Tanggal Instal</label>
                            <input type="date" class="form-control @error('cogs') is-invalid @enderror" id="date" name ="date" value="{{ old('date') }}">
                            @error('cogs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="required">Status</label>
                            <select class="form-select" name="status">
                                @foreach ($status as $value)
                                    <option value="{{ $value->id }}">{{ $value->status }}</option>
                                @endforeach
                                <!-- <option name="1">Name</option> -->
                            </select>
                            <!-- <select class="form-control" id="machine" name="machine[]" multiple="multiple" required> -->
                                <!-- @foreach ($status as $value)
                                    <option value="{{ $value->id }}">{{ $value->status }}</option>
                                @endforeach -->
                                <!-- <option name="1">Name</option> -->
                            <!-- </select> -->
                                @error('machine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Catatan</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/machines/?id=') }}{{ $customer_id }}">Batal</a>
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
    var url = "{{ url('/customers/machines') }}";
  
    $('#machine').select2({
        theme: 'bootstrap-5',
        placeholder: 'Ketik Nama Mesin',
        ajax: {
          url: url,
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
    });
  
</script>
@endpush