<?php

use Illuminate\Support\Facades\Auth;
?>
@extends('backend.layout')
@section('page')

<div class="row">
    <form action="{{ route('filter-rekap-timbangan') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group">
            <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                <label>Tanggal Awal</label>
                <div class="input-group date nk-int-st">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name="tanggal_awal" value="<?= date('01-m-Y') ?>">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group">
            <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                <label>Tanggal Akhir</label>
                <div class="input-group date nk-int-st">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name="tanggal_akhir" value="<?= date('t-m-Y') ?>">
                </div>
            </div>
        </div>
        @if(Auth::user()->id_role == 3)
            <input type="hidden" name="id_nasabah" value="{{ Auth::user()->id }}" />
        @else
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-1 form-group2">
            <div class="nk-int-mk sl-dp-mn">
                <h2>{{ Auth::user()->id_role == 1 ? 'BSU' : 'Nasabah' }}</h2>
            </div>
            <div class="bootstrap-select fm-cmp-mg">
                <select class="selectpicker" name="id_nasabah">
                    <option value="" disabled selected>Pilih Data</option>
                    @foreach($user as $u)
                    <option <?= isset($us ) && $us->id == $u->id ? 'selected' : '' ?> value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @endif
        <div class="col-sm-2">
            <br>
            <button class="btn btn-sm btn-success"> Tampilkan Data</button>
        </div>
     

        <div class="col-sm-12 form-group">
            @if(!empty($data))
            <table class="table table-sm table-data table-bordered">
                <thead class="thead-dark" style=" background: cadetblue; ">
                    <tr>
                        <th style="vertical-align:middle" class="text-center" rowspan="2" scope="col">No</th>
                        <th style="vertical-align:middle" class="text-center" rowspan="2" scope="col">Tanggal Transaksi
                        </th>
                        <th style="vertical-align:middle" class="text-center" rowspan="2" scope="col">Status Transaksi
                        </th>
                        <th class="text-center" colspan="2">Mutasi (Rp)</th>
                        <th style="vertical-align:middle" class="text-center" rowspan="2" scope="col">Saldo Akhir</th>
                        @if(Auth::user()->id_role == 1)
                        <!-- <th style="vertical-align:middle" class="text-center" rowspan="2" scope="col">Laba</th> -->
                        @endif
                    </tr>
                    <tr>
                        <th class="text-center" scope="col">Masuk</th>
                        <th class="text-center" scope="col">Keluar</th>
                    </tr>
                </thead>
                @php $total = 0; $total_laba = 0; @endphp
                <tbody>
                    @foreach($data as $key => $value)
                    @php $total += $value->amount; @endphp
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($value->tanggal)) }}</td>
                        <td class="text-center"><?= $value->amount > 0 ? '<i class="notika-icon notika-up-arrow"></i> Pemasukan Tabungan' : '<i class="notika-icon notika-down-arrow"></i> Penarikan Tabungan' ?>
                    </td>
                    <td class="text-right">{{ $value->amount > 0 ? number_format($value->amount,0) : '' }}</td>
                    <td class="text-right">{{ $value->amount < 0 ? number_format(abs($value->amount),0) : '' }}</td>
                    <td class="text-right">{{ number_format(abs($total),0) }}</td>
                    @if(Auth::user()->id_role == 1)
                    <!-- <td class="text-right">{{  number_format(abs($value->laba),0) }}</td> -->
                    @endif
                    </tr>
                    @php $total_laba += abs($value->laba); @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: grey;">
                        <th colspan="5" class="text-center">Total</th>
                        <th class="text-right">{{ number_format($total,0) }}</th>
                        @if(Auth::user()->id_role == 1)
                        <!-- <th class="text-right">{{ number_format(collect($data)->sum('laba'),0) }}</th> -->
                        @endif
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
@endsection
