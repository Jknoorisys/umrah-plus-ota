<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white" style="font-size: 20px;">O T A</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        {{-- Dashboard --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('dashboard*')) ? 'active bg-gradient-info' : '' }}" href="{{ route('dashboard') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Dashboard') }}</span>
          </a>
        </li>

        {{-- Manage Users --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('user/list')) ? 'active bg-gradient-info' : '' }}" href="{{ route('user.list') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">group</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Users') }}</span>
          </a>
        </li>

        {{-- Manage Sub Admins --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('sub-admin*')) ? 'active bg-gradient-info' : '' }}" href="{{ route('sub-admin.list') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">manage_accounts</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Sub Admins') }}</span>
          </a>
        </li>

        {{-- Manage Roles --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('role*')) ? 'active bg-gradient-info' : '' }}" href="{{ route('role.list') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">settings_applications</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Roles') }}</span>
          </a>
        </li>

        {{-- Manage Promo Codes --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('promo-code*')) ? 'active bg-gradient-info' : '' }}" href="{{ route('promo-code.list') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">price_change</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Promo Codes') }}</span>
          </a>
        </li>

        {{-- Manage Markups --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('markup*')) ? 'active bg-gradient-info' : '' }}" href="{{ route('markup.list') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">account_balance_wallet</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Markups') }}</span>
          </a>
        </li>

        {{-- Send Norification To All Users --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('user/send-notification')) ? 'active bg-gradient-info' : '' }}" href="{{ route('user.send-notification-form') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">send</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Send Notification') }}</span>
          </a>
        </li>

        {{-- Manage Visa Countries --}}
        <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('visa-country*')) ? 'active bg-gradient-info' : '' }}" href="{{ route('visa-country.list') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">flag</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Visa Countries') }}</span>
          </a>
        </li>

        {{-- Manage Visa Types --}}
        {{-- <li class="nav-item">
          <a class="nav-link text-white {{ (request()->is('visa-type*')) ? 'active bg-gradient-info' : '' }}" href="{{ route('visa-type.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">flag</i>
            </div>
            <span class="nav-link-text ms-1">{{ trans('msg.admin.Visa Types') }}</span>
          </a>
        </li> --}}

        {{-- <li class="nav-item">
          <a class="nav-link text-white " href="pages/rtl.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
            </div>
            <span class="nav-link-text ms-1">RTL</span>
          </a>
        </li> --}}

        {{-- <li class="nav-item">
          <a class="nav-link text-white " href="pages/notifications.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">notifications</i>
            </div>
            <span class="nav-link-text ms-1">Notifications</span>
          </a>
        </li> --}}

        {{-- <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li> --}}

        {{-- <li class="nav-item">
          <a class="nav-link text-white " href="pages/profile.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li> --}}

        {{-- <li class="nav-item">
          <a class="nav-link text-white " href="pages/sign-in.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">login</i>
            </div>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li> --}}

        {{-- <li class="nav-item">
          <a class="nav-link text-white " href="pages/sign-up.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">assignment</i>
            </div>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li> --}}

      </ul>
    </div>
  </aside>