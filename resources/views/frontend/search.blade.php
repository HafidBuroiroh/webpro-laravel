@extends('frontend.layout')

@section('title', 'Search Data')

@section('content')
<div class="container py-5">
    <h1 class="text-white mb-4 text-center" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem;">
        Your Search
    </h1>

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

    <div class="row mx-3 justify-content-center">
        @foreach($pkh as $item)
        <div class="col-md-3 mb-4">
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
                <img src="{{asset('pkh_img/'.$item->foto)}}" class="card-img-top" alt="{{$item->nama}}" style="height: 300px; object-fit: cover;">
                <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
                    <div class="mb-3">
                        <h3 class="card-title sniglet-extrabold text-dark-color mb-2">{{$item->nama}}</h3>
                        <p class="card-text fw-semibold mb-2">{{ucfirst($item->status)}}</p>
                        
                        <!-- Description like AirPods Max -->
                        <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
                                {{ Str::limit($item->deskripsi, 100, '...') }}
                        </p>
                        
                        <!-- Price section -->
                        <div class="mb-3">
                            <p class="fw-bold fs-5 mb-1">Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <!-- Button at bottom -->
                    <a href="{{ route('product.detail', $item->id) }}" class="btn dark-color text-white rounded-pill mt-auto py-2">
                      Detail
                  </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



@endsection
