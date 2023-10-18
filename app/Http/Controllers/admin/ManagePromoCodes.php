<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCodes;
use Illuminate\Http\Request;

class ManagePromoCodes extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Promo Codes');
        $data['users']               = PromoCodes::all();
        
        return view('admin.user.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Promo Codes');
        $data['url']                 = route('promo-code.list');
        $data['title']               = trans('msg.admin.Add Promo Code');
        
        return view('admin.promo-codes.add', $data);
    }
}
