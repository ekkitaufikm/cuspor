<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ url('') }}/assets/images/LogoBBN.png">

    <title>Login || PT. Bukit Baja Nusantara </title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ url('') }}/assets/css/vendors_css.css">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{ url('') }}/assets/css/style.css">
	<link rel="stylesheet" href="{{ url('') }}/assets/css/skin_color.css">	

</head>
	
<body class="hold-transition theme-primary bg-img" style="background-image: url({{ url('') }}/assets/images/auth-bg/bg-1.jpg)">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
			<div class="col-12">
				<div class="row justify-content-end g-0">
					<div class="col-lg-7 col-md-7 col-12 bg-white rounded10 shadow-lg">
						<div class="d-flex align-items-center p-3">
							<img src="{{ url('') }}/assets/images/LogoBBN.png" width="10%" class="me-3">
							<h2 class="mb-0" style="color: rgba(11,81,166,1) !important; font-weight: bold;">Customer Portal</h2>
						</div>
						<img src="{{ url('') }}/assets/images/background.png">
					</div>
					<div class="col-lg-5 col-md-5 col-12 d-flex justify-content-end">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">Welcome!<br>
									BBN CUSTOMER PORTAL</h2>
								<p class="mb-0">Please sign-in to your account and start the jobs.</p>							
							</div>
							<div class="p-40">
								<form action="{{ route('login') }}" method="post">
									@csrf
									<div class="form-group">
										@if (session('gagal'))
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<strong>Error!</strong> {{ session('gagal') }}
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										@endif
									</div>
									<div class="form-group">
										<label class="form-label">User ID</label>
										<input name="username" type="text" class="form-control ps-15 bg-transparent" placeholder="User ID">
									</div>
									<div class="form-group">
										<label class="form-label">Password</label>
										<div class="input-group">
											<input name="password" type="password" class="form-control ps-15 bg-transparent" placeholder="Password">
											<div class="input-group-append" id="togglePassword">
												<span class="input-group-text cursor-pointer">
													<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
														<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
														<circle cx="12" cy="12" r="3"></circle>
													</svg>
												</span>
											</div>
										</div>
									</div>
									<div class="mb-2">
										<div class="form-group mt-2 mb-2">
											<div class="captcha">
												<span>{!! captcha_img() !!}</span><br>
												<a href="#" id="reload">Refresh Captcha</a>
												{{-- <button type="button" class="btn btn-danger reload" id="reload">
													&#x21bb;
												</button> --}}
											</div>
										</div>
										<div class="form-group mb-2">
											<input type="text" class="form-control"  name="captcha" placeholder="Input Captcha" required>
										</div>
									</div>
	
									<div class="row">
										<!-- /.col -->
										  <button type="submit" class="btn btn-primary mt-10">SIGN IN</button>
										<!-- /.col -->
									</div>
								</form>	
							</div>						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Vendor JS -->
	<script src="{{ url('') }}/assets/js/vendors.min.js"></script>
	<script src="{{ url('') }}/assets/js/pages/chat-popup.js"></script>
    <script src="{{ url('') }}/assets/icons/feather-icons/feather.min.js"></script>	

	<script>
		document.getElementById('togglePassword').addEventListener('click', function () {
			var passwordField = document.getElementById('password');
			var passwordFieldType = passwordField.getAttribute('type');
			var toggleIcon = this.querySelector('svg');
			
			if (passwordFieldType === 'password') {
				passwordField.setAttribute('type', 'text');
				toggleIcon.classList.remove('feather-eye');
				toggleIcon.classList.add('feather-eye-off');
			} else {
				passwordField.setAttribute('type', 'password');
				toggleIcon.classList.remove('feather-eye-off');
				toggleIcon.classList.add('feather-eye');
			}
		});

		$('#reload').click(function(){
			$.ajax({
				type:'GET',
				url:'reload-captcha',
				success:function(data){
					$(".captcha span").html(data.captcha)
				}
			});
		});
	</script>
</body>
</html>
