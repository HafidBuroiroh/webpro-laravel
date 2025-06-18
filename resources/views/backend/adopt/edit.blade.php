@extends('backend.layout')
@section('title', 'Edit Adopsi')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('admin/adopt/'. $adopt->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('backend.pet.form', ['pet' => $adopt->adoptpet])

                <div class="mb-3">
                    <label for="harga_adopsi" class="form-label">Harga Adopsi</label>
                    <input type="number" name="harga_adopsi" class="form-control" value="{{ $adopt->harga_adopsi }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
