@extends('backend.layout')
@section('page')
<div class="row">
    @if(Auth::user()->id_role == 1 || Auth::user()->id_role == 10)
    <div class="col-sm-12 form-group">
        <button type="button" class="btn btn-success" onclick="resetIdKeuangan()" data-toggle="modal" data-target="#pengambilan-modal" class="btn btn-sm btn-success">Tambah Data</button>
        <hr>
    </div>
    @endif
    <div class="col-sm-12 form-group">
        <div class="table-responsive">
            <table class="table table-striped table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width: 250px;">Unit</th> 
                        <th class="is_admin">Role</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="{{ route('store_user') }}" method="post" id="form-input">
    @csrf
    <div class="modal fade" id="pengambilan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content"> 
          <div class="modal-body">
            <div class="row"> 
                <div class="col-sm-12 form-group">
                    <label>Nama User</label>
                    <input type="text" class="form-control form-control-sm nama-user input-value" required name="name" />
                </div>
                <div class="col-sm-12 form-group">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-sm email-user input-value" required name="email" />
                </div>
                <div class="col-sm-12 form-group is_admin">
                    <label>Role</label>
                    <select class="select2 id_role input-value" name="id_role">
                        <option value="" disabled selected>Pilih Role</option>
                        @foreach($role as $k)
                        <option value="{{ $k->id_role }}">{{ $k->nama_role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 form-group">
                    <label>Password</label>
                    <input type="password" class="form-control form-control-sm password input-value" name="password" />
                </div>
                <div class="col-sm-12 form-group">
                    <label>Alamat</label>
                   <textarea class="form-control input-value" id="alamat" style="width: 100%;" name="alamat"></textarea>
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
        $('.select2').select2({})
        $(document).on('click','.btn-edit', function(){
            var data = table.row($(this).closest('tr')).data();
            let tabungan = parseFloat(data.tabungan) + parseFloat(data.amount); 
            modal.find('.nama-user').val(data.name);
            modal.find('.email-user').val(data.email);
            modal.find('.id_role').val(data.id_role).trigger('change');
            document.getElementById('alamat').textContent= data.alamat;
            $('#form-input').append(`<input name="id_user" class="id_user" type="hidden" value="${data.id}" />`);
            modal.modal("show")
        }) 
          
        let table = $('.table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("users") }}',
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
                    data: 'name',
                    className: 'text-left', 
                }, 
                {
                    data: 'email',
                    className: 'text-left', 
                }, 
                {
                    data: 'alamat',
                    className: 'text-left',
                    render : function(meta,data,row){
                        return row.nama_bsu
                    }
                },
                {
                    data: 'nama_role',
                    className: 'text-center is_admin', 
                }, 
                {
                    data: 'action',
                    className: 'text-center', 
                },
               

            ]
        });
    });

    function resetIdKeuangan(){
        $('.id_user').remove();
        $('.input-value').val('');
        document.getElementById('alamat').textContent= "";
    }

</script>
@endsection
