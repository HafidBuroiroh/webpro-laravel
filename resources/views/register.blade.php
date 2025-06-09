<!DOCTYPE html>
<html lang="en">
<head>
	<title>Petter - Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{asset('logo-cut.png')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/main.css')}}">
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
</style>
<body style="background-color: #222831;">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="{{url('postregister')}}" method="POST">
					@csrf
					<span class="login100-form-title p-b-43 text-white">
						Create Your Account
					</span>

					<div class="wrap-input100 validate-input" data-validate="Name is required">
						<input class="input100" type="text" name="name" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Full Name</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="email" name="email" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Address is required">
						<input class="input100" type="text" name="alamat" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Address</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Phone number is required">
						<input class="input100" type="text" name="no_telp" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Phone Number</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password confirmation is required">
						<input class="input100" type="password" name="password_confirmation" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Confirm Password</span>
					</div>
					
					<div class="container-login100-form-btn">
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
					<div class="mx-3 my-3">
						<a href="{{ url()->previous() }}" class="btn btn-outline-danger border-0 text-decoration-none" style="background: none; color: #dc3545; transition: none; pointer-events: auto;">
							<h2 style="margin: 0;"><i class="bi bi-arrow-left"></i></h2>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="{{asset('login_page/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('login_page/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{asset('login_page/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('login_page/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('login_page/vendor/select2/select2.min.js')}}"></script>
	<script src="{{asset('login_page/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('login_page/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{asset('login_page/vendor/countdowntime/countdowntime.js')}}"></script>
	<script src="{{asset('login_page/js/main.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
