@extends('frontend.template')
@section('page')

<section class="single-page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Kategori Sampah</h2>
                <ol class="breadcrumb header-bradcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kategori Sampah</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!--Start Contact Us
	=========================================== -->
<section class="contact-us" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne" style="margin-right:20px"> Kategori Sampah </button>
                                        <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseTwo"
                                            aria-expanded="true" aria-controls="collapseTwo" style="margin-left:20px"> Harga Sampah Nasabah </button>
    
                                    </div>
                                </div>
                            </h5>
                        </div>
    
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">No</th>
                                                    <th scope="col" class="text-center">Nama Kategori Sampah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($kategoriBarang as $key => $l)
                                                <tr>
                                                    <th class="text-center" scope="row">{{ $key+1 }}</th>
                                                    <td class="text-center">{{ $l->nama_kategori_barang }}</td>
                                                </tr>
                                                @endforeach
    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12"></div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Nama Sampah</th>
                                                <th scope="col" class="text-center">Kategori Sampah</th>
                                                <th scope="col" class="text-center">Harga Sampah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($barang as $key => $l)
                                                @if($l->harga_nasabah > 0)
                                                <tr>
                                                    <th class="text-center" scope="row">{{ $key+1 }}</th>
                                                    <td class="text-center">{{ $l->nama_barang }}</td>
                                                    <td class="text-center">{{ $l->nama_kategori_barang }}</td>
                                                    <td class="text-center">{{ number_format($l->harga_nasabah,0) }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
            
                                        </tbody>
                                    </table>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end container -->
</section> <!-- end section -->

<!--====  End of Google Map  ====-->
@endsection
