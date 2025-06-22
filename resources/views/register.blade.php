<!DOCTYPE html>
<html lang="en">

<head>
    <title>Petter - Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo-cut.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_page/css/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<style>
    a.btn.btn-outline-danger:hover {
        background-color: transparent !important;
        color: #dc3545 !important;
        border-color: transparent !important;
        box-shadow: none !important;
        text-decoration: none !important;
    }
    .input100 {
        color: #ffffff !important;
    }

    .input100::placeholder {
        color: #cccccc !important;
    }

    .input100:focus {
        color: #ffffff !important;
    }
</style>

<body style="background-color: #222831;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form id="registerForm" class="login100-form validate-form" action="{{ url('/postregister') }}" method="POST" novalidate>
                    @csrf
                    <span class="login100-form-title p-b-43 text-white">
                        Create Your Account
                    </span>

                    <!-- Data Diri -->
                    <div class="wrap-input100 validate-input mb-3">
                        <input class="input100" type="text" name="name" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Full Name</span>
                    </div>
                    <div class="invalid-feedback py-3">Full Name is required.</div>

                    <div class="wrap-input100 validate-input mb-3">
                        <input class="input100" type="email" name="email" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Email</span>
                    </div>
                    <div class="invalid-feedback py-3">Valid Email is required.</div>

                    <div class="wrap-input100 validate-input mb-3">
                        <input class="input100" type="text" name="no_telp" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Phone Number</span>
                    </div>
                    <div class="invalid-feedback py-3">Phone Number is required (minimum 8 digits).</div>

                    <div class="wrap-input100 validate-input mb-3">
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>
                    <div class="invalid-feedback py-3">Password is required (minimum 6 characters).</div>

                    <div class="wrap-input100 validate-input mb-3">
                        <input class="input100" type="password" name="password_confirmation" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Confirm Password</span>
                    </div>
                    <div class="invalid-feedback py-3">Password confirmation does not match.</div>

                    <!-- Detail Address -->
                    <span class="login100-form-title p-b-20 text-white mt-4">Detail Address</span>

                    <div class="wrap-input100 validate-input mb-3">
                        <input class="input100" type="text" name="alamat" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Full Address</span>
                    </div>
                    <div class="invalid-feedback py-3">Full Address is required.</div>

                    <div class="wrap-input100 mb-3">
                        <input class="input100" type="number" name="post_code">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Post Code</span>
                    </div>

                    <div class="mb-3">
                        <label for="province" class="form-label text-white">Province</label>
                        <select name="province_id" id="province" class="form-select" required>
                            <option value="">-- Select Province --</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->code }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="invalid-feedback py-3">Province is required.</div>

                    <div class="mb-3">
                        <label for="city" class="form-label text-white">City</label>
                        <select name="city_id" id="city" class="form-select" required>
                            <option value="">-- Select City --</option>
                        </select>
                    </div>
                    <div class="invalid-feedback py-3">City is required.</div>

                    <div class="mb-3">
                        <label for="district" class="form-label text-white">District</label>
                        <select name="district_id" id="district" class="form-select" required>
                            <option value="">-- Select District --</option>
                        </select>
                    </div>
                    <div class="invalid-feedback py-3">District is required.</div>

                    <div class="mb-3">
                        <label for="village" class="form-label text-white">Village (Optional)</label>
                        <select name="village_id" id="village" class="form-select">
                            <option value="">-- Select Village --</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="container-login100-form-btn mt-4">
                        <button type="submit" class="login100-form-btn">
                            Register
                        </button>
                    </div>

                    <div class="text-center my-2">
                        <span style="color: #ffffff;">Already have an account?</span>
                        <a href="/login" style="color: #7a54c0; font-weight: 600; text-decoration: none; font-size: 1rem; transition: color 0.3s ease;">
                            Login Here
                        </a>
                    </div>
                </form>

                <div class="login100-more" style="background-image: url('/login_background.jpg');">
                    <div class="mx-3 py-3">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-danger border-0 text-decoration-none" style="background: none; color: #dc3545; transition: none; pointer-events: auto;">
                            <h2 style="margin: 0;"><i class="bi bi-arrow-left"></i></h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('login_page/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('login_page/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('login_page/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('login_page/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('login_page/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('login_page/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('login_page/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('login_page/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('login_page/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Dependent Dropdown -->
    <script>
        // Get Cities
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

        // Get Districts
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

        // Get Villages
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

    <!-- Validation -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            let form = this;
            let isValid = true;

            // Loop through all required inputs
            form.querySelectorAll('input[required], select[required]').forEach(function (input) {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Additional validation
            let email = form.querySelector('input[name="email"]');
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value && !emailRegex.test(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            }

            let phone = form.querySelector('input[name="no_telp"]');
            if (phone.value && !/^[0-9]{8,}$/.test(phone.value)) {
                phone.classList.add('is-invalid');
                isValid = false;
            }

            let password = form.querySelector('input[name="password"]');
            if (password.value.length < 6) {
                password.classList.add('is-invalid');
                isValid = false;
            }

            let confirmPassword = form.querySelector('input[name="password_confirmation"]');
            if (confirmPassword.value !== password.value) {
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
