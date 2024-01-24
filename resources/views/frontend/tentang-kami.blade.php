@extends('frontend.template')
@section('page')

<section class="single-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Tentang Kami</h2>
				<ol class="breadcrumb header-bradcrumb justify-content-center">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Beranda</a></li>
					<li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="about-shot-info section-sm">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mt-20">
				<h2 class="mb-3">SEJARAH SINGKAT</h2>
				<p>Sejarah singkat terbentuknya BANK SAMPAH INDUK HOBASTANK.</p>
				<p>Bank sampah induk hobastank muncul dari inisiasi para kader lingkungan yang merangkum keluh kesah beberapa 
					RT yang mau mendirikan bank sampah tetapi tidak punya lahan.</p>
				<p>oleh karena itu pada tanggal 10 Oktober 2022  dibentuklah bank sampah induk yang bertujuan utk  
					memfasilitasi bank sampah untuk pengangkutan dan penjualan ke pengepul
                    Bsi hobastank sendiri belum punya gudang, untuk tempat pengumpulan sampah di area kelurahan gending Alhamdulillah pemwrintahan kelurahan gending sangat mendukung dengan memberikan pinjaman lahan utk pengumpulan sampah dari BSU.
				</p>
			</div>
			<div class="col-lg-6 mt-4 mt-lg-0 text-center">
				<img loading="lazy" style="max-width: 50% !important" class="img-fluid" src="{{ asset('frontend/images/company/logo1.jpg') }}" alt="">
			</div>
		</div>
	</div>
</section>


<section class="company-mission section-sm bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h3>Misi Kami</h3>
				<p> BEBERAPA MISI :
					<p>Memberikan Pendidikan Pelatihan Dan Pengembangan Tentang Pengelolaan Sampah Yang Baik Dan Ramah Lingkungan.</p>
					<p>Mewujudkan Tata Kelola Bank Sampah Yang Akuntable, Inovatif, Kreatif, Inklusi, Mandiri Dan Profesional.</p>
					<p>Mendayagunakan Sampah Mempunyai Nilai Ekonomis Dengan Prinsip 3R.</p>
					<p>Membangun Kerjasama Dengan Berbagai Pihak Dalam Pengelolaan Sampah.</p>
					<p>Melestarikan Lingkungan Dan Membudayakan Lingkungan Yang Bersih Dan Sehat.</p>
				</p>
				<img loading="lazy" src="{{ asset('frontend/images/company/company-image-2.jpg') }}" alt="" class="img-fluid mt-30">
			</div>
			<div class="col-md-6 mt-5 mt-md-0">
				<h3>Visi Kami</h3>
				<p>Mewujudkan Masyarakat Yang Peduli Terhadap Lingkungan Dan Menjadi Pelopor Pengelolaan Sampah Berbasis Masyarakat.</p>
				<img loading="lazy" src="{{ asset('frontend/images/company/company-image-3.jpg') }}" alt="" class="img-fluid mt-30">
			</div>
		</div>
	</div>
</section>


<section class="promo-video section-sm">
	<div class="container">
		<div class="row justify-content-center">
			<!-- section title -->
			<div class="col-xl-6 col-lg-8">
				<div class="title text-center">
					<h2>Video Kegiatan Kami</h2>
					<p>Aplikasi Extrash adalah aplikasi bank sampah yang membantu nasabahnya untuk menukarkan 
					sampah dengan lebih mudah. Aplikasi ini akan melakukan implementasi awalnya di Kelurahan Gending, Kecamatan Kebomas, Kabupaten Gresik</p>
					<div class="border"></div>
				</div>
			</div>
		</div>
		<div class="row text-center">
			<!-- /section title -->
			<div class="col-md-12 mx-auto">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/cyS2ZyIs9x8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>

<!--
Start Call To Action
==================================== -->
<section class="call-to-action-2 section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2>"Yang Diperlukan Agar Dunia Tetap Selaras Hanyalah Bila Semua Makhluk Mengikuti Hukum Alam."</h2>
			</div>
		</div> 		<!-- End row -->
	</div>   	<!-- End container -->
</section>   <!-- End section -->
<section class="testimonial section" id="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- testimonial wrapper -->
                <div class="testimonial-slider">
                    <!-- testimonial single -->
					@foreach(dashboardElement()->pengurus as $k)
                    <div class="item text-center">
                        <i class="tf-ion-chatbubbles"></i>
                        <!-- client info -->
                        <div class="client-details">
                            <p>{!! $k->quote !!}</p>
                        </div>
                        <!-- /client info -->
                        <!-- client photo -->
                        <div class="client-thumb">
                            <img loading="lazy" src="{{ asset('pengurus/'. $k->foto_pengurus)}}"
                                class="img-fluid" alt="" style="min-height: 250px; min-width: 250px;">
                        </div>
                        <div class="client-meta">
                            <h3>{{ $k->nama_pengurus }}</h3> 
                        </div>
                        <!-- /client photo -->
                    </div>

					@endforeach
                    <!-- /testimonial single -->

                    <!-- /testimonial single -->
                </div>
            </div> <!-- end col lg 12 -->
        </div> <!-- End row -->
    </div> <!-- End container -->
</section> <!-- End Section -->



@endsection
