@extends('backend.layout')
@section('page')

<div class="row">
    <div class="col-sm-4 form-group">Tanggal Transaksi</div>
    <div class="col-sm-8 form-group">: {{ date('d-m-Y', strtotime($data->tanggal_transaksi)) }}</div>
    
    <div class="col-sm-4 form-group">Nasabah</div>
    <div class="col-sm-8 form-group">: {{ $data->nama_user }}</div>


    <div class="col-sm-12 form-group">
        <table class="table table-sm table-data">
            <thead class="thead-dark" style=" background: cadetblue; ">
                <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Barang</th>
                    <th class="text-center" scope="col">Harga</th>
                    <th class="text-center" scope="col">Qty</th>
                    <th class="text-center" scope="col">Sub Total</th> 
                </tr>
            </thead>
            <tbody>
                @if(!empty($detail))
                @php $total = 0; @endphp
                @foreach($detail as $key => $value)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td> {{ $value->nama_barang }}</td>
                    <td class="text-center">{{ number_format($value->harga,0) }}</td>
                    <td class="text-center">{{ number_format($value->quantity,0) }}</td>
                    <td class="text-center">{{ number_format($value->quantity * $value->harga,0) }}</td>
                </tr>
                @php $total += $value->harga * $value->quantity; @endphp
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-center">Total</th>
                    <th class="text-center">{{ number_format($total,0) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
    <div class="col-sm-12 form-group">
        <a href="{{ route('timbangan-harian.index') }}" class="btn btn-sm btn-danger">Kembali</a> 
    </div>
</div>
@endsection
