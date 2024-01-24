@extends('backend.layout')
@section('page')

<div class="row">
    <form action="{{ route('filter-rekap-bank-sampah') }}" method="post" enctype="multipart/form-data">
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
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-1 form-group2">
            <div class="nk-int-mk sl-dp-mn">
                <h2>Nasabah</h2>
            </div>
            <div class="bootstrap-select fm-cmp-mg">
                <select class="selectpicker" name="id_nasabah">
                    <option value="" disabled selected>Pilih Nasabah</option>
                    @foreach($user as $us)
                    <option value="{{ $us->id }}">{{ $us->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <br>
            <button class="btn btn-sm btn-success"> Tampilkan Data</button>
        </div>

        <div class="col-sm-12 form-group">
            <table class="table table-sm table-data table-bordered">
                <thead class="thead-dark" style=" background: cadetblue; ">
                    <tr>
                        <th style="vertical-align:middle" class="text-center" rowspan="3" scope="col">No</th>
                        <th style="vertical-align:middle" class="text-center" rowspan="3" scope="col">Tanggal Transaksi
                        </th> 
                        <th class="text-center" colspan="{{ count($kategori_barang) *2 }}" >Kategori Barang</th> 
                    </tr>
                    <tr>
                        @foreach($kategori_barang as $t)
                        <th class="text-center" scope="col" colspan="2">{{ $t->nama_kategori_barang }}</th> 
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($kategori_barang as $t)
                        <th class="text-center" scope="col">Qty</th> 
                        <th class="text-center" scope="col">Rp</th> 
                        @endforeach
                    </tr>
                </thead>
                @if(!empty($data_masuk))
                @php $total = 0 @endphp
                <tbody>
                    @foreach($data_masuk as $key => $value) 
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($value->tanggal)) }}</td> 
                        @foreach($kategori_barang as $t)
                        @php 
                            $barang = collect($detail)->where('tanggal', $value->tanggal)->where('id_kategori_barang', $t->id_kategori_barang)->first();
                        @endphp
                            <td class="text-center" scope="col"><span class="text-info">{{ isset($barang->quantity) ? $barang->quantity : 0 }}</span></td> 
                            <td class="text-center" scope="col"><span class="text-success">{{ isset($barang->harga) ? number_format($barang->harga,0) : 0 }}</span></td> 
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>

        </div>

    </form>


</div>

@endsection
@section('js')
@endsection
