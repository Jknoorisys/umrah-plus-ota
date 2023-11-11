<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ManageNotifications extends Controller
{
    public function list()
    {
        $data['notifications'] = Notification::all();
        return view('admin.notification-history.list', $data);
    }
}
