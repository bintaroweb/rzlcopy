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
                    <h4 class="card-title">Edit Produk</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/products/'. $product->uuid . '') }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name" class="required">Nama Produk</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name ="name" value="{{ $product->name }}" required>
                            <!-- <small class="form-text text-muted">Bisa input nama usaha/perusahaan jika memang tidak diketahui Contact Personnya</small> -->
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cogs">Harga Modal</label>
                            <input type="text" class="form-control @error('cogs') is-invalid @enderror" id="cogs" name ="cogs" value="{{ $product->cogs }}">
                            @error('cogs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price" class="required">Harga Jual</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name ="price" value="{{ $product->price }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ $product->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/products') }}">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Update</button>
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
    var path = "{{ url('/customers/autocomplete') }}";
  
    $('#city').select2({
        theme: 'bootstrap-5',
        placeholder: 'Ketik Nama Kota/Kabupaten',
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
      });
  
</script>
@endpush