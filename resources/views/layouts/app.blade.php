
<!DOCTYPE html>
<html lang="en">
  	
<!-- Mirrored from etikto-admin-dashboard.multipurposethemes.com/bs5/main/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Jun 2024 03:24:06 GMT -->
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
        <link rel="icon" href="{{ url('') }}/assets/images/LogoBBN.png">
		<title>{{ config('app.name') }}</title>
		
		@include('includes.main-css')
        @yield('css-library')
        @yield('css-custom')

  	</head>

	<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
		
		<div class="wrapper">
		  	<div id="loader"></div>
		  	<header class="main-header">
				@include('layouts.header')
		  	</header>
		  
		  	<aside class="main-sidebar">
				<!-- sidebar-->
				@include('layouts.sidebar')
                <!-- End sidebar-->
		  	</aside>

		  	<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
                @yield('content')
			</div>
		  	<!-- /.content-wrapper -->
            
            <!-- /.Footer -->
            @include('layouts.footer')
            <!-- /.End Footer -->

		  	<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
		  	<div class="control-sidebar-bg"></div>
		</div>
		<!-- ./wrapper -->
		
		
		@include('includes.main-js')
		@yield('js-library')
        @yield('js-custom')

	</body>

<!-- Mirrored from etikto-admin-dashboard.multipurposethemes.com/bs5/main/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Jun 2024 03:25:17 GMT -->
</html>
