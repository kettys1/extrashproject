@extends('frontend.template')
@section('page')

<section class="single-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Kontak Kami</h2>
				<ol class="breadcrumb header-bradcrumb justify-content-center">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Beranda</a></li>
					<li class="breadcrumb-item active" aria-current="page">Kontak Kami</li>
				</ol>
			</div>
		</div>
	</div>
</section>

 <!--Start Contact Us
	=========================================== -->
 <section class="contact-us" id="contact">
 	<div class="container">
 		<div class="row justify-content-center">
			 <!-- section title -->
 			<div class="col-xl-6 col-lg-8">
				<div class="title text-center">
					<h2>Kontak Kami</h2>
					<p>Ada pertanyaan seputar tentang Extrash ? Hubungi Kami !</p>
					<div class="border"></div>
				</div>
			</div>
			<!-- /section title -->
		</div>
 		<div class="row justify-content-center">
 			<!-- Contact Details -->
 			<div class="contact-details col-md-8 text-center ">
 				<h3 class="mb-3">Extrash</h3>
 				<p>Extrash adalah platform yang di buat oleh departemen informatika untuk memudahkan penyetoran sampah dan juga pengolahan sampah </p>
 				
 				<!-- Footer Social Links -->
 				<!-- <div class="social-icon">
 					<ul>
 						<li><a href="https://instagram.com/extrash.id?igshid=YmMyMTA2M2Y=" target="_blank"><i class="tf-ion-social-instagram"></i></a></li> 
 					</ul>
 				</div> -->
 				<!--/. End Footer Social Links -->
 			</div>
 			<!-- / End Contact Details -->

 			<!-- Contact Form -->
 			<!-- <div class="contact-form col-md-6 ">
 				<form id="contact-form" method="post" role="form">
 					<div class="form-group mb-4">
 						<input type="text" placeholder="Your Name" class="form-control" name="name" id="name" required>
 					</div>

 					<div class="form-group mb-4">
 						<input type="email" placeholder="Your Email" class="form-control" name="email" id="email" required>
 					</div>

 					<div class="form-group mb-4">
 						<input type="text" placeholder="Subject" class="form-control" name="subject" id="subject" required>
 					</div>

 					<div class="form-group mb-4">
 						<textarea rows="6" placeholder="Message" class="form-control" name="message" id="message" required></textarea>
 					</div>
 					<div id="cf-submit">
 						<input type="submit" id="contact-submit" class="btn btn-transparent" value="Submit">
 					</div>

 				</form>
 			</div> -->
 			<!-- ./End Contact Form -->

 		</div>
		<div class="row">
			<div class="col-sm-12">
			<ul class="contact-short-info mt-4">
 					<li class="mb-3">
 						<i class="tf-ion-ios-home"></i>
 						<span>RJ9W+HC7, Gending, Sidomoro, Kec. Kebomas, Kabupaten Gresik, Jawa Timur 61123</span>
 					</li>
 					<li class="mb-3">
 						<i class="tf-ion-android-phone-portrait"></i>
 						<span>Phone: +628123456789</span>
 					</li>
 					<li>
 						<i class="tf-ion-android-mail"></i>
 						<span>Email: admin@extrash.id</span>
 					</li>
					<br>
 					<li>
						<a style="color:black" href="https://instagram.com/extrash.id?igshid=YmMyMTA2M2Y=" target="_blank">
							<i class="tf-ion-social-instagram"></i> &nbsp;<span>Instagram</span>
						</a> 
 					</li>
 				</ul>
			</div>
		</div> <!-- end row -->
 	</div> <!-- end container -->
 </section> <!-- end section -->

 <!--================================
=            Google Map            =
=================================-->
<div class="google-map">
	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7916.9493289233615!2d112.6414041!3d-7.1865528!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd801048764e833%3A0x4dee76e808a0b502!2sKantor%20Kelurahan%20Gending!5e0!3m2!1sid!2sid!4v1685627885983!5m2!1sid!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
 <!--====  End of Google Map  ====-->
@endsection
