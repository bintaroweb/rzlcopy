@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Outlet</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/outlets/'. $outlet->uuid . '') }}">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="required">Nama Outlet</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name ="name" value="{{ $outlet->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="required">Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name ="phone" value="{{ $outlet->phone }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="province" class="required">Provinsi</label>
                            <select class="form-control @error('province') is-invalid @enderror" name="province" id="province" required>
                                <option value="">-- Pilih Provinsi--</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ $outlet->province_id == $province->id  ? 'selected' : ''}}>{{ $province->name }}</option>
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
                                    <option value="{{ $city->id }}" {{ $outlet->city_id == $city->id  ? 'selected' : ''}}>{{ $city->name }}</option>
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
                                    <option value="{{ $district->id }}" {{ $outlet->district_id == $district->id  ? 'selected' : ''}}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="required">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" required>{{ $outlet->address }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/outlets') }}">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Update</button>
                        </div>
                    </form>

                    <div class="col text-center">
                        <a class="btn-link" id="delete" href="#">
                            {{ __('Hapus Outlet') }}
                        </a>
                    </div>
                    <form id="delete-form" action="{{ route('outlets.destroy', $outlet->uuid) }}" method="POST" class="d-none">
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
        <h5 class="modal-title" id="exampleModalLabel">Hapus Outlet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Anda yakin akan menghapus outlet ini?
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
    $(document).ready(function() {
        $('#delete').click(function(e){
           e.preventDefault();
           $('#modal-delete').modal('show');
        })

        $('#confirm-delete').click(function(){
            $('#delete-form').submit();
        })
    })
</script>

@endpush