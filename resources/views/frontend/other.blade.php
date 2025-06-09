@extends('frontend.layout')
@section('title', 'Other')
@section('content')
<link rel="stylesheet" href="{{ asset('css/lainnya.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="banner-container position-relative overflow-hidden" style="height: 850px; background-color: #222831;">
    <!-- Overlay Gradient -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(90deg, rgba(34,40,49,0.9) 0%, rgba(34,40,49,0.7) 50%, rgba(34,40,49,0) 100%); z-index: 1;">
    </div>
    
    <!-- Banner Image -->
    <img src="https://i.pinimg.com/736x/89/2f/b5/892fb53a7eaa866948f7ddc0c05215fc.jpg" 
         alt="Happy dogs and cats at shelter" 
         class="position-absolute end-0 top-0 h-100 w-100 object-fit-cover rounded" 
         style="z-index: 0;">
    
    <!-- Banner Content -->
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <h1 class="text-white mb-3" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        Beyond the Basics, For Every Pet Lover
                    </h1>
                    <p class="text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1.2rem; max-width: 80%;">
                        Discover helpful articles, tips, events, and resources designed to enrich your journey as a pet parent. Whether you're seeking advice or simply inspiration, this is your space.
                    </p>
                    <a href="#" 
                    class="btn px-4 py-2 rounded-pill shadow" 
                    style="background-color: #DFD0B8; color: #222831; font-family: 'Poppins', sans-serif; font-weight: 600; transition: all 0.3s ease;">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="container py-5">
    <h1 class="text-white text-center sniglet-extrabold">Article</h1>
    <p class="text-white text-center sniglet-regular fs-5 pbo-2">Tips and Information About Pet</p>
    <div class="row justify-content-center mx-3">
        @foreach($article as $item)
        <div class="col-md-3 mb-4">
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
                <img src="{{asset('sampul/'.$item->sampul)}}" class="card-img-top" alt="{{$item->sampul}}" style="height: 300px; object-fit: cover;">
                <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
                    <div class="mb-3">
                        <h3 class="card-title sniglet-extrabold text-dark-color mb-2">{{$item->judul}}</h3>
                        <p class="card-text fw-semibold mb-2">{{$item->subjudul}}</p>
                        
                        <!-- Description like AirPods Max -->
                        <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
                            @if($item->isi)
                                {{ Str::limit($item->isi, 100, '...') }}
                            @else
                                {{$item->judul}}, article for you
                            @endif
                        </p>
                    </div>
                    <a href="{{url('/article',$item->slug)}}" class="btn dark-color text-white rounded-pill mt-auto py-2">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container py-5">
    <h1 class="text-white text-center sniglet-extrabold">Our Location</h1>
    <p class="text-white text-center sniglet-regular fs-5 pbo-2">Jl. H. Asmawi No.5, RW.5, Beji, Kecamatan Beji, Kota Depok, Jawa Barat 16421</p>
    <div class="d-flex justify-content-center mx-auto">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.142629883487!2d106.8086320849773!3d-6.375581645884022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69eea967e072df%3A0xabebefbd3f7e666!2sJl.%20H.%20Asmawi%20No.5%2C%20RW.5%2C%20Beji%2C%20Kecamatan%20Beji%2C%20Kota%20Depok%2C%20Jawa%20Barat%2016421!5e0!3m2!1sid!2sid!4v1749388717906!5m2!1sid!2sid" width="80%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

@endsection
