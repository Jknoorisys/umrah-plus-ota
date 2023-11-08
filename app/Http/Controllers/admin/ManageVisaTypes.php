<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageVisaTypes extends Controller
{
    public function index()
    {
        return view('admin/visa-type/manage-visa-type');
    }
}
