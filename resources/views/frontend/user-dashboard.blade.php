@extends('frontend.layout')

@section('title', 'User Dashboard')

@section('content')
<div class="container py-5">
    <h1 class="text-center text-white mb-4">User Dashboard</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-4" style="background-color: #393E46; color: white;">
                <h4 class="mb-4">Welcome, {{ $user->name }}</h4>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item bg-transparent text-white"><strong>Name:</strong> {{ $user->name }}</li>
                    <li class="list-group-item bg-transparent text-white"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item bg-transparent text-white"><strong>Address:</strong> {{ $user->alamat ?? 'Not set yet' }}</li>
                    <li class="list-group-item bg-transparent text-white"><strong>Phone:</strong> {{ $user->no_telp ?? 'Not set yet' }}</li>
                </ul>

                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                    <button class="btn btn-warning rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#editPasswordModal">Edit Password</button>
                    <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#editAddressModal">Edit Address</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('user.update.profile') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-content" style="background-color: #393E46; color: white;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" name="name" id="editName" class="form-control" value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="editNoTelp" class="form-label">Phone</label>
                        <input type="text" name="no_telp" id="editNoTelp" class="form-control" value="{{ $user->no_telp }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Password --}}
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('user.updatePassword') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Edit Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Address --}}
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('user.updateAddress') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="alamat" class="form-label">Full Address</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ $user->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="post_code" class="form-label">Post Code</label>
                    <input type="text" name="post_code" class="form-control" value="{{ $user->detailaddress->first()->post_code ?? '' }}">
                </div>

                {{-- Province --}}
                <div class="mb-3">
                    <label for="province" class="form-label">Province</label>
                    <select name="province_code" id="province" class="form-select">
                        <option value="">-- Select Province --</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->code }}" {{ old('province_code', $user->province_code) == $province->code ? 'selected' : '' }}>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- City --}}
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <select name="city_code" id="city" class="form-select">
                        <option value="">-- Select City --</option>
                    </select>
                </div>

                {{-- District --}}
                <div class="mb-3">
                    <label for="district" class="form-label">District</label>
                    <select name="district_code" id="district" class="form-select">
                        <option value="">-- Select District --</option>
                    </select>
                </div>

                {{-- Village --}}
                <div class="mb-3">
                    <label for="village" class="form-label">Village (Optional)</label>
                    <select name="village_code" id="village" class="form-select">
                        <option value="">-- Select Village --</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Address</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#province').change(function () {
        var provinceID = $(this).val();
        if (provinceID) {
            $.ajax({
                url: '/get-cities/' + provinceID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#city').empty().append('<option value="">-- Select City --</option>');
                    $.each(data, function (key, value) {
                        $('#city').append('<option value="' + value.code + '">' + value.name + '</option>');
                    });
                    $('#district').empty().append('<option value="">-- Select District --</option>');
                    $('#village').empty().append('<option value="">-- Select Village --</option>');
                }
            });
        } else {
            $('#city').empty().append('<option value="">-- Select City --</option>');
            $('#district').empty().append('<option value="">-- Select District --</option>');
            $('#village').empty().append('<option value="">-- Select Village --</option>');
        }
    });

    $('#city').change(function () {
        var cityID = $(this).val();
        if (cityID) {
            $.ajax({
                url: '/get-districts/' + cityID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#district').empty().append('<option value="">-- Select District --</option>');
                    $.each(data, function (key, value) {
                        $('#district').append('<option value="' + value.code + '">' + value.name + '</option>');
                    });
                    $('#village').empty().append('<option value="">-- Select Village --</option>');
                }
            });
        } else {
            $('#district').empty().append('<option value="">-- Select District --</option>');
            $('#village').empty().append('<option value="">-- Select Village --</option>');
        }
    });

    $('#district').change(function () {
        var districtID = $(this).val();
        if (districtID) {
            $.ajax({
                url: '/get-villages/' + districtID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#village').empty().append('<option value="">-- Select Village --</option>');
                    $.each(data, function (key, value) {
                        $('#village').append('<option value="' + value.code + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#village').empty().append('<option value="">-- Select Village --</option>');
        }
    });
</script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif
@endsection
