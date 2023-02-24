@extends('layouts.app')

@section('header_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Informasi Bisnis</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/settings/company/update') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="required">Nama Bisnis</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name ="name" value="{{ $company->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category" class="required">Kategori Bisnis</label>
                            <select class="form-control @error('category') is-invalid @enderror" name="category" required>
                                <option value="">-- Pilih --</option>
                                <option value="1" {{ $company->category == 1  ? 'selected' : ''}}>Jasa</option>
                                <option value="2" {{ $company->category == 2  ? 'selected' : ''}}>Retail</option>
                                <option value="3" {{ $company->category == 3  ? 'selected' : ''}}>Makanan & Minuman</option>
                                <option value="4" {{ $company->category == 4  ? 'selected' : ''}}>Bengkel</option>
                                <option value="5" {{ $company->category == 5  ? 'selected' : ''}}>Salon</option>
                                <option value="6" {{ $company->category == 6  ? 'selected' : ''}}>Fashion</option>
                                <option value="7" {{ $company->category == 7  ? 'selected' : ''}}>Laundry</option>
                                <option value="8" {{ $company->category == 8  ? 'selected' : ''}}>Lainnya</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="province" class="required">Provinsi</label>
                            <select class="form-control @error('province') is-invalid @enderror" name="province" id="province" required>
                                <option value="">-- Pilih Provinsi--</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ $company->province_id == $province->id  ? 'selected' : ''}}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="city" class="required">Kota</label>
                            <select class="form-control @error('city') is-invalid @enderror" name="city" id="city" required>
                                <option value="">-- Pilih Kota --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ $company->city_id == $regency->id  ? 'selected' : ''}}>{{ $regency->name }}</option>
                                @endforeach
                            </select>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="district" class="required">Kecamatan</label>
                            <select class="form-control @error('district') is-invalid @enderror" name="district" id="district" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ $company->district_id == $district->id  ? 'selected' : ''}}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="required">Alamat</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ $company->address }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Kode Pos</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name ="postal_code" value="{{ $company->postal_code }}">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="required">Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name ="phone" value="{{ $company->phone }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name ="website" value="{{ $company->website }}">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/settings') }}">Kembali</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    $('#province').change(function() { // Jika Select Box id provinsi dipilih
        var provinsi = $(this).val(); // Ciptakan variabel provinsi
        $("#city").prop( "disabled", true );
        $.ajax({
            type: 'POST', // Metode pengiriman data menggunakan POST
            url: "{{ url('/settings/company/city') }}", // File yang akan memproses data
            data: {
                prov_id: provinsi, // Data yang akan dikirim ke file pemroses
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) { // Jika berhasil
                $("#city").prop( "disabled", false );
                $('#city').html('<option value="">-- Pilih Kota --</option>');
                $.each(result.cities, function (key, value) {
                    $("#city").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });

    $('#city').change(function() { // Jika Select Box id provinsi dipilih
        $("#district").prop( "disabled", true );
        var kota = $(this).val(); // Ciptakan variabel provinsi
        $.ajax({
            type: 'POST', // Metode pengiriman data menggunakan POST
            url: "{{ url('/settings/company/district') }}", // File yang akan memproses data
            data: {
                city_id: kota, // Data yang akan dikirim ke file pemroses
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) { // Jika berhasil
                $("#district").prop( "disabled", false );
                $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
                $.each(result.districts, function (key, value) {
                    $("#district").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
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

