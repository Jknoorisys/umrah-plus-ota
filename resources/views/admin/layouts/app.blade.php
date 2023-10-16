<!doctype html>
<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--favicon-->
		<link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
		<!--plugins-->
		<link rel="stylesheet" href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}">
		<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
		<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
		<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
		<!-- loader-->
		<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
		<script src="{{ asset('assets/js/pace.min.js') }}"></script>
		<!-- Bootstrap CSS -->
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
		{{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> --}}
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
		<!-- Theme Style CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
		<title>OTA</title>

		<style>
			.btn-group-sm>.btn, .btn-sm {
				padding: 0.1rem 0.3rem;
				font-size: .8rem;
				border-radius: 0.2rem;
			}		
		</style>
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
					@if (isset($title) && $title != 'no_breadcrumb')
						<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb mb-0 p-2">
									<li class="breadcrumb-item" style="font-size: 14px;"><a href="{{ isset($url) && !empty($url) ? $url : route('home') }}">{{ isset($previous_title) && !empty($previous_title) ? $previous_title : '' }}</a></li>
									<li class="breadcrumb-item active" aria-current="page" style="font-size: 14px;">{{ isset($title) && !empty($title) ? $title : '' }}</li>
								</ol>
							</nav>							
						</div>
					@endif

					{{-- @if (session('error'))
						<div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
							<div class="d-flex align-items-center">
								<div class="font-25 text-danger"><i class='bx bxs-message-square-x'></i></div>
								<div class="ms-2">
									<!-- <h6 class="mb-0 text-danger">Danger Alerts</h6> -->
									<div class="text-danger">{{ session('error') }}</div>
								</div>
							</div>
							<button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endif

					@if (session('success'))
						<div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
							<div class="d-flex align-items-center">
								<div class="font-25 text-success"><i class='bx bxs-check-circle'></i></div>
								<div class="ms-2">
									<!-- <h6 class="mb-0 text-success">Success Alerts</h6> -->
									<div class="text-success">{{ session('success') }}</div>
								</div>
							</div>
							<button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endif --}}
					
					@if(session('success'))
						<div id="successMessage" data-success="{{ session('success') }}"></div>
					@endif

					@if(session('warning'))
						<div id="warningMessage" data-warning="{{ session('warning') }}"></div>
					@endif

					@if(session('error'))
						<div id="errorMessage" data-error="{{ session('error') }}"></div>
					@endif

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
		<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
		<!--notification js -->
		<script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
		<!--app JS-->
		<script src="{{ asset('assets/js/app.js') }}"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		
		<!--start javascript-->
		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('.single-select').select2({
				theme: 'bootstrap4',
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
				placeholder: $(this).data('placeholder'),
				allowClear: Boolean($(this).data('allow-clear')),
			});

			document.addEventListener('DOMContentLoaded', function() {
				var successMessageElement = document.getElementById('successMessage');
            	var warningMessageElement = document.getElementById('warningMessage');
            	var errorMessageElement = document.getElementById('errorMessage');
				if (successMessageElement) {
					var successMessage = successMessageElement.dataset.success;
					pos5_success_noti(successMessage);
				} else if (warningMessageElement) {
					var warningMessage = warningMessageElement.dataset.warning;
					pos3_warning_noti(warningMessage);
				} else if (errorMessageElement) {
					var errorMessage = errorMessageElement.dataset.error;
					pos4_error_noti(errorMessage);
				}
			});

			$(document).ready(function() {
				var table = $('#otaDataTable').DataTable( {
					lengthChange: false,
					buttons: [ 'excel', 'pdf', 'print']
				} );
			
				table.buttons().container()
					.appendTo( '#otaDataTable_wrapper .col-md-6:eq(0)' );
			} );
		</script>
		@yield('customJs')
		<!--end javascript-->

	</body>

</html>