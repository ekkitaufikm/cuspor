<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ url('') }}/assets/images/LogoBBN.png">

    <title>Login || {{ config('app.name') }} </title>
  
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
										@if ($errors->any())
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<strong>Error!</strong>
												@foreach ($errors->all() as $error)
													{{ $error }}
												@endforeach
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										@endif
									</div>
									<div class="form-group">
										<label class="form-label">User ID</label>
										<input name="username" type="text" class="form-control ps-15 bg-transparent" placeholder="User ID" required>
									</div>
									<div class="form-group">
										<label class="form-label">Password</label>
										<input name="password" type="password" class="form-control ps-15 bg-transparent" placeholder="Password" required>
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

</body>
</html>
