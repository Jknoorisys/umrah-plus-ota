<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ManageNotifications extends Controller
{
    public function list()
    {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Notification History');
        $data['notifications']       = Auth::guard('admin')->user()->notifications;
        return view('admin.notification-history.list', $data);
    }
}
