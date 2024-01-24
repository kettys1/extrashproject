@extends('backend.layout')
@section('page')
<div class="row">
    <div class="col-sm-12 form-group">
        <button type="button" class="btn btn-success is_admin" onclick="resetIdKeuangan()" data-toggle="modal" data-target="#pengambilan-modal" class="btn btn-sm btn-success">Tambah Data</button>
        <hr>
    </div>
    <div class="col-sm-12 form-group">
        <div class="table-responsive">
            <table class="table table-striped table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga</th> 
                        <th class="is_admin">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="{{ route('barang.store') }}" method="post" id="form-input">
    @csrf
    <div class="modal fade" id="pengambilan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Realisasi Tabungan</h5> 
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label style="font-size: 14px;">Nama Barang</label>
                    <input style=" height: 28px; " type="text" class="form-control form-control-sm nama-barang" name="nama_barang" placeholder="Nama Barang">
                </div>
                <div class="col-sm-6 form-group form-group">
                    <label>Kategori Barang</label>
                    <select class="form-control form-control-sm id_kategori_barang" name="id_kategori_barang"></select>
                </div>
                <div class="col-sm-6 form-group">
                    <label>Harga</label>
                    <input name="harga" style=" height: 28px; " type="text" class="form-control form-control-sm value-barang input-mask text-right" data-inputmask="'alias': 'currency', 'prefix': '', 'digits': '0', 'digitsOptional': 'true'" value="0">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button  type="submit" class="btn btn-primary">Simpan Data</button>
          </div>
        </div>
      </div>
    </div>

</form>
@endsection
@section('js')
<script type="text/javascript">
    let modal = $("#pengambilan-modal");
    $(document).ready(function () {
        $(document).on('click','.btn-edit', function(){
            var data = table.row($(this).closest('tr')).data();
            modal.find('.id_kategori_barang').append(`<option value="${data.id_kategori_barang}">${data.nama_kategori_barang}</option>`).trigger('change');
            modal.find('.value-barang').val(data.harga);
            modal.find('.nama-barang').val(data.nama_barang);
            $('#form-input').append(`<input name="id_barang" class="id_barang" type="hidden" value="${data.id_barang}" />`);
            modal.modal("show")
        })
        $(document).on('click','.btn-detail', function(){

        })

        $('.id_kategori_barang').select2({
            placeholder: 'Pilih Kategori',
            ajax: {
                url: "{{ route('select2kategori') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            item.text = item.nama_kategori_barang;
                            item.id = item.id_kategori_barang;
                            return item;
                        })
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
        });
        $(".input-mask").inputmask({
            removeMaskOnSubmit: true
        }).on('focus', function () {
            $(this).select();
        });
        let table = $('.table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [{
                    data: 'id',
                    name: 'id',
                    className: 'text-center',
                    searchable : false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_kategori_barang',
                    className: 'text-left'
                },
                {
                    data: 'nama_barang',
                    className: 'text-left',
                },
                {
                    data: 'harga',
                    className: 'text-right',
                    render : function(meta,data,row){
                        return formatUang(row.harga,0)
                    }
                }, 
                {
                    data: 'action',
                    className: 'text-center is_admin', 
                },
               

            ]
        });
    });

    function resetId(){
        $('.id_barang').remove();
        modal.find('.id_kategori_barang').val(null).trigger('change');
        modal.find('.value-barang').val(0);
    }

</script>
@endsection
