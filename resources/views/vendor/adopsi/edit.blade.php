@extends('backend.layout')
@section('title', 'Edit Adopsi')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('vendor/adopt/'. $adopt->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
               <div class="mb-3">
                    <label for="nama_pet" class="form-label">Nama Pet</label>
                    <input type="text" value="{{$pets->nama_pet}}" name="nama_pet" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Anjing" {{$pets->jenis == 'Anjing' ? 'selected' : ''}}>Anjing</option>
                        <option value="Kucing" {{$pets->jenis == 'Kucing' ? 'selected' : ''}}>Kucing</option>
                        <option value="Hewan Lainnya" {{$pets->jenis == 'Hewan Lainnya' ? 'selected' : ''}}>Hewan Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ras" class="form-label">Ras</label>
                    <input type="text" value="{{$pets->ras}}" name="ras" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="umur" class="form-label">Umur</label>
                    <input type="number" value="{{$pets->umur}}" name="umur" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto (kosongkan jika tidak diganti)</label><br>
                    <img src="{{ asset('pets_img/' . $pets->foto) }}" width="150" class="mb-2">
                    <input type="file" name="foto" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"  class="form-control" rows="3" required>{{$pets->deskripsi}}</textarea>
                </div>

                <div class="mb-3">
                    <label for="harga_adopsi" class="form-label">Harga Adopsi</label>
                    <input type="number" value="{{$adopt->harga_adopsi}}" name="harga_adopsi" class="form-control" value="{{ $adopt->harga_adopsi }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
