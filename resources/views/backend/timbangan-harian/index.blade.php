@extends('backend.layout')
@section('page')
<div class="row">
    @if(Auth::user()->id_role == 2)
    <div class="col-sm-12 form-group">
        <a href="{{ route('timbangan-harian.create')  }}" class="btn btn-sm btn-success">Tambah Data</a>
        <hr>
    </div>
    @endif
    <div class="col-sm-12 form-group">
        <div class="table-responsive">
            <table class="table table-striped table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nasabah</th>
                        <th>Total Penjualan (RP)</th>
                        <th>Total Barang</th>
                        <th>Laba</th>
                        <th>Action</th>
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
    $(document).ready(function () {
        $('.table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [{
                    data: 'id',
                    name: 'id',
                    className: 'text-center',
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nomor_transaksi',
                    className: 'text-center'
                },
                {
                    data: 'tanggal_transaksi',
                    className: 'text-center',
                    render: function (meta, data, row) {
                        return moment(row.tanggal).format('DD-MM-YYYY');
                    }
                },
                {
                    data: 'name',
                    className: 'text-center'
                },
                {
                    data: 'total_barang',
                    className: 'text-center',
                    render: function (meta, data, row) {
                        return accounting.formatNumber(row.harga_jual);
                    }
                },
                {
                    data: 'total_barang',
                    className: 'text-center',
                    render: function (meta, data, row) {
                        return row.total_barang + " Barang";
                    }
                },
                {
                    data: 'total_barang',
                    className: 'text-center', 
                    render: function (meta, data, row) {
                        return accounting.formatNumber(row.laba);
                    }
                },
                {
                    data: 'action',
                    className: 'text-center',
                },


            ]
        });
    });
 

</script>
@endsection
