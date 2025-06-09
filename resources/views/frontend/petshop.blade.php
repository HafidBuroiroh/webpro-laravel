@extends('frontend.layout')
@section('title', 'Pet Shop')
@section('content')
<link rel="stylesheet" href="{{ asset('css/jubel.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="banner-container position-relative overflow-hidden" style="height: 850px; background-color: #222831;">
    <!-- Overlay Gradient -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(90deg, rgba(34,40,49,0.9) 0%, rgba(34,40,49,0.7) 50%, rgba(34,40,49,0) 100%); z-index: 1;">
    </div>
    
    <!-- Banner Image -->
    <img src="https://i.pinimg.com/736x/b8/b2/69/b8b26968d2288aac2f718548501c778d.jpg" 
         alt="Happy dogs and cats at shelter" 
         class="position-absolute end-0 top-0 h-100 w-100 object-fit-cover rounded" 
         style="z-index: 0; transform: scaleX(-1);">
    
    <!-- Banner Content -->
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <h1 class="text-white mb-3" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                         Everything Your Pet Needs
                    </h1>
                    <p class="text-white mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1.2rem; max-width: 80%;">
                        Explore our pet shop for high-quality food, toys, accessories, and more—everything to keep your furry friend happy and healthy.
                    </p>
                    <a href="#" 
                       class="btn px-4 py-2 rounded-pill shadow" 
                       style="background-color: #DFD0B8; color: #222831; font-family: 'Poppins', sans-serif; font-weight: 600; transition: all 0.3s ease;">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="container my-5">
    <h1 class="text-white text-center sniglet-extrabold mb-2">Category</h1>
    {{-- Filter kategori --}}
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
        @php
            $categories = ['Kucing', 'Anjing', 'hewan-lain', 'kebutuhan-hewan'];
            $categoryLabels = [
                'Kucing' => 'Kucing',
                'Anjing' => 'Anjing',
                'hewan-lain' => 'Hewan Lain',
                'kebutuhan-hewan' => 'Kebutuhan Hewan'
            ];
        @endphp

        @foreach ($categories as $cat)
            <button class="btn rounded-pill px-4 fw-semibold btn-filter btn-light" data-kategori="{{ $cat }}">
                {{ $categoryLabels[$cat] }}
            </button>
        @endforeach
    </div>

    {{-- Container untuk list hewan/kebutuhan --}}
    <div class="row mx-3 justify-content-center" id="pet-list">
        <!-- Kartu akan dirender oleh JS -->
    </div>
</div>

<script>
    var petData = @json($petjual->values());
    var pkhData = @json($pkh->values());  // kebutuhan hewan
    const petDetailRoute = "{{ url('/pet') }}"; 
    const productDetailRoute = "{{ url('/product') }}"; 

    $(document).ready(function(){

        function renderPets(pets) {
            let html = '';
            if(pets.length === 0){
                html = '<p class="text-center text-white">Tidak ada hewan untuk kategori ini.</p>';
            } else {
                pets.forEach(function(item){
                    // pastikan item.penjualan ada dan tidak kosong untuk harga
                    let hargaHtml = '';
                    if(item.penjualan && item.penjualan.length > 0){
                        item.penjualan.forEach(function(jual){
                            hargaHtml += `<p class="fw-bold fs-5 mb-1">Rp. ${jual.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>`;
                        });
                    }
                    html += `
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
                            <img src="/pets_img/${item.foto}" class="card-img-top" alt="${item.nama_pet}" style="height: 300px; object-fit: cover;">
                            <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
                                <div class="mb-3">
                                    <h3 class="card-title sniglet-extrabold text-dark-color mb-2">${item.nama_pet}</h3>
                                    <p class="card-text fw-semibold mb-2">${item.ras} - ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</p>
                                    <p class="fw-semibold text-white mb-3" style="min-height: 60px;">
                                        ${item.deskripsi ? item.deskripsi.substring(0, 100) + (item.deskripsi.length > 100 ? '...' : '') : ''}
                                    </p>
                                    <div class="mb-3">
                                        ${hargaHtml}
                                    </div>
                                </div>
                                <a href="${petDetailRoute}/${item.id}" class="btn dark-color text-white rounded-pill mt-auto py-2">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                });
            }
            $('#pet-list').fadeOut(200, function () {
                $('#pet-list').html(html).fadeIn(200);
            });
        }

        function renderKebutuhan(data) {
            let html = '';
            if(data.length === 0){
                html = '<p class="text-center text-white">Tidak ada kebutuhan hewan untuk kategori ini.</p>';
            } else {
                data.forEach(function(item){
                    html += `
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
                            <img src="/pkh_img/${item.foto}" class="card-img-top" alt="${item.nama}" style="height: 300px; object-fit: cover;">
                            <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
                                <div class="mb-3">
                                    <h3 class="card-title sniglet-extrabold text-dark-color mb-2">${item.nama}</h3>
                                    <div class="mb-3">
                                        <p class="fw-bold fs-5 mb-1">Rp. ${item.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                                    </div>
                                </div>
                                <a href="${productDetailRoute}/${item.id}" class="btn dark-color text-white rounded-pill mt-auto py-2">
                                    Detail
                                </a>
                                <a href="#" class="btn btn-success rounded-pill mt-2 add-to-cart-btn py-2" data-id="${item.id}">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                });
            }
            $('#pet-list').fadeOut(200, function () {
                $('#pet-list').html(html).fadeIn(200);
            });
            
        }
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        console.log("Button clicked"); // Debug line

        const itemId = $(this).data('id');

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                id_pkh: itemId, // ← match your DB field here
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart!',
                    text: response.message,
                    toast: true,
                    timer: 2000,
                    position: 'top-end',
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: xhr.responseJSON.message || 'Something went wrong.',
                });
            }
        });

    });


        // Set default kategori aktif dan render default
        $('.btn-filter').removeClass('btn-dark text-white').addClass('btn-light');
        $('.btn-filter[data-kategori="Kucing"]').removeClass('btn-light').addClass('btn-dark text-white');
        renderPets(petData.filter(p => p.jenis === 'Kucing'));

        // Event klik filter kategori
        $('.btn-filter').click(function(){
            $('.btn-filter').removeClass('btn-dark text-white').addClass('btn-light');
            $(this).removeClass('btn-light').addClass('btn-dark text-white');

            let kategori = $(this).data('kategori');
            if(kategori === 'kebutuhan-hewan'){
                renderKebutuhan(pkhData);
            }  else if(kategori === 'hewan-lain'){
                renderPets(petData.filter(p => p.jenis !== 'Kucing' && p.jenis !== 'Anjing'));
            } else {
                renderPets(petData.filter(p => p.jenis === kategori));
            }
        });

    });
</script>

@endsection
