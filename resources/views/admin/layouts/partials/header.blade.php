<nav class="navbar navbar-main navbar-expand-lg navbar-light bg-white position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        @if (isset($title) && $title != 'no_breadcrumb')
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm">
                    <a class="opacity-3 text-dark" href="{{ route('dashboard') }}">
                        <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>shop </title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(0.000000, 148.000000)">
                                <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                </g>
                            </g>
                            </g>
                        </g>
                        </svg>
                    </a>
                    </li>
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ isset($url) && !empty($url) ? $url : route('home') }}">{{ isset($previous_title) && !empty($previous_title) ? $previous_title : '' }}</a></li>
                    <li class="breadcrumb-item text-sm text-dark font-weight-bolder active" aria-current="page">{{ isset($title) && !empty($title) ? $title : '' }}</li>
                </ol>
            </nav>
		@endif
      
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                  <label class="form-label">{{ trans('msg.admin.Search here') }}</label>
                  <input type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                </div>
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown pe-2 d-none" onclick="toggleLanguage()" style="cursor: pointer;">
                    <span class="material-icons" id="languageToggle">translate</span>
                    <span id="languageName">Eng</span>
                </li>

                <li class="nav-item d-xl-none px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                      <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                      </div>
                    </a>
                </li>

                <li class="nav-item dropdown pe-2 d-none">
                    <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons cursor-pointer">account_circle</i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('profile') }}">
                            <div class="d-flex align-items-center py-1">
                                <div class="my-auto">
                                    <span class="material-icons">
                                        person
                                    </span>
                                </div>
                                <div class="ms-2">
                                    <h6 class="text-sm font-weight-normal mb-0">
                                        {{ trans('msg.admin.Profile') }}
                                    </h6>
                                </div>
                            </div>
                            </a>
                        </li>
                        {{-- <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('settings') }}">
                            <div class="d-flex align-items-center py-1">
                                <div class="my-auto">
                                <span class="material-icons">
                                    settings
                                </span>
                                </div>
                                <div class="ms-2">
                                    <h6 class="text-sm font-weight-normal mb-0">
                                        {{ trans('msg.admin.Settings') }}
                                    </h6>
                                </div>
                            </div>
                            </a>
                        </li> --}}
                        <li>
                            <a class="dropdown-item border-radius-md" href="{{ route('logout') }}">
                            <div class="d-flex align-items-center py-1">
                                <div class="my-auto">
                                <span class="material-icons">
                                    logout
                                </span>
                                </div>
                                <div class="ms-2">
                                    <h6 class="text-sm font-weight-normal mb-0">
                                        {{ trans('msg.admin.Logout') }}
                                    </h6>
                                </div>
                            </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown pe-2" style="cursor: pointer;">
                    <a href="{{ route('profile') }}" class="text-secondary"><span class="material-icons">account_circle</span></a>
                </li>

                <li class="nav-item dropdown pe-2" style="cursor: pointer;">
                    <a href="{{ route('logout') }}" class="text-secondary"><span class="material-icons">logout</span></a>
                </li>

                @if(Auth::guard('admin')->check())
                    <li class="nav-item dropdown pe-2">
                        <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons cursor-pointer">notifications</i>
                            <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
                                <span class="small">{{ Auth::guard('admin')->user()->unreadNotifications->count() }}</span>
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            @if (Auth::guard('admin')->user()->unreadNotifications->count() > 0)
                                <a href="{{ route('mark-all-read') }}" rel="noopener noreferrer" class="text-info"><i class="material-icons cursor-pointer">mark_email_read</i></a>
                            @endif
                            {{-- <a href="{{ route('mark-all-read') }}" rel="noopener noreferrer" class="text-info"><i class="material-icons cursor-pointer">mark_email_read</i></a> --}}
                            @forelse(Auth::guard('admin')->user()->unreadNotifications as $notification)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                      <div class="d-flex py-1">
                                        <div class="my-auto">
                                          <img src="{{$notification->data['profile'] ? asset($notification->data['profile']) : asset('assets/img/team-2.jpg') }}" class="avatar avatar-sm  me-3 ">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                {{ $notification->data['message'] }}
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                      </div>
                                    </a>
                                </li>
                            @empty
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('assets/img/notification.jpg') }}" alt="notification" width="75px" height="75px">
                                </div>                            
                            @endforelse
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

<script>
    function toggleLanguage() {
        var currentLang = "{{ session('locale') }}";
        if (currentLang === "en") {
            window.location.href = "{{ url('setlocale/ar') }}";
        } else {
            window.location.href = "{{ url('setlocale/en') }}";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
            var currentLang = "{{ session('locale') }}";
            var htmlTag = document.getElementById('htmlTag');
            var bodyTag = document.getElementById('bodyTag');
            var sidenavMain = document.getElementById('sidenav-main');
            // var dashboard = document.getElementById('dashboard-text');
            if (currentLang === "ar") {
                document.getElementById('languageName').innerText = "العربية";
                bodyTag.classList.add('rtl');
                bodyTag.classList.remove('ltr');
                bodyTag.classList.add('bg-gray-200');
                bodyTag.classList.remove('bg-white');
                sidenavMain.classList.add('fixed-end');
                sidenavMain.classList.remove('fixed-start');
                // dashboard.classList.add('text-start');
                // dashboard.classList.remove('text-end');
                htmlTag.setAttribute('dir', 'rtl');
            } else {
                bodyTag.classList.add('ltr');
                bodyTag.classList.remove('rtl');
                bodyTag.classList.add('bg-white');
                bodyTag.classList.remove('bg-gray-200');
                sidenavMain.classList.add('fixed-start');
                sidenavMain.classList.remove('fixed-end');
                // dashboard.classList.add('text-end');
                // dashboard.classList.remove('text-start');
                htmlTag.setAttribute('dir', 'ltr');
            }
        });
</script>
