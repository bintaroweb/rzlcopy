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
                    <h4 class="card-title">Tambah Pelanggan Baru</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/customers') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="required">Nama Pelanggan/Contact Person <i class="fa-solid fa-circle-info text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Bisa input nama usaha/perusahaan jika Contact Person tidak diketahui"></i></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name ="customer_name" value="{{ old('customer_name') }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_company">Nama Usaha/Perusahaan</label>
                                    <input type="text" class="form-control @error('customer_company') is-invalid @enderror" id="customer_company" name ="customer_company" value="{{ old('customer_company') }}">
                                    @error('customer_company')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="machine" class="mb-1">Tipe Mesin <i class="fa-solid fa-circle-info text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Bisa input lebih dari 1 mesin"></i></label>
                                    <select class="form-control" id="machine" name="machine[]" multiple="multiple" required></select>
                                    @error('machine')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- <div class="form-group">
                                    <label for="customer_status" class="required">Status</label>
                                    <select class="form-control" name="customer_status" required>
                                        @foreach ($status as $data)
                                            <option value="{{ $data->id }}">{{ $data->status }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Tanggal Instal</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name ="date" value="{{ old('customer_company') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_phone" class="required">Telepon</label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name ="customer_phone" value="{{ old('customer_phone') }}" required>
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_email">Email </label>
                                    <input type="text" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name ="customer_email" value="{{ old('customer_email') }}">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer_city" class="required mb-1">Kota/Kabupaten</label>
                            <select class="form-control" id="city" name="customer_city" required></select>
                            <!-- <small id="emailHelp" class="form-text text-muted">Ketik nama Kota/Kabupaten</small> -->
                            @error('customer_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="customer_address">Alamat <i class="fa-solid fa-circle-info text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Bisa input nama wilayah misalnya Bandara, Cikarang, Kebayoran, Bintaro, dll."></i></label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror" name="customer_address" id="customer_address">{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_note">Catatan</label>
                            <textarea class="form-control @error('customer_note') is-invalid @enderror" name="customer_note" id="customer_note">{{ old('customer_note') }}</textarea>
                            @error('customer_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/customers') }}">Batal</a>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

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