@extends('frontend.template')
@section('page')

<section class="single-page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Jadwal Timbang</h2>
                <ol class="breadcrumb header-bradcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jadwal Timbang</li>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">Tanggal Mulai</th>
                            <th scope="col" class="text-center">Tanggal Akhir</th>
                            <th scope="col" class="text-center">Bank Unit</th> 
                        </tr>
                    </thead>
                    <tbody>
						@foreach(jadwalGLobal() as $key => $l)
                        <tr>
                            <th class="text-center" scope="row">{{ $key+1 }}</th>
                            <td class="text-center">{{ date('d M Y', strtotime($l->tanggal_awal)) }}</td>
                            <td class="text-center">{{ date('d M Y', strtotime($l->tanggal_akhir)) }}</td>
                           	<td>
								@foreach($l->bsu_unit as $i)
									<p>{{ $i->name }}</p>
								@endforeach
							</td>
                        </tr>
						@endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end container -->
</section> <!-- end section -->
 
<!--====  End of Google Map  ====-->
@endsection
