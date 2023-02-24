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
                    <form method="post" action="{{ url('/customers/'. $customer->uuid . '') }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="required">Nama Pelanggan</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name ="customer_name" value="{{ $customer->customer_name }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="customer_company">Nama Usaha/Perusahaan</label>
                                    <input type="text" class="form-control @error('customer_company') is-invalid @enderror" id="customer_company" name ="customer_company" value="{{ $customer->customer_company }}">
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
                                    @if(count($machines) > 0 )
                                        <select class="form-control" id="machine" name="machine[]" multiple="multiple" required>
                                            @foreach ($machines as $machine)
                                                <option value="{{ $machine->id }}" selected>{{ $machine->name}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('machine')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- <div class="form-group">
                                    <label for="customer_city" class="required">Status</label>
                                    <select class="form-control" name="customer_status">
                                        
                                    </select>
                                    @error('customer_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Tanggal Instal</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name ="date" value="{{ $customer->date }}">
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
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name ="customer_phone" value="{{ $customer->customer_phone }}" required>
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_email">Email </label>
                                    <input type="text" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name ="customer_email" value="{{ $customer->customer_email }}">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>                 
                        
                        <div class="form-group">
                            <label for="customer_address">Alamat</label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror" name="customer_address" id="customer_address">{{ $customer->customer_address }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_city" class="required">Kota/Kabupaten</label>
                            <select class="form-control" id="search" name="customer_city">
                                <option value="{{ $customer->city_id }}" selected="selected">{{ $customer->city }}</option>
                            </select>
                            @error('customer_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_note">Catatan</label>
                            <textarea class="form-control @error('customer_note') is-invalid @enderror" name="customer_note" id="customer_note">{{ $customer->customer_note }}</textarea>
                            @error('customer_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a class="btn btn-outline-primary mr-2" href="{{ url('/customers') }}">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Update</button>
                        </div>
                    </form>
                    <div class="col text-center">
                        <a class="btn-link" id="delete" href="#">
                            {{ __('Hapus Pelanggan') }}
                        </a>
                    </div>
                    <form id="delete-form" action="{{ route('customers.destroy', $customer->uuid) }}" method="POST" class="d-none">
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
        <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Anda yakin akan menghapus pelanggan <strong>{{ $customer->customer_name }}</strong>?
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
    var path = "{{ url('/customers/autocomplete') }}";
  
    $('#search').select2({
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
