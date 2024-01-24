@extends('frontend.template')
@section('page')
<div class="hero-slider">
    <div class="slider-item th-fullpage hero-area"
        style="background-image: url({{ asset('frontend/images/slider/slide1.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">Selamat Datang <br>
                        di Extrash</h1>
                    <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">Mulai peduli lingkungan
                        dengan
                        Extrash
                        mari daur ulang sampah yang ada <br> Ayo mulai cinta Bumi kita.</p>
                    <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn btn-main"
                        href="{{ url('tentang-kami') }}">Jelajah lebih lanjut</a>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-item th-fullpage hero-area"
        style="background-image: url({{ asset('frontend/images/slider/slide2.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 data-duration-in=".3" data-animation-in="fadeInDown" data-delay-in=".1">Mari kita peduli <br>
                        dengan
                        lingkungan kita</h1>
                    <p data-duration-in=".3" data-animation-in="fadeInDown" data-delay-in=".5">Dengan melakukan daur
                        ulang kita
                        juga
                        menyelamatkan bumi kita
                        <br> </p>
                    <a data-duration-in=".3" data-animation-in="fadeInDown" data-delay-in=".8" class="btn btn-main"
                        href="service.html">Jelajah Lebih lanjut</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
Start Counter Section
==================================== -->
<section class="counter-wrapper section-sm">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 text-center">
                <div class="title">
                    <h2>Total Sampah</h2>
                    <p>Sampah yang dapat di kumpulkan dari masyarakat</p>
                    <p>Update 30 Maret 2023</p>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- first count item -->
            <div class="col-md-3 col-sm-6 col-xs-6 text-center ">
                <div class="counters-item">
                    <i class="tf-ion-ios-alarm-outline"></i>
                    <div>
                        <span class="counter" data-count="{{ dashboardElement()->nasabah }}">0</span>
                    </div>
                    <h3>Nasabah</h3>
                </div>
            </div>
            <!-- end first count item -->

            <!-- second count item -->
            <div class="col-md-3 col-sm-6 col-xs-6 text-center ">
                <div class="counters-item">
                    <i class="tf-ion-ios-analytics-outline"></i>
                    <div>
                        <span class="counter" data-count="{{ dashboardElement()->plastik }}">0</span>
                    </div>
                    <h3>Sampah Plastik</h3>
                </div>
            </div>
            <!-- end second count item -->

            <!-- third count item -->
            <div class="col-md-3 col-sm-6 col-xs-6 text-center ">
                <div class="counters-item">
                    <i class="tf-ion-ios-compose-outline"></i>
                    <div>
                        <span class="counter" data-count="{{ dashboardElement()->kertas }}">0</span>
                    </div>
                    <h3>Sampah Kertas</h3>

                </div>
            </div>
            <!-- end third count item -->

            <!-- fourth count item -->
            <div class="col-md-3 col-sm-6 col-xs-6 text-center ">
                <div class="counters-item kill-border">
                    <i class="tf-ion-ios-bolt-outline"></i>
                    <div>
                        <span class="counter" data-count="{{ dashboardElement()->lain_lain }}">0</span>
                    </div>
                    <h3>Sampah Lainnya</h3>
                </div>
            </div>
            <!-- end fourth count item -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end section -->

