<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ManageSubAdmins extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Sub Admins');
        $data['admins']               = Admin::where('role', '!=', 'super_Admin')->orderBy('created_at', 'desc')->get();
        
        return view('admin.sub-admins.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Sub Admins');
        $data['url']                 = route('sub-admin.list');
        $data['title']               = trans('msg.admin.Add Sub Admin');
        $data['roles']               = Role::where('status', '=', 'active')->orderBy('created_at', 'desc')->get();
        $data['country']             = Country::all();
        
        return view('admin.sub-admins.add', $data);
    }

    public function add(Request $request) {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:admins',
            'role' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
            'password' => 'required|min:6',
            'cnfm_password' => 'required|same:password',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $adminData = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'role' => $request->role,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ];

        $file = $request->file('image');
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $image_name = time().'.'.$extension;
            $file->move('assets/uploads/admin-photos/', $image_name);
            $image_url = 'assets/uploads/admin-photos/'. $image_name;
            $adminData['photo'] = $image_url;
        }

        $insert = Admin::create($adminData);

        if ($insert) {
            return redirect()->back()->with('success', trans('msg.admin.Sub Admin Added Successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Unable to add Sub Admin, Please try again').'...')->withInput();
        }
    }

    // public function editForm($id) {
    //     $code = Admin::find($id);

    //     if ($code) {
    //         $data['previous_title']  = trans('msg.admin.Manage Promo Codes');
    //         $data['url']             = route('promo-code.list');
    //         $data['title']           = trans('msg.admin.Edit Promo Code');
    //         $data['code']            = $code;
    //         return view('admin.promo-codes.edit', $data);
    //     } else {
    //         return response()->json(['error' => trans('msg.admin.Promo Code Not Found')]);
    //     }
    // }

    // public function edit(Request $request) {
        
    //     $id = $request->id;
    //     $promoCode = Admin::find($id);
    
    //     if (!$promoCode) {
    //         return redirect()->back()->with('error', trans('msg.admin.Promo code not found'));
    //     }

    //     $validatedData = $request->validate([
    //         'service' => 'required',
    //         'start_date' => 'required|date',
    //         'expire_date' => 'required|date|after:start_date',
    //         'code' => ['required', 'string', Rule::unique('promo_codes')->ignore($id)->where(function ($query) use ($request) {
    //             return $query->where('service', $request->service);
    //         })],
    //         'type' => 'required',
    //         'discount' => 'required|numeric|min:0',
    //         'max_discount' => 'required|numeric|min:0',
    //         'min_purchase' => 'required|numeric|min:0',
    //         'max_usage_per_user' => 'required|numeric|min:0',
    //     ]);
    
    //     $update = $promoCode->update($validatedData);

    //     if ($update) {
    //         return redirect()->route('promo-code.list')->with('success', trans('msg.admin.Promo code updated successfully').'.');
    //     } else {
    //         return redirect()->back()->with('error', trans('msg.admin.Failed to update promo code. Please try again').'...');
    //     }
            
    // }

    // public function changeStatus(Request $request) {
    //     $code = Admin::find($request->code_id);

    //     if (!$code) {
    //         return response()->json(['error' => trans('msg.admin.Promo Code Not Found')]);
    //     }

    //     $code->status = $request->status;
    //     $update = $code->save();

    //     if ($update) {
    //         $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
    //         return response()->json(['message' => trans('msg.admin.Promo Code :status Successfully', ['status' => $status])]);
    //     } else {
    //         return response()->json(['error' => trans('msg.admin.Please try again...')]);
    //     }
    // }

    // public function delete(Request $request)
    // {
    //     $code = Admin::find($request->code_id);
    //     if (!$code) {
    //         return response()->json(['error' => trans('msg.admin.Promo Code Not Found')]);
    //     }

    //     $delete = $code->delete();

    //     if ($delete) {
    //         return response()->json(['message' => trans('msg.admin.Promo Code :status Successfully', ['status' => 'Deleted'])]);
    //     } else {
    //         return response()->json(['error' => trans('msg.admin.Please try again...')]);
    //     }
    // }
}
