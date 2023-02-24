@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tambah Teknisi</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/technicians') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="required">Nama Teknisi</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name ="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="contact" class="required">Kontak</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name ="contact" value="{{ old('contact') }}" onkeypress="return onlyNumberKey(event)" required>
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/technicians') }}">Batal</a>
                            <button class="btn btn-primary ms-2" id="simpan">Simpan</button>
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
    function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if(ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)){
            return false;
        }
        return true;
    }
</script>
@endpush