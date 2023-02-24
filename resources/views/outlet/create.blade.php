@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Outlet Baru</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/outlets') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="required">Nama Outlet</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name ="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="required">Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name ="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="province" class="required">Provinsi</label>
                            <select class="form-control @error('province') is-invalid @enderror" name="province" id="province" required>
                                <option value="">-- Pilih Provinsi--</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
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
                            </select>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="district" class="required">Kecamatan</label>
                            <select class="form-control @error('district') is-invalid @enderror" name="district" id="district" required>
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="required">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" required>{{ old('address') }}</textarea>
                            @error('address')
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

@endpush