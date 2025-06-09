@extends('frontend.layout')
@section('title', 'Beranda')
@section('content')
<link rel="stylesheet" href="{{asset('css/beranda.css')}}">
<div class="banner-container position-relative overflow-hidden" style="height: 850px; background-color: #222831;">
    <!-- Overlay Gradient -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(90deg, rgba(34,40,49,0.9) 0%, rgba(34,40,49,0.7) 50%, rgba(34,40,49,0) 100%); z-index: 1;">
    </div>
    
    <!-- Banner Image -->
    <img src="https://i.pinimg.com/736x/7c/48/ad/7c48addaa248ca48a1b76a424a4ff29a.jpg" 
         alt="Happy dogs and cats at shelter" 
         class="position-absolute end-0 top-0 h-100 w-100 object-fit-cover rounded" 
         style="z-index: 0;">
    
    <!-- Banner Content -->
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <h1 class="text-white mb-3" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        Give Them a Loving Home
                    </h1>
                    <p class="text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1.2rem; max-width: 80%;">
                        Join us in our mission to provide shelter, care, and forever homes for abandoned pets in our community.
                    </p>
                    <a href="#" 
                       class="btn px-4 py-2 rounded-pill shadow" 
                       style="background-color: #DFD0B8; color: #222831; font-family: 'Poppins', sans-serif; font-weight: 600; transition: all 0.3s ease;">
                        See More
                    </a>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="container my-5">
    <div class="row justify-content-center g-4  align-items-center">
        <!-- Card untuk Logo -->
        <div class="col-md-6">
            <div class="text-center border-0 shadow-sm">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('logo.png') }}" alt="Animal Logo" class="img-fluid rounded" style="width: 80%">
                </div>
            </div>
        </div>

        <!-- untuk About Us -->
        <div class="col-md-6">
            <div class=" border-0 shadow-sm">
                <div class=" d-flex flex-column justify-content-center">
                    <h1 class="text-white sniglet-extrabold">About Petter</h1>
                    <p class="mb-0 fs-5 text-justify text-white">Welcome to our pet shelter, a caring space dedicated to rescuing, nurturing, and rehoming animals in need. We believe that every pet deserves a loving and safe home. Through our adoption program, we connect kind-hearted individuals and families with pets looking for a second chance.
                    In addition to adoption, we offer a trusted platform for ethical pet trading to ensure transparency and proper animal care. Whether you're here to adopt, buy, or simply support our mission, your presence helps us build a compassionate community for all animals.
                    Join us in making a difference—one paw at a time.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-5 secondark-color">
    <h1 class="text-white text-center sniglet-extrabold">Our Pet</h1>
    <p class="text-white text-center sniglet-regular fs-5 pbo-2">Our rescued friends ready for a second chance.</p>
    <div class="row mx-3 justify-content-center">
        @foreach($pet as $item)
        <div class="col-md-3 mb-4">
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
                <img src="{{asset('pets_img/'.$item->foto)}}" class="card-img-top" alt="{{$item->nama_pet}}" style="height: 300px; object-fit: cover;">
                <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
                    <div class="mb-3">
                        <h3 class="card-title sniglet-extrabold text-dark-color mb-2">{{$item->nama_pet}}</h3>
                        <p class="card-text fw-semibold mb-2">{{$item->ras}} - {{ucfirst($item->status)}}</p>
                        
                        <!-- Description like AirPods Max -->
                        <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
                            @if($item->deskripsi)
                                {{ Str::limit($item->deskripsi, 100, '...') }}
                            @else
                                {{$item->nama_pet}} yang menggemaskan siap menjadi teman setia Anda.
                            @endif
                        </p>
                        
                        <!-- Price section -->
                        <div class="mb-3">
                            @if ($item->status === 'dijual' && $item->penjualan)
                                @foreach ($item->penjualan as $penjualan)
                                    <p class="fw-bold fs-5 mb-1">Rp. {{ number_format($penjualan->harga, 0, ',', '.') }}</p>
                                @endforeach
                            @elseif ($item->status === 'adopsi' && $item->adopsi)
                                @foreach ($item->adopsi as $adopsi)
                                    <p class="fw-bold fs-5 mb-1">Rp. {{ number_format($adopsi->harga_adopsi, 0, ',', '.') }}</p>
                                @endforeach
                            @else
                                <p class="text-muted">Tersedia</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Button at bottom -->
                    <a href="{{ route('pet.detail', $item->id) }}" class="btn dark-color text-white rounded-pill mt-auto py-2">
                        Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
     <div class="text-center mt-4">
        <a href="pet-shop" class="btn btn-outline-light rounded-pill px-4 py-2 sniglet-extrabold">
           << Selengkapnya >>
        </a>
    </div>
</div>
<div class="container-fluid py-5">
    <h1 class="text-white text-center sniglet-extrabold pb-5">Our Partner</h1>
    <div class="slick">
        <div class="pet-slider text-center">
            <div><img src="https://i.pinimg.com/736x/dd/67/db/dd67dbbffbdf886d4470b64c3587ba54.jpg" alt="Pet 1"></div>
            <div><img src="https://t3.ftcdn.net/jpg/02/43/96/76/360_F_243967630_VdAkxeeeYUlRCbBbSJGsxuRjgLtwMzxi.jpg" alt="Pet 2"></div>
            <div><img src="https://st4.depositphotos.com/27269280/29634/v/450/depositphotos_296344850-stock-illustration-pets-home-vector-logo-template.jpg" alt="Pet 3"></div>
            <div><img src="https://i.pinimg.com/564x/ac/de/9a/acde9ae647157895dbc8bc0bbf017d71.jpg" alt="Pet 4"></div>
        </div>
    </div>
</div>
@endsection