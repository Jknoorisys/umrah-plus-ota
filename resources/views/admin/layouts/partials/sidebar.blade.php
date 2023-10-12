<div class="sidebar-wrapper" data-simplebar="true">

    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">OTA</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">{{ trans('msg.admin.Dashboard') }}</div>
            </a>
        </li>

        <li class="menu-label">Manage Users</li>
        <li>
            <a href="{{ route('/') }}">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Users</div>
            </a>
        </li>

    </ul>
    <!--end navigation-->
</div>