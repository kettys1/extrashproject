@extends('backend.layout')
@section('page')
<div class="row">
    <div class="col-sm-12 form-group">
        <button type="button" class="btn btn-success" onclick="resetIdKeuangan()" data-toggle="modal" data-target="#pengambilan-modal" class="btn btn-sm btn-success">Tambah Data</button>
        <hr>
    </div>
    <div class="col-sm-12 form-group">
        <div class="table-responsive">
            <table class="table table-striped table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        <th>BSU</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="{{ route('jadwal.store') }}" method="post" id="form-input">
    @csrf
    <div class="modal fade" id="pengambilan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content"> 
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                        <label style="font-size: 14px;">Tanggal Awal</label>
                        <div class="input-group date nk-int-st">
                            <span class="input-group-addon"></span>
                            <input type="text" class="form-control tanggal-realisasi tgl-awal" name="tanggal_awal"
                                value="<?=  date('d-m-Y') ?>">
                        </div>
                    </div>
                </div> 
                <div class="col-sm-6 form-group">
                    <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                        <label style="font-size: 14px;">Tanggal Akhir</label>
                        <div class="input-group date nk-int-st">
                            <span class="input-group-addon"></span>
                            <input type="text" class="form-control tanggal-realisasi tgl-akhir" name="tanggal_akhir"
                                value="<?=  date('d-m-Y') ?>">
                        </div>
                    </div>
                </div> 
                <div class="col-sm-12 form-group">
                    <label>Bsu</label>
                   <select class="select2 form-control id_bsu" multiple name="id_bsu[]">
                    @foreach($bsu as $k)
                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                    @endforeach
                   </select>
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
    $('.select2').select2({})
    $(document).ready(function () {
        $(document).on('click','.btn-edit', function(){
            var data = table.row($(this).closest('tr')).data();
            console.log(data);
            let tabungan = parseFloat(data.tabungan) + parseFloat(data.amount); 
            modal.find('.tgl-awal').val(moment(data.tanggal_awal).format('DD-MM-YYYY')); 
            modal.find('.tgl-akhir').val(moment(data.tanggal_akhir).format('DD-MM-YYYY')); 
            modal.find('.id_bsu').val(data.bsu_id).trigger('change')
            $('#form-input').append(`<input name="id_jadwal" class="id_jadwal" type="hidden" value="${data.id}" />`);
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
                    data: 'tanggal',
                    className: 'text-center',
                    render : function(meta,data,row){
                        return moment(row.tanggal_awal).format('DD-MM-YYYY')
                    }
                }, 
                {
                    data: 'tanggal',
                    className: 'text-center',
                    render : function(meta,data,row){
                        return moment(row.tanggal_akhir).format('DD-MM-YYYY')
                    }
                }, 
                {
                    data: 'alamat',
                    className: 'text-left',
                    render : function(meta,data,row){
                        var bsu = row.bsu;
                        var t = '';
                        for (let index = 0; index < bsu.length; index++) {
                            const element = bsu[index];
                            t += element.name + '<br>'
                            
                        }
                        return t
                    }
                },
                {
                    data: 'action',
                    className: 'text-center', 
                },
               

            ]
        });
    });

    function resetIdKeuangan(){
        $('.id_jadwal').remove();
        $('.tanggal-realisasi').val(moment().format('DD-MM-YYYY')); 
    }

</script>
@endsection
