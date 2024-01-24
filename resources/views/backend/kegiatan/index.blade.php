@extends('backend.layout')
@section('page')
<div class="row">
    <div class="col-sm-12 form-group">
        <button type="button" class="btn btn-success is_admin" onclick="resetId()" data-toggle="modal" data-target="#pengambilan-modal" class="btn btn-sm btn-success">Tambah Data</button>
        <hr>
    </div>
    <div class="col-sm-12 form-group">
        <div class="table-responsive">
            <table class="table table-striped table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Foto</th>
                        <th>Keterangan</th> 
                        <th class="is_admin">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="{{ route('kegiatan-bsi.store') }}"  id="form-input"  method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="pengambilan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label style="font-size: 14px;">Foto Kegiatan</label>
                    <input type="file" class="input-file" name="foto" placeholder="Nama Barang">
                </div>
                <div class="col-sm-12 form-group">
                    <label style="font-size: 14px;">Judul</label>
                    <input type="text" class="form-control form-control-sm judul" name="judul" placeholder="Judul Kegiatan">
                </div>
                <div class="col-sm-12 form-group form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="txt" width="100%" cols="3"></textarea>
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
            $("textarea#txt").val(data.keterangan);
            $('.judul').val(data.judul)
            $(".input-file").fileinput({ 
			showRemove: false,
			showUpload: false, 
			initialPreviewAsData: true,
			initialPreview: "{{ asset('kegiatan') }}" + '/' + data.foto
		});
            $('#form-input').append(`<input name="id_kegiatan" class="id_barang" type="hidden" value="${data.id}" />`);
            modal.modal("show")
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
                    data: 'judul',
                    className: 'text-left',
                },
                {
                    data: 'foto',
                    className: 'text-left',
                    render : function(meta,data,row){
                        return `<img src="<?= asset('kegiatan') ?>/${row.foto}" />`
                    }
                },
                {
                    data: 'keterangan',
                    className: 'text-left',
                },
                 
                {
                    data: 'action',
                    className: 'text-center is_admin', 
                },
               

            ]
        });
    });

    function resetId(){
        $('.id_kegiatan').remove();
        $(".input-file").fileinput({'showUpload':false, 'previewFileType':'any'});
    }

</script>
@endsection
