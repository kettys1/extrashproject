@extends('backend.layout')
@section('page')
<div class="row">
    <div class="col-sm-12 form-group">
        <button type="button" class="btn btn-success" onclick="resetIdKeuangan()" data-toggle="modal" data-target="#pengambilan-modal" class="btn btn-sm btn-success">Tambah Data</button>
        <hr>
    </div>
    <div class="col-sm-8 form-group">
        <div class="table-responsive">
            <table class="table table-striped table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="{{ route('kategori-barang.store') }}" method="post" id="form-input">
    @csrf
    <div class="modal fade" id="pengambilan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kategori Barang</h5> 
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label>Nama Kategori</label>
                    <input style=" height: 28px; " type="text" class="form-control form-control-sm nama_kategori" name="nama_kategori_barang" placeholder="Kategori Barang">
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
            modal.find('.nama_kategori').val(data.nama_kategori_barang);
            modal.find('.id_kategori').val(data.id_kategori_barang);
            modal.modal("show")
            $('#form-input').append(`<input name="id_kategori_barang" class="id_kategori_barang" type="hidden" value="${data.id_kategori_barang}" />`);
        })
        $(document).on('click','.btn-detail', function(){

        })
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
                    className: 'text-center'
                },
                {
                    data: 'action',
                    className: 'text-center', 
                },
               

            ]
        });
    });

    function resetId(){
        $('.id_kategori_barang').remove();
    }

</script>
@endsection