<!-- Start Our Team
		=========================================== -->
        <section class="team" id="team">
	<div class="container">
		<div class="row justify-content-center">
			<!-- section title -->
			<div class="col-xl-6 col-lg-8">
				<div class="title text-center ">
					<h2>Mitra Kami</h2>
					<p>Kami Bekerjasama Dengan</p>
					<div class="border"></div>
				</div>
			</div>
			<!-- /section title -->
		</div>
		<div class="row">
			<!-- team member -->
			<div class="col-lg-4 col-md-6">
				<div class="team-member text-center">
					<div class="member-photo">
						<!-- member photo -->
						<img loading="lazy" class="img-fluid" src="{{ asset('frontend/images/team/gambar1.png') }}" alt="Meghna">
						<!-- /member photo -->
					</div>
				</div>
			</div>
			<!-- end team member -->

			<!-- team member -->
			<div class="col-lg-4 col-md-6">
				<div class="team-member text-center">
					<div class="member-photo">
						<!-- member photo -->
						<img loading="lazy" class="img-fluid" src="{{ asset('frontend/images/team/gambar2.png') }}" alt="Meghna">
						<!-- /member photo -->

					</div>
				</div>
			</div>
			<!-- end team member -->

			<!-- team member -->
			<div class="col-lg-4 col-md-6">
				<div class="team-member text-center">
					<div class="member-photo">
						<!-- member photo -->
						<img loading="lazy" class="img-fluid" src="{{ asset('frontend/images/team/gambar4.png') }}" alt="Meghna">
						<!-- /member photo -->
					</div>
				</div>
			</div>
			<!-- end team member -->
		</div> <!-- End row -->
	</div> <!-- End container -->
</section> <!-- End section -->

<!--
Start Call To Action
==================================== -->
<section class="call-to-action section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 text-center">
                <h2>Entrepreneur Mengubah Sampah Rongsokan Menjadi Emas</h2>
                <a href="{{ url('kontak-kami') }}" class="btn btn-main">Kontak Kami</a>
            </div>
        </div> <!-- End row -->
    </div> <!-- End container -->
</section> <!-- End section -->

<section class="blog" id="blog">
    <div class="container">
        <div class="row justify-content-center">
            <!-- section title -->
            <div class="col-xl-6 col-lg-8">
                <div class="title text-center ">
                    <h2> Kegiatan <span class="color">Dan Berita</span></h2>
                    <div class="border"></div>
                    <p>Berikut ini adalah kegiatan dan berita terupdate tentang extrash</p>
                </div>
            </div>
            <!-- /section title -->
        </div>

        <div class="row">
            <!-- single blog post -->
            @foreach(dashboardElement()->kegiatan as $k)
            <article class="col-lg-4 col-md-6">
                <div class="post-item">
                    <div class="media-wrapper">
                        <img loading="lazy" src="{{ asset('kegiatan/'.$k->foto)}}" alt="amazing caves coverimage"
                            class="img-fluid">
                    </div>

                    <div class="content">
                        <h3><a href="single-post.html">{{ $k->judul }}</a></h3> 
                        <a class="btn btn-main" data-toggle="modal" data-target=".bd-example-modal-lg<?= $k->id ?>">Baca lebih
                            lanjut</a>
                    </div>
                </div>
            </article>
            <div class="modal fade bd-example-modal-lg<?= $k->id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="row text-center">
                                <div class="col-sm-12">
                                    <div class="media-wrapper">
                                        <img loading="lazy" src="{{ asset('kegiatan/'.$k->foto)}}"
                                            alt="amazing caves coverimage" class="img-fluid" height="250px">
                                    </div>
    
                                </div>
                                <div class="col-sm-12">
                                    <br>
                                    <br>
                                    <div class="content"> 
                                        <p>{!! $k->keterangan !!}</p>
                                         
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- end single blog post -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end section -->

<!-- Start Testimonial
=========================================== -->


<section class="section gallery">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-8">
				<div class="title text-center">
					<h2>Galeri</h2>
					<p>Kegiatan Rutin Memilah Sampah</p>
						<div class="border"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="company-gallery">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar1.jpg') }}" alt="">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar3.jpg') }}" alt="">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar4.jpg') }}" alt="">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar6.jpg') }}" alt="">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar7.jpg') }}" alt="">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar8.jpg') }}" alt="">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar9.jpg') }}" alt="">
					<img loading="lazy" src="{{ asset('frontend/images/company/gambar10.jpg') }}" alt="">
				
				</div>
			</div>
		</div>
	</div>
</section>

<!--
Start Blog Section
=========================================== -->
@endsection
