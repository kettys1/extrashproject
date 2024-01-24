<?php

use Illuminate\Support\Facades\Auth;
?>
@extends('backend.layout')
@section('page')
<div class="row">
    @if(Auth::user()->id_role == 3)
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
                        <th>Nomor Realisasi</th>
                        <th>Tanggal Realisasi</th>
                        <th>Nasabah</th> 
                        <th>Realisasi</th> 
                        <th>Status Approve</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="{{ route('realisasi-tabungan.store') }}" method="post" id="form-input">
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
                    <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                        <label style="font-size: 14px;">Tanggal Realisasi</label>
                        <div class="input-group date nk-int-st">
                            <span class="input-group-addon"></span>
                            <input type="text" class="form-control tanggal-realisasi" name="tanggal_transaksi"
                                value="<?=  date('d-m-Y') ?>">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 form-group form-group" style="display: <?= Auth::user()->id_role == 3 ? "none" : '' ?>;">
                    <label>Nasabah</label>
                    <select class="form-control form-control-sm id_user" name="id_user"></select>
                </div>
                <div class="col-sm-4 form-group">
                    <label>Tabungan</label>
                    <input style=" height: 28px; " type="text" readonly class="form-control form-control-sm value-barang input-mask tabungan text-right" data-inputmask="'alias': 'currency', 'prefix': '', 'digits': '0', 'digitsOptional': 'true'"  placeholder="Tabungan">
                </div>
                <div class="col-sm-4 form-group">
                    <label>Pengambilan</label>
                    <input name="amount" style=" height: 28px; " type="text" class="form-control form-control-sm value-barang input-mask pengambilan text-right" data-inputmask="'alias': 'currency', 'prefix': '', 'digits': '0', 'digitsOptional': 'true'"  placeholder="Pengambilan">
                </div>
                <div class="col-sm-4 form-group">
                    <label>Sisa</label>
                    <input style=" height: 28px; " type="text" class="form-control form-control-sm value-barang input-mask sisa text-right" data-inputmask="'alias': 'currency', 'prefix': '', 'digits': '0', 'digitsOptional': 'true'" readonly  placeholder="Sisa">
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
            let tabungan = parseFloat(data.tabungan) + parseFloat(data.amount); 
            modal.find('.tanggal-realisasi').val(moment(data.tanggal).format('DD-MM-YYYY'));
            modal.find('.id_user').append(`<option value="${data.id_user}">${data.name} - Tabungan : ${ renderAmount(parseFloat(tabungan),0)}</option>`).trigger('change');
            modal.find('.tabungan').val(parseFloat(tabungan));
            modal.find('.pengambilan').val(data.amount);
            $('.pengambilan').trigger('change');
            $('#form-input').append(`<input name="id_keuangan" class="id_keuangan" type="hidden" value="${data.id_keuangan}" />`);
            modal.find('.pengambilan')
					.attr("data-inputmask", "'alias': 'currency', 'prefix': '', 'digits': '0', 'max': '" + parseFloat(tabungan) + "'")
					.inputmask({
						removeMaskOnSubmit: true
					}).on('focus', function () {
						$(this).select();
					});
            modal.modal("show")
        }) 
        $(document).on('click','.btn-approve', function(){
            var data = table.row($(this).closest('tr')).data();
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: "{{ url('updatePenarikan') }}" + '/' + data.id_keuangan,
                dataType: 'json',
                data : {
                    status : 1,
                },
                success: function (data) {
                    table.ajax.reload(null,false);
                
                    
                },error:function(){ 
                    console.log(data);
                }
            });
        }) 
        $(document).on('click','.btn-unapprove', function(){
            var data = table.row($(this).closest('tr')).data();
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: "{{ url('updatePenarikan') }}" + '/' + data.id_keuangan,
                dataType: 'json',
                data : {
                    status : null,
                },
                success: function (data) {
                    table.ajax.reload(null,false);
                
                    
                },error:function(){ 
                    console.log(data);
                }
            });
        }) 
        $('.id_user').select2({
            placeholder: 'Pilih Nasabah',
            ajax: {
                url: "{{ route('select2nasabah') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            item.text = item.name  + " - Tabungan : " + renderAmount(item.tabungan,0); ;
                            item.id = item.id;
                            return item;
                        })
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            var data = e.params.data; 
            modal.find('.tabungan').val(data.tabungan).trigger('keyup');

            modal.find('.pengambilan').prop('readonly', false);
            if(data.tabungan == 0) modal.find('.pengambilan').prop('readonly', true); 
            modal.find('.pengambilan')
					.attr("data-inputmask", "'alias': 'currency', 'prefix': '', 'digits': '0', 'max': '" + parseFloat(data.tabungan) + "'")
					.inputmask({
						removeMaskOnSubmit: true
					}).on('focus', function () {
						$(this).select();
					});
                    $('.pengambilan').trigger('change');

        });

        

        $(document).on('change','.pengambilan', function(){
            let tabungan = unmaskValue(modal.find('.tabungan'));
            let pengambilan = unmaskValue(modal.find('.pengambilan'));
            modal.find('.sisa').val(parseFloat(tabungan-pengambilan));
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
                    data: 'nomor_keuangan',
                    className: 'text-center'
                },
                {
                    data: 'tanggal',
                    className: 'text-center',
                    render : function(meta,data,row){
                        return moment(row.tanggal).format('DD-MM-YYYY')
                    }
                },
                {
                    data: 'name',
                    className: 'text-center'
                }, 
                {
                    data: 'tanggal',
                    className: 'text-center',
                    render : function(meta,data,row){
                        return renderAmount(row.amount,0)
                    }
                },
                {
                    data: 'tanggal',
                    className: 'text-center',
                    render : function(meta,data,row){
                        var option = '';
                        if(row.is_approve == null){
                            option = ' <button class="btn btn-xs btn-info">Menunggu Persetujuan</button>';
                        }
                        if(row.is_approve != null){
                            option = ' <button class="btn btn-success btn-xs">Disetujui</button>';
                        }
                        return option
                    }
                },
                {
                    data: 'action',
                    visible : <?= Auth::user()->id_role == 3 ? "false" : "true"  ?>,
                    className: 'text-center', 
                },
               

            ]
        });
    });

    function resetIdKeuangan(){
        $('.id_keuangan').remove();
        $('.tanggal-realisasi').val(moment().format('DD-MM-YYYY'));
        @if(Auth::user()->id_role == 3)
        
        $('.id_user').append('<option value="<?= Auth::user()->id ?>"> <?= Auth::user()->name ?></option>').trigger('change');
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: "{{ route('select2nasabah') }}",
            dataType: 'json',
            success: function (data) {

                var dt = data[0];
                modal.find('.tabungan').val(dt.tabungan).trigger('keyup');
                modal.find('.pengambilan')
					.attr("data-inputmask", "'alias': 'currency', 'prefix': '', 'digits': '0', 'max': '" + parseFloat(dt.tabungan) + "'")
					.inputmask({
						removeMaskOnSubmit: true
					}).on('focus', function () {
						$(this).select();
					}); 
                 
            },error:function(){ 
                console.log(data);
            }
        });
        @endif
    
    }

</script>
@endsection
