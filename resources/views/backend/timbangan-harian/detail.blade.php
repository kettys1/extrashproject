<?php

use Illuminate\Support\Facades\Auth;
?>
@extends('backend.layout')
@section('page')

<div class="row">
    <div class="col-sm-4 form-group">Nomor Transaksi</div>
    <div class="col-sm-8 form-group">: {{ $data->nomor_transaksi }}</div>

    <div class="col-sm-4 form-group">Tanggal Transaksi</div>
    <div class="col-sm-8 form-group">: {{ date('d-m-Y', strtotime($data->tanggal)) }}</div>
    
    <div class="col-sm-4 form-group">Nasabah</div>
    <div class="col-sm-8 form-group">: {{ $data->name }}</div>


    <div class="col-sm-12 form-group">
        <table class="table table-sm table-data">
            <thead class="thead-dark" style=" background: cadetblue; ">
                <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Barang</th>
                    <th class="text-center" scope="col">Harga Barang</th>
                    <th class="text-center" <?= Auth::user()->id_role == 1  || Auth::user()->id_role == 10 ? "style=display:none" : '' ?> scope="col">Harga Jual</th>
                    <th class="text-center" <?= Auth::user()->id_role == 1  || Auth::user()->id_role == 10 ? "style=display:none" : '' ?> scope="col">Laba</th>
                    <th class="text-center" scope="col">Qty</th>
                    <th class="text-center" scope="col">Sub Total</th>  
                </tr>
            </thead>
            <tbody>
                @if(!empty($detail))
                @php $total = 0; $hargabarang = 0; @endphp
                @foreach($detail as $key => $value)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td> {{ $value->nama_barang }}</td>
                    <td class="text-center">{{ number_format($value->harga_awal,0) }} </td>
                    <td class="text-center" <?= Auth::user()->id_role == 1  || Auth::user()->id_role == 10 ? "style=display:none" : '' ?> >{{ number_format($value->harga,0) }}</td>
                    <td class="text-center" <?= Auth::user()->id_role == 1  || Auth::user()->id_role == 10 ? "style=display:none" : '' ?> >{{ number_format($value->laba,0) }}</td>
                    <td class="text-center">{{ number_format($value->quantity,0) }}</td>
                    @if(Auth::user()->id_role == 1  || Auth::user()->id_role == 10)
                    <td class="text-center">{{ number_format($value->harga_awal * $value->quantity,0) }}</td> 
                    @else
                    <td class="text-center">{{ number_format($value->harga * $value->quantity,0) }}</td> 
                    @endif
                </tr>
                @php 
                
                if(Auth::user()->id_role == 1  || Auth::user()->id_role == 10 )   {
                    $total += $value->harga_awal * $value->quantity;
                    $hargabarang += $value->harga_awal;
                }else{
                    $total += $value->harga * $value->quantity;
                    $hargabarang += $value->harga;

                 }
                @endphp
                @endforeach
                @endif
                <tr>
                    <td colspan="<?= Auth::user()->id_role == 1  || Auth::user()->id_role == 10 ? "2" : '4' ?>" class="text-center">Total</td>
                    @if(Auth::user()->id_role == 1  || Auth::user()->id_role == 10)
                    <td class="text-center">{{ number_format($hargabarang) }}</td>
                    @else
                    <td class="text-center">{{ number_format(collect($detail)->sum('laba')) }}</td>
                    @endif
                    <td class="text-center">{{ number_format(collect($detail)->sum('quantity')) }}</td>
                    <td class="text-center">{{ number_format($total) }}</td> 
                </tr>
            </tbody>
        </table>

    </div>
    <div class="col-sm-12 form-group">
        <a href="{{ route('timbangan-harian.index') }}" class="btn btn-sm btn-danger">Kembali</a> 
    </div>
</div>
@endsection
