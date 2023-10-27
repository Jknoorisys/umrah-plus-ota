
<!DOCTYPE html>
<html lang="en" id="htmlTag">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>
        OTA
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />

    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/file-upload.css') }}">
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.time.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    {{-- <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script> --}}
    <style>
        .error {
            font-size: 12px;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-200" id="bodyTag">
    <!-- Sidebar -->
    @include('admin.layouts.partials.sidebar')
    <!-- End Sidebar -->
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @include('admin.layouts.partials.header')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        {{-- @if (session('success'))
            <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" id="successToast" aria-atomic="true">
                <div class="toast-header border-0">
                    <i class="material-icons text-success me-2">
                    check
                    </i>
                    <span class="me-auto font-weight-bold">{{ trans('msg.admin.Success') }}</span>
                    <small class="text-body">{{ now()->format('Y-m-d H:i:s') }}</small>
                    <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
                </div>
                <hr class="horizontal dark m-0">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
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

        <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" id="successToast" aria-atomic="true" class="display:none;">
            <div class="toast-header border-0">
                <i class="material-icons text-success me-2">
                check
                </i>
                <span class="me-auto font-weight-bold">{{ trans('msg.admin.Success') }}</span>
                <small class="text-body">{{ now()->format('Y-m-d H:i:s') }}</small>
                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <hr class="horizontal dark m-0">
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>

        @yield('content')

        <!-- Footer -->
        @include('admin.layouts.partials.footer')
        <!-- End Footer -->
    </div>
  </main>

  <!-- Switcher -->
  {{-- @include('admin.layouts.partials.switcher') --}}
  <!-- End Switcher -->

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    {{-- datatable --}}
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/legacy.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/picker.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/picker.time.js') }}"></script>
    <script src="{{ asset('assets/plugins/datetimepicker/js/picker.date.js') }}"></script>

    <!--notification js -->
    <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/notification-custom-script.js') }}"></script>

  
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: true,
            format: 'yyyy-mm-dd',
            min: new Date(),
        })

        $('.timepicker').pickatime()

        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        function toggleTheme() {
            const htmlElement = document.getElementsByTagName('html')[0];
            const sunIcon = document.getElementById('sun-icon');

            let newTheme;
            if (htmlElement.classList.contains('light-theme')) {
                htmlElement.classList.remove('light-theme');
                htmlElement.classList.add('dark-theme');
                sunIcon.classList.remove('bxs-moon');
                sunIcon.classList.add('bxs-sun');
                newTheme = 'dark-theme';
            } else {
                htmlElement.classList.remove('dark-theme');
                htmlElement.classList.add('light-theme');
                sunIcon.classList.remove('bxs-sun');
                sunIcon.classList.add('bxs-moon');
                newTheme = 'light-theme';
            }

            document.cookie = `theme=${newTheme};path=/`;
        }

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
                ordering: false,
                lengthChange: false,
                buttons: [ 'excel', 'pdf', 'print']
            } );
        
            table.buttons().container()
                .appendTo( '#otaDataTable_wrapper .col-md-6:eq(0)' );
                var placeholderText = '{{ trans("msg.admin.Search") }}';
    
                // Find the search input element and set the new placeholder
                var searchInput = $('div.dataTables_wrapper input[type="search"]');
                searchInput.attr('placeholder', placeholderText);
        } );
        
    </script>

    @yield('customJs')
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.1.0') }}"></script>
</body>

</html>