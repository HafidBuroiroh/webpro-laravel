@extends('frontend.layout')

@section('title', $article->judul . ' Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-start g-5">
        {{-- Left: article Image --}}
        <div class="col-md-5">
            <img src="{{ asset('sampul/' . $article->sampul) }}" alt="{{ $article->judul }}" 
                class="img-fluid rounded-4 shadow" 
                style="height: 100%; object-fit: cover;">
        </div>

        {{-- Right: article Details --}}
        <div class="col-md-7 text-white">
            <h2 class="mb-3 sniglet-extrabold">{{ $article->judul }}</h2>
            <h5 class="mb-3 sniglet-regular">{{ $article->subjudul }}</h5>
            <p class="text-white fw-semibold">
                {{$article->isi}}
            </p>

        </div>
    </div>
</div>
@endsection
