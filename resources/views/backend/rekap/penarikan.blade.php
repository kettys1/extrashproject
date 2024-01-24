<?php

use Illuminate\Support\Facades\Auth;
?>
@extends('backend.layout')
@section('page')
<div class="row">
    
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
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div> 
@endsection
@section('js')
<script type="text/javascript">
    let modal = $("#pengambilan-modal");
    $(document).ready(function () {
        
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
            ajax: {
                url : '{{ url()->current() }}',
                data : {
                    is_approve : 1
                }
            },
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
                    searchable : false,
                    className: 'text-center'
                },
                {
                    data: 'tanggal',
                    searchable : false,
                    className: 'text-center',
                    render : function(meta,data,row){
                        return moment(row.tanggal).format('DD-MM-YYYY')
                    }
                },
                {
                    data: 'name',
                    searchable : false,
                    className: 'text-center'
                }, 
                {
                    data: 'tanggal',
                    className: 'text-center',
                    searchable : false,
                    render : function(meta,data,row){
                        return renderAmount(row.amount,0)
                    }
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
                console.log(data);
                 
            },error:function(){ 
                console.log(data);
            }
        });
        @endif
    
    }

</script>
@endsection
