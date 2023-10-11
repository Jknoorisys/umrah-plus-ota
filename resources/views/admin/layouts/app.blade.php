<!doctype html>
<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--favicon-->
		<link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
		<!--plugins-->
		{{-- <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" /> --}}
		<link rel="stylesheet" href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}">

		<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
		<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
		<!-- loader-->
		<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
		<script src="{{ asset('assets/js/pace.min.js') }}"></script>
		<!-- Bootstrap CSS -->
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
		{{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> --}}
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
		<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
		<!-- Theme Style CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
		<title>OTA</title>
	</head>

	<body>
		<!--wrapper-->
		<div class="wrapper">

			<!--sidebar wrapper -->
			@include('admin.layouts.partials.sidebar')
			<!--end sidebar wrapper -->

			<!--start header -->
			@include('admin.layouts.partials.header')
			<!--end header -->

			<!--start page wrapper -->
			<div class="page-wrapper">
				<div class="page-content">
					@yield('content')
				</div>
			</div>
			<!--end page wrapper -->

			<!--start overlay-->
			<div class="overlay toggle-icon"></div>
			<!--end overlay-->

			<!--Start Back To Top Button--> 
			<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
			<!--End Back To Top Button-->

			<!--start footer-->
			@include('admin.layouts.partials.footer')
			<!--End footer-->

		</div>
		<!--end wrapper-->

		<!--start switcher-->
		@include('admin.layouts.partials.switcher')
		<!--end switcher-->

		<!-- Bootstrap JS -->
		<script src="{{ asset('assets/js/bootstrap.bundle.min.j') }}s"></script>
		<!--plugins-->
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
		<!--app JS-->
		<script src="{{ asset('assets/js/app.js') }}"></script>

		<!--start javascript-->
		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		</script>
		@yield('customJs')
		<!--end javascript-->

	</body>

</html>