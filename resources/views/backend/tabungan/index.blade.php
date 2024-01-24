<?php

use Illuminate\Support\Facades\Auth;
?>
@extends('backend.layout')
@section('page')

<div class="row">
    <form action="{{ route('filterTabungan') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group">
            <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                <label>Bulan</label>
                <select class="select2" name="bulan">

                    @for($i = 1; $i <= 12; $i++)
                        <option <?= isset($bulan) && $bulan == str_pad($i,2,0, STR_PAD_LEFT) ? "selected" : ''  ?> value="{{ str_pad($i,2,0, STR_PAD_LEFT) }}">{{ tgl_indo(date('Y-m-d', strtotime('2020-'.str_pad($i,2,0, STR_PAD_LEFT).'-01'))) }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group">
            <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                <label>Tahun</label>
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <input type="number" class="form-control" name="tahun" value="<?= date('Y') ?>">
                </div>
            </div>
        </div>
        @if(Auth::user()->id_role == 1) 
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-1 form-group2">
                <div class="nk-int-mk sl-dp-mn">
                    <h2>BSU</h2>
                </div>
                <div class="bootstrap-select fm-cmp-mg">
                    <select class="select2" name="id_bsu">
                        <option value="" disabled selected>Pilih Data</option>
                        @foreach($user as $u)
                        <option <?= isset($us ) && $us->id == $u->id ? 'selected' : '' ?> value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
        
        @endif
        <div class="col-sm-2">
            <br>
            <button class="btn btn-sm btn-success"> Tampilkan Data</button>
        </div>
     

        <div class="col-sm-12 form-group">
            @if(!empty($data_masuk))
            <table class="table table-sm table-data table-bordered">
                <thead class="thead-dark" style=" background: cadetblue; ">
                    <tr>
                        <th style="vertical-align:middle" class="text-center"  scope="col">No</th>
                        <th style="vertical-align:middle" class="text-center"  scope="col">Tanggal Transaksi
                        </th>
                        <th style="vertical-align:middle" class="text-center"  scope="col">Status Transaksi
                        </th>
                        <th class="text-center">Nama Orang</th>
                        <th style="vertical-align:middle" class="text-center"  scope="col">Jumlah Masuk</th>
                       
                    </tr>
                </thead>
                @php $total = 0; $total_laba = 0; @endphp
                <tbody>
                    @foreach($data_masuk as $key => $value) 
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($value->tanggal)) }}</td>
                        <td class="text-center">Masuk </td>
                        <td class="text-center">{{ $value->name }}</td>
                        <td class="text-right">{{ number_format($value->amount,0) }}</td>
                    </tr>
                    @php $total += abs($value->amount); @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: grey;">
                        <th colspan="4" class="text-center">Total</th>
                        <th class="text-right">{{ number_format($total,0) }}</th>
                    </tr>
                </tfoot> 
            </table>
            @else
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            @endif

        </div>

    </form>


</div>

@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.select2').select2({});
    })
</script>
@endsection
