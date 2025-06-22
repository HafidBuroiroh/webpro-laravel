<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Petter Shop</title>
	<link rel="icon" type="image/png" href="{{asset('logo-cut.png')}}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sniglet:wght@400;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/layout.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Add to your <head> -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



  </head>
  <body class="text dark-color">
    <nav class="navbar navbar-expand-lg dark-color shadow py-3 sticky-top">
        <div class="container-fluid mx-5">
            <a class="navbar-brand fw-bold fs-3 sniglet-extrabold text-light-color">
            Petter
            </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
                <ul class="navbar-nav mb-2 mb-lg-0 gap-4 justify-content-start">
                    <li class="nav-item">
                        <a class="nav-link poppins-semibold text-light-color {{ Request::is('/') ? 'navactive' : '' }}" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link poppins-semibold text-light-color {{ Request::is('adopt') ? 'navactive' : '' }}" href="/adopt">Adopt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link poppins-semibold text-light-color {{ Request::is('pet-shop') ? 'navactive' : '' }}" href="/pet-shop">Pet Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link poppins-semibold text-light-color {{ Request::is('other') ? 'navactive' : '' }}" href="/other">Other</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex gap-2 align-items-center">
                <form action="{{ url('search') }}" method="GET" class="d-flex align-items-center rounded-pill border" style="overflow: hidden" role="search">
                    <div class="input-group rounded-pill" style="width: 150px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input 
                            class="form-control border-start-0 px-2" 
                            type="search" 
                            name="query" 
                            placeholder="Search..." 
                            aria-label="Search"
                        >
                    </div>
                </form>
                {{-- If user is NOT logged in --}}
                @guest
                    <a href="/login" class="btn rounded-pill px-4 text-light-color secondark-color poppins-regular">
                        Sign In
                    </a>
                @endguest

                {{-- If user IS logged in and has level "user" --}}
                @auth
                    @if(Auth::user()->level === 'user')
                        <a href="/my/cart" class="text-white link-offset-2 link-underline link-underline-opacity-0">
                            <h4 class="mx-0 my-0"><i class="bi bi-cart2"></i></h4>
                        </a>
                        <a href="/settings" class="text-white link-offset-2 link-underline link-underline-opacity-0">
                            <h4 class="mx-0 my-0"><i class="bi bi-person-gear"></i></h4>
                        </a>
                        <a href="/history-transaction" class="text-white link-offset-2 link-underline link-underline-opacity-0">
                            <h4 class="mx-0 my-0"><i class="bi bi-file-earmark-medical"></i></h4>
                        </a>
                        <a href="/logout" class="link-offset-2 link-underline link-underline-opacity-0">
                            <h4 class="mx-0 my-0" style="color: red"><i class="bi bi-box-arrow-left"></i></h4>
                        </a>
                    @else
                        <a href="/login" class="btn rounded-pill px-4 text-light-color secondark-color poppins-regular">
                            Sign In
                        </a>
                    @endif
                @endauth

            </div>
        </div>
    </nav>

     @yield('content')

    <footer class="light-color text-white pt-5 pb-4 poppins-semibold text-justify">
        <div class="container">
            <div class="row text-start text-md-left">
            <!-- Kolom 1: Logo & Sosial Media -->
                <div class="col-md-4 mb-4">
                    <h4 class="sniglet-extrabold text-secondark-color">Petter</h4>
                    <div class="d-flex gap-3">
                    <a href="#"><i class="bi bi-facebook text-secondark-color"></i></a>
                    <a href="#"><i class="bi bi-instagram text-secondark-color"></i></a>
                    <a href="#"><i class="bi bi-twitter text-secondark-color"></i></a>
                    <a href="#"><i class="bi bi-whatsapp text-secondark-color"></i></a>
                </div>
            </div>

            <!-- Kolom 3: Menu -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold text-secondark-color sniglet-regular">Menu</h5>
                <ul class="list-unstyled">
                <li><a href="#" class="text-secondark-color fw-semibold text-decoration-none">Beranda</a></li>
                <li><a href="#" class="text-secondark-color fw-semibold text-decoration-none">Adopsi</a></li>
                <li><a href="#" class="text-secondark-color fw-semibold text-decoration-none">Jual/Beli</a></li>
                <li><a href="#" class="text-secondark-color fw-semibold text-decoration-none">Lainnya</a></li>
                </ul>
            </div>

             <!-- Kolom 2: Tentang Kami -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold text-secondark-color text-justify sniglet-regular">About Us</h5>
                <p class="mb-1 text-secondark-color fw-semibold text-justify">We are a trusted platform dedicated to the adoption and sale of pets, committed to creating a safe and caring environment for both animals and pet lovers. At Petter, our mission is to connect loving families with animals in need of a home, as well as to support responsible breeders and pet owners through secure, transparent transactions. <br><br> <span class="fw-bold">Address: </span>Jl. H. Asmawi No.5, RW.5, Beji, Kecamatan Beji, Kota Depok, Jawa Barat 16421 <br><br>
                <span class="fw-bold">Email: </span>info@petter.id</p>
            </div>
            <hr class="text-dark">
            <p class="text-dark text-center">Copyright © 2025 IT Petter</p>

        </div>
    </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script>
        $(document).ready(function(){
  $('.pet-slider').slick({
    dots: true,
    infinite: true,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
});
    </script>
  </body>
</html>