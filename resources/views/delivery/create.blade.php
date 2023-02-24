@extends('layouts.app')

@section('header_styles')

<!-- Custom styles for this page -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Surat Jalan Baru</h4>
                </div>
                <form method="post" action="{{ url('/deliveries') }}">
                    @csrf
                    <input type="hidden" name="customer" value="{{ $customer }}" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="required">Tanggal</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name ="date" value="{{ old('date') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="required">Nomor</label>
                                    <input type="text" class="form-control @error('no') is-invalid @enderror" id="no" name ="no" value="{{ $number }}" required>
                                    @error('no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-top border-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="customer_phone" class="required">Detail Keterangan Barang</label>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-md-end">
                                <a class="btn btn-primary add-variant btn-sm" href="#"><i class="fa-regular fa-plus"></i> Tambah Baris</a>
                            </div>
                        </div>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <td width="80px">Jumlah</td>
                                    <td width="100px">Satuan</td>
                                    <td width="200px">Nama Barang</td>
                                    <td>Keterangan</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-row">
                                    <td><input type="number" class="form-control" name ="total[1]" required></td>
                                    <td>
                                        <select class="form-control" name="type[1]">
                                            <option value="unit">Unit</option>         
                                            <option value="pcs">Pcs</option>         
                                            <option value="buah">Buah</option>         
                                            <option value="dus">Dus</option>         
                                            <!-- <option value="unit">Kg</option>          -->
                                        </select>
                                    </td>
                                    <td style="padding-top: 13px"><select class="form-control product" data-id="product-1" name="product[1]"></select></td>
                                    <td><input type="text" class="form-control" name ="description[1]" required></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="form-group">
                            <!-- <a class="btn btn-outline-primary mr-2" href="{{ url('/delivery/') }}">Batal</a> -->
                            <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        selectRefresh();
        
        $(document).on('click', '.add-variant', function(e){
            e.preventDefault();
            $('.variant').show();

            var totalRow = $('.table-row').length;
            var totalRow = totalRow + 1;
            
            var row = `<tr class="table-row" data-id="${totalRow}">` +
                '<td><input type="text" class="form-control" name ="total['+totalRow+']" required></td>' +
                '<td><select class="form-control" name="type['+totalRow+']"><option value="unit">Unit</option><option value="pcs">Pcs</option><option value="buah">Buah</option><option value="dus">Dus</option></select></td>' +
                '<td style="padding-top: 13px"><select class="form-control product" data-id="product-1" name="product['+totalRow+']"></select></td>' +
                '<td><input type="text" class="form-control" name ="description['+totalRow+']" required></td>' +
                '</tr>';
            $('.table').append(row);

            selectRefresh();
        })

        $(document).on('click', '.trash-row', function(e){
            e.preventDefault();
            var id = $(this).data("id");
            $('.table tr[data-id="'+id+'"]').remove();
            var totalRow = $('.table-row').length;
            if(totalRow === 1){
                $('.variant').hide();
            }
        })

        var url = "{{ url('/products/autocomplete') }}";

        $('.product').select2({
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

        function selectRefresh() {
            $('.product').select2({
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
        }
    })
</script>
@endpush