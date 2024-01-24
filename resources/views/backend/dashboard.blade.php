@extends('backend.layout')
@section('page')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                Total Barang Perkategori
            </div>
            <hr>
            <div class="card-body">
                <div class="row">
                    @foreach(groupBarang() as $l)
                    <div class="col-sm-12">
                        <p>{{ $l->nama_kategori_barang }}</p>
                    </div>
                    <div class="col-sm-12">
                        @php 
                            $total_barang = 0;
                            if($l->total_barang <= 25) $total_barang = 25;
                            if($l->total_barang > 25 && $l->total_barang <= 50) $total_barang = 50;
                            if($l->total_barang > 50 && $l->total_barang <= 75) $total_barang = 75;
                            if($l->total_barang > 75) $total_barang = 75;
                        @endphp
                        
                        <div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{ $total_barang }}%"> <span class="sr-only">70% Complete</span> </div> </div>
                        
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
