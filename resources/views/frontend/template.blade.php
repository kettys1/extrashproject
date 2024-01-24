<!DOCTYPE html>

<html lang="en">

<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>Extrash</title>

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="One page parallax responsive HTML Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Themefisher Bingo HTML Template v1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/favicon.png') }}" />

    <!-- CSS
  ================================================== -->
    <!-- Themefisher Icon font -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/themefisher-font/style.css') }}">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- Lightbox.min css -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/lightbox2/css/lightbox.min.css') }}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/animate/animate.css') }}">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

</head>

<body id="body">

    <!--
  Start Preloader
  ==================================== -->
    <div id="preloader">
        <div class='preloader'>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!--
  End Preloader
  ==================================== -->

    <!--
Fixed Navigation
==================================== -->
    <header class="navigation fixed-top">
        <div class="container">
            <!-- main nav -->
            <nav class="navbar navbar-expand-lg navbar-light px-0">
                <!-- logo -->
                <a class="navbar-brand logo" href="{{ url('/') }}">
                    <img loading="lazy" class="logo-default" src="{{ asset('frontend/images/logo.png') }}" alt="logo" />
                    <img loading="lazy" class="logo-white" src="{{ asset('frontend/images/logo-white.png') }}"
                        alt="logo" />
                </a>
                <!-- /logo -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                    aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="navbar-nav ml-auto text-center">
                        <li class="nav-item ">
                            <a class="nav-link" href="/">Beranda</a>
                        </li>
                        <!-- <li class="nav-item ">
              <a class="nav-link" href="*">Agenda</a>
            </li> -->
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('tentang-kami') }}">Tentang Kami</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('kontak-kami') }}">Kontak Kami</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('jadwal-timbang') }}">Jadwal Timbang</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('kategori-sampah') }}">Kategori Sampah</a>
                        </li>
                        @if(!Auth::check())
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('login') }}">Login</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <form action="{{ url('logout') }}" id="tyt" method="POST">
                                @csrf
                                <a class="nav-link" onclick="$('#tyt').submit()" >Logout</a>
                            </form>
                        </li>
                        @endif
                    </ul>
                </div>
            </nav>
            <!-- /main nav -->
        </div>
    </header>
    <!--
End Fixed Navigation
==================================== -->
    @section('page')
    @show



    <footer id="footer" class="bg-one">
      
        <div class="footer-bottom">
            <h5>&copy; Copyright 2023. All rights reserved.</h5>
            <h6>Design and Developed by <a href="https://extrash.com/">Extrash</a></h6>
        </div>
    </footer> <!-- end footer -->


    <!-- end Footer Area
========================================== -->
    <!-- 
    Essential Scripts
    =====================================-->
    <!-- Main jQuery -->
    <script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap4 -->
    <script src="{{ asset('frontend/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!-- Parallax -->
    <script src="{{ asset('frontend/plugins/parallax/jquery.parallax-1.1.3.js') }}"></script>
    <!-- lightbox -->
    <script src="{{ asset('frontend/plugins/lightbox2/js/lightbox.min.js') }}"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('frontend/plugins/slick/slick.min.js') }}"></script>
    <!-- filter -->
    <script src="{{ asset('frontend/plugins/filterizr/jquery.filterizr.min.js') }}"></script>
    <!-- Smooth Scroll js -->
    <script src="{{ asset('frontend/plugins/smooth-scroll/smooth-scroll.min.js') }}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU"></script>
    <script src="{{ asset('frontend/plugins/google-map/gmap.js') }}"></script>

    <!-- Custom js -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>

</body>

</html>
