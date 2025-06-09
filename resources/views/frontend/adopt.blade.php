@extends('frontend.layout')
@section('title', 'Adopt')
@section('content')
<link rel="stylesheet" href="{{asset('css/adopsi.css')}}">
<div class="banner-container position-relative overflow-hidden" style="height: 850px; background-color: #222831;">
    <!-- Overlay Gradient -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(90deg, rgba(34,40,49,0.9) 0%, rgba(34,40,49,0.7) 50%, rgba(34,40,49,0) 100%); z-index: 1;">
    </div>
    
    <!-- Banner Image -->
    <img src="https://i.pinimg.com/736x/03/53/6a/03536aae682657517b8b5c283719b993.jpg" 
         alt="Happy dogs and cats at shelter" 
         class="position-absolute end-0 top-0 h-100 w-100 object-fit-cover rounded" 
         style="z-index: 0;">
    
    <!-- Banner Content -->
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <h1 class="text-white mb-3" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        Their Second Chance Begins With You
                    </h1>
                    <p class="text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1.2rem; max-width: 80%;">
                        Open your heart and home to a rescued soul waiting for their perfect match
                    </p>
                    <a href="#" 
                       class="btn px-4 py-2 rounded-pill shadow" 
                       style="background-color: #DFD0B8; color: #222831; font-family: 'Poppins', sans-serif; font-weight: 600; transition: all 0.3s ease;">
                        Adopt Today
                    </a>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="container-fluid py-5 secondark-color">
    <div class="mx-auto pb-2 w-50">
        <h1 class="text-white text-center sniglet-extrabold mb-2">What's Adopt About?</h1>
        <p class="text-white text-center fw-semibold px-auto">Adopting a pet is a meaningful way to give an animal a second chance at life. Many cats and dogs in shelters are in need of a loving home, and adoption helps reduce the number of stray or abandoned animals. When someone adopts a pet, they are not only gaining a loyal companion, but also saving a life. Unlike buying from breeders, adoption often includes vaccinations and basic health checks, making it both a kind and practical choice. By choosing to adopt, people show compassion and responsibility toward animals in need.</p>
    </div>
    <h2 class="text-center sniglet-extrabold text-white mb-3">Why Adoption Matters</h2>
    
     <div class="row text-center justify-content-center mx-3 w-75 mx-auto ">
      <!-- Card 1 -->
      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
          <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
            <div class="icon-wrapper bg-light-color text-white rounded-circle mx-auto mb-4" style="width: 70px; height: 70px; line-height: 70px;">
              <i class="fas fa-heartbeat fa-2x"></i>
            </div>
            <h3 class="card-title sniglet-extrabold text-dark-color mb-2">Saves Lives</h3>
            <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
              You rescue animals from overcrowded shelters and give them a second chance at life.
            </p>
          </div>
        </div>
      </div>
    
      <!-- Card 2 -->
      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
          <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
            <div class="icon-wrapper bg-light-color text-white rounded-circle mx-auto mb-4" style="width: 70px; height: 70px; line-height: 70px;">
              <i class="fas fa-wallet fa-2x"></i>
            </div>
            <h3 class="card-title sniglet-extrabold text-dark-color mb-2">More Affordable</h3>
            <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
              Adoption fees are typically lower than buying, and pets often come vaccinated.
            </p>
          </div>
        </div>
      </div>
    
      <!-- Card 3 -->
      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
          <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
            <div class="icon-wrapper bg-light-color text-white rounded-circle mx-auto mb-4" style="width: 70px; height: 70px; line-height: 70px;">
              <i class="fas fa-home fa-2x"></i>
            </div>
            <h3 class="card-title sniglet-extrabold text-dark-color mb-2">Ready for Home</h3>
            <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
              Shelter pets are often already house-trained and socialized.
            </p>
          </div>
        </div>
      </div>
    
      <!-- Card 4 -->
      <div class="col-md-6 col-lg-3">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
          <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
            <div class="icon-wrapper bg-light-color text-white rounded-circle mx-auto mb-4" style="width: 70px; height: 70px; line-height: 70px;">
              <i class="fas fa-paw fa-2x"></i>
            </div>
            <h3 class="card-title sniglet-extrabold text-dark-color mb-2">Fight Overpopulation</h3>
            <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
              Adopting helps reduce demand for unethical breeding operations.
            </p>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="container py-5">
    <h1 class="text-white text-center sniglet-extrabold mb-2">Pets To Adopt</h1>
    <p class="text-white text-center fw-semibold px-auto">Pets ready to adopt are waiting for a loving home. Give them a second chance and find a loyal companion today.</p>
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
                             @foreach ($item->adopsi as $adopsi)
                                <p class="fw-bold fs-5 mb-1">Rp. {{ number_format($adopsi->harga_adopsi, 0, ',', '.') }}</p>
                            @endforeach
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
</div>

<style>
  .icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ff6b6b; /* Your light-color */
    transition: transform 0.3s;
  }
  .card:hover .icon-wrapper {
    transform: scale(1.1) rotate(10deg);
  }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection