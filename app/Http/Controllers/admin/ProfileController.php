<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function dashboard() {
        return view('admin.layouts.app');
    }

    public function profile() {
        $admin = Admin::find(Auth::guard('admin')->user()->id);

        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Profile');
        $data['admin']               = $admin;
        $data['country']             = DB::table('country')->get();
        
        return view('admin.profile', $data);
    }

    public function getPhoneCode(Request $request)
    {
        $id = $request->id;

        if (!empty($id)) {
            $country = DB::table('country')->where('id', '=', $id)->first(); 
            $data = $country->phone_code;
            return response()->json($data);
        } else {
            $data = '-';
            return response()->json($data);
        }
    }
}
