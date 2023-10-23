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
        {{-- Dashboard --}}
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='bx bxs-dashboard'></i></div>
                <div class="menu-title">{{ trans('msg.admin.Dashboard') }}</div>
            </a>
        </li>

        {{-- Manage Users --}}
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bxs-group'></i>
                </div>
                <div class="menu-title">{{ trans('msg.admin.Users') }}</div>
            </a>
            <ul>
                <li> 
                    <a href="{{ route('user.list') }}"><i class="bx bx-right-arrow-alt"></i>{{ trans('msg.admin.Manage Users') }}</a>
                </li>
                <li> 
                    <a href="{{ route('user.send-notification-form') }}"><i class="bx bx-right-arrow-alt"></i>{{ trans('msg.admin.Send Notification') }}</a>
                </li>
            </ul>
        </li>

        {{-- Manage Sub Admins --}}
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bxs-user-detail'></i>
                </div>
                <div class="menu-title">{{ trans('msg.admin.Sub Admins') }}</div>
            </a>
            <ul>
                <li> 
                    <a href="{{ route('sub-admin.list') }}"><i class="bx bx-right-arrow-alt"></i>{{ trans('msg.admin.Manage Sub Admins') }}</a>
                </li>
                <li> 
                    <a href="{{ route('sub-admin.add-form') }}"><i class="bx bx-right-arrow-alt"></i>{{ trans('msg.admin.Add Sub Admin') }}</a>
                </li>
            </ul>
        </li>

        {{-- Manage Promo Codes --}}
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bxs-discount' ></i>
                </div>
                <div class="menu-title">{{ trans('msg.admin.Promo Codes') }}</div>
            </a>
            <ul>
                <li> 
                    <a href="{{ route('promo-code.list') }}"><i class="bx bx-right-arrow-alt"></i>{{ trans('msg.admin.Manage Promo Codes') }}</a>
                </li>
                <li> 
                    <a href="{{ route('promo-code.add-form') }}"><i class="bx bx-right-arrow-alt"></i>{{ trans('msg.admin.Add Promo Code') }}</a>
                </li>
            </ul>
        </li>

        {{-- Manage Markups --}}
        <li>
            <a href="{{ route('markup.list') }}">
                <div class="parent-icon">
                    <i class='bx bx-money'></i>
                </div>
                <div class="menu-title">{{ trans('msg.admin.Markups') }}</div>
            </a>
        </li>

    </ul>
    <!--end navigation-->
</div>