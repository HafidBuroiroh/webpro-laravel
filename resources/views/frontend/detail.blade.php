@extends('frontend.layout')

@section('title', $pet->nama_pet . ' Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-start g-5">
        {{-- Left: Pet Image --}}
        <div class="col-md-5">
            <img src="{{ asset('pets_img/' . $pet->foto) }}" class="img-fluid rounded-4 shadow" alt="{{ $pet->nama_pet }}" style="height: 100%; object-fit: cover;">
        </div>

        {{-- Right: Pet Info --}}
        <div class="col-md-7 text-white">
            <h2 class="mb-3 sniglet-extrabold">{{ $pet->nama_pet }}</h2>

            <p class="mb-4 fs-5">
                {{ $pet->deskripsi ?? 'No description available for this pet.' }}
            </p>

            <ul class="list-unstyled fs-5 mb-4">
                <li><strong>Type:</strong> {{ ucfirst($pet->jenis) }}</li>
                <li><strong>Breed:</strong> {{ $pet->ras }}</li>
                <li><strong>Age:</strong> {{ $pet->umur }} year(s)</li>
                <li><strong>Status:</strong> {{ ucfirst($pet->status) }}</li>
                @if ($pet->status === 'adopsi' && $pet->adopsi)
                    @foreach($pet->adopsi as $adopt)
                        @if($adopt->vendorid)
                            <li><strong>Vendor:</strong> {{ $adopt->vendorid->nama_toko }}</li>

                            @if($adopt->vendorid->user)
                                <li><strong>Vendor Address:</strong> {{ $adopt->vendorid->user->alamat }}</li>
                            @endif
                        @endif
                    @endforeach
                @endif

            </ul>

            @if ($pet->status === 'adopsi' && $pet->adopsi)
                @foreach($pet->adopsi as $adopsi)
                    <p class="fs-4">Adoption Fee:
                        <strong>Rp {{ number_format($adopsi->harga_adopsi, 0, ',', '.') }}</strong>
                    </p>
                    <a href="#" class="btn btn-success rounded-pill px-4 py-2">Adopt Now</a>
                @endforeach
            @elseif ($pet->status === 'dijual' && $pet->penjualan)
                @foreach($pet->penjualan as $j)
                    <p class="fs-4">Price:
                        <strong>Rp {{ number_format($j->harga, 0, ',', '.') }}</strong>
                    </p>
                    <a href="#" class="btn btn-light text-dark rounded-pill px-4 py-2">Buy Now</a>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
