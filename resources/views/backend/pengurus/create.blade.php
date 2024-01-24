@extends('backend.layout')
@section('page')

<div class="row">
    <form action="{{ route('timbangan-harian.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if(isset($data))
            <input type="hidden" value="{{ $data->id_transaksi }}" name="id_transaksi" />
        @endif
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group">
            <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                <label>Tanggal Transaksi</label>
                <div class="input-group date nk-int-st">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name="tanggal_transaksi"
                        value="<?= !empty($data->tanggal_transaksi) ? date('d-m-Y', strtotime($data->tanggal_transaksi)) : date('d-m-Y') ?>">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-1 form-group2">
            <div class="nk-int-mk sl-dp-mn">
                <h2>Nasabah</h2>
            </div>
            <div class="bootstrap-select fm-cmp-mg">
                <select class="selectpicker" name="id_nasabah">
                    @if(!empty($data->id_user))
                    <option value="{{ $data->id_user }}" selected>{{ $data->nama_user }}</option>
                    @else
                    <option value="" disabled selected>Pilih Nasabah</option>
                    @endif
                    @foreach($user as $us)
                    <option value="{{ $us->id_user }}">{{ $us->nama_user }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-12 form-group">
            <table class="table table-sm table-data">
                <thead class="thead-dark" style=" background: cadetblue; ">
                    <tr>
                        <th class="text-center" scope="col">No</th>
                        <th class="text-center" scope="col">Barang</th>
                        <th class="text-center" scope="col">Harga</th>
                        <th class="text-center" scope="col">Qty</th>
                        <th class="text-center" scope="col">Sub Total</th>
                        <th class="text-center" scope="col"><button class="btn btn-sm btn-secondary add-row"
                                type="button"><i class="fa-solid fa-plus"></i></button></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($detail))
                    @foreach($detail as $key => $value)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td><select name="id_barang[]" class="itemName form-control form-control-sm">
                                <option value="{{ $value->id_barang }}">{{ $value->nama_barang }}</option>
                            </select></td>
                        <td class="text-center">
                            <input name="harga[]" value="{{ removeDecimal($value->harga) }}" style=" height: 28px; " type="text"
                                class="form-control form-control-sm value-barang curency harga-barang text-right"
                                placeholder="Harga barang">
                        </td>
                        <td class="text-center">
                            <input name="quantity[]" value="{{ removeDecimal($value->quantity) }}" style=" height: 28px; " type="text"
                                class="form-control form-control-sm value-barang curency qty-barang text-right"
                                placeholder="Quantity">
                        </td>
                        <td class="text-center">
                            <input style=" height: 28px; " readonly type="text"
                                class="form-control form-control-sm curency subtotal text-right" placeholder="Subtotal">
                        </td>
                        <td class="text-center"><button class="btn btn-sm btn-danger btn-remove" type="button"><i
                                    class="fa-solid fa-trash"></i></button></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-center">Total</th>
                        <th class="text-center"> <input style=" height: 28px; " type="text"
                                class="form-control form-control-sm curency grand-total text-right" readonly
                                placeholder="Grand Total"></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="col-sm-12 form-group">
            <a href="{{ route('timbangan-harian.index') }}" class="btn btn-sm btn-danger">Kembali</a>
            <button type="submit" class="btn btn-success notika-btn-success waves-effect btn-sm"> Simpan Data</button>
        </div>

    </form>


</div>

@endsection
@section('js')
<script>
    let tableData = $('.table-data');
    $(document).on('click', '.add-row', function () {
        let template = `<tr>
                            <td class="text-center"></td>
                            <td><select name="id_barang[]" class="itemName form-control form-control-sm"></select></td>
                            <td class="text-center">
                                <input name="harga[]" style=" height: 28px; " type="text" class="form-control form-control-sm value-barang curency harga-barang text-right"  placeholder="Harga barang">
                            </td>
                            <td class="text-center">
                                <input name="quantity[]" style=" height: 28px; " type="text" class="form-control form-control-sm value-barang curency qty-barang text-right"  placeholder="Quantity">
                            </td>
                            <td class="text-center">
                                <input style=" height: 28px; " readonly type="text" class="form-control form-control-sm curency subtotal text-right"  placeholder="Subtotal">
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-danger btn-remove" type="button"><i class="fa-solid fa-trash"></i></button></td>
                        </tr>`
        tableData.find('tbody').append(template);

        $('.itemName').select2({
            placeholder: 'Select an item',
            ajax: {
                url: "{{ route('barangSelect2') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            item.text = item.nama_barang;
                            item.id = item.id_barang;
                            return item;
                        })
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;


            $(this).closest('tr').find('.harga-barang').val(data.harga).trigger('keyup');
            // formatCurrency($(this).find('.harga-barang'))
        });

        inputUang();
        nuberTable();
    });

    $(document).ready(function () {
        $(document).on('change', '.value-barang', function () {
            calculateSubtotal();
        });

        if (tableData.find('tbody').find('tr').length == 0) $('.add-row').click();

        $(document).on('click', '.btn-remove', function () {
            $(this).closest('tr').remove();
            calculateSubtotal();
            nuberTable();
        })
    })

    @if(!empty($data))
    tableData.find('tbody').find('tr').each(function () {
        $('.itemName').select2({
            placeholder: 'Select an item',
            ajax: {
                url: "{{ route('barangSelect2') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            item.text = item.nama_barang;
                            item.id = item.id_barang;
                            return item;
                        })
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;


            $(this).closest('tr').find('.harga-barang').val(data.harga).trigger('keyup');
            // formatCurrency($(this).find('.harga-barang'))
        });
        inputUang();
        calculateSubtotal();
        $(this).find('.curency').trigger('keyup')
    })
    @endif

    function calculateSubtotal() {
        let total = 0;
        tableData.find('tbody').find('tr').each(function () {
            let harga = $(this).find('.harga-barang').val().replace(/,/g, "");
            let qty = $(this).find('.qty-barang').val().replace(/,/g, "");
            $(this).find('.subtotal').val(parseFloat(harga * qty)).trigger('keyup');
            total += parseFloat(harga * qty);
        });

        $('.grand-total').val(total).trigger('keyup');
    }

    function nuberTable() {
        let i = 1;
        tableData.find('tbody').find('tr').each(function () {
            $(this).find('td:first-child').text(i);
            i++;
        })
    }

</script>
@endsection
