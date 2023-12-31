<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Role;
use App\Notifications\SubAdminRegistration;
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
        $data['roles']               = Role::where([['status', '=', 'active'], ['role', '!=', 'super_admin']])->orderBy('created_at', 'desc')->get();
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
            $name = $request->fname.' '.$request->lname;
            $insert->notify(new SubAdminRegistration($name, $request->email, $request->password));
            return redirect()->route('sub-admin.list')->with('success', trans('msg.admin.Sub Admin Added Successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Unable to add Sub Admin, Please try again').'...')->withInput();
        }
    }

    public function editForm($id) {
        $subadmin = Admin::find($id);
        $role =  Role::where('role', '!=', 'super_admin')->orderBy('created_at', 'desc')->get();

        if ($subadmin) {
            $data['previous_title']  = trans('msg.admin.Manage Sub Admins');
            $data['url']             = route('sub-admin.list');
            $data['title']           = trans('msg.admin.Manage Sub Admins');
            $data['subadmin']        = $subadmin;
            $data['roles']           = $role;
            $data['country']         = Country::all();

            return view('admin.sub-admins.edit', $data);
        } else {
            return response()->json(['error' => trans('msg.admin.Sub Admin Not Found')]);
        }
    }

    public function edit(Request $request) {
        $id = $request->id;
        $subadmin = Admin::find($id);
    
        if (!$subadmin) {
            return redirect()->back()->with('error', trans('msg.admin.Sub Admin Not Found'));
        }
    
        $request->validate([
            'fname' => 'nullable|string|max:255',
            'lname' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'role' => 'nullable|string',
        ]);
    
        if ($request->filled('phone') && !is_numeric($request->phone)) {
            return redirect()->back()->with('error', trans('msg.admin.Invalid phone number format'))->withErrors(['phone' => 'Invalid phone number format']);
        }

        $file = $request->file('photo');
        if ($file) {
            $oldPhotoPath = public_path($subadmin->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath); 
            }
            $extension = $file->getClientOriginalExtension();
            $image_name = time().'.'.$extension;
            $file->move('assets/uploads/admin-photos/', $image_name);
            $image_url = 'assets/uploads/admin-photos/'. $image_name;
        }
    
        $data = [
            'fname' => $request->filled('fname') ? $request->fname : $subadmin->fname,
            'lname' => $request->filled('lname') ? $request->lname : $subadmin->lname,
            'email' => $request->filled('email') ? $request->email : $subadmin->email,
            'role'  => $request->filled('role') ? $request->role : $subadmin->role,
            'phone' => $request->filled('phone') ? $request->phone : $subadmin->phone,
            'photo' => $request->file('photo') ? $image_url : $subadmin->photo,
        ];
    
        $update = $subadmin->update($data);
    
        if ($update) {
            return redirect()->route('sub-admin.list')->with('success', trans('msg.admin.Sub Admin updated successfully') . '.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to update Sub Admin. Please try again') . '...');
        }
    }
    
    public function changeStatus(Request $request) {
        $admin = Admin::find($request->admin_id);

        if (!$admin) {
            return response()->json(['error' => trans('msg.admin.Sub Admin Not Found')]);
        }

        $admin->status = $request->status;
        $update = $admin->save();

        if ($update) {
            $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
            return response()->json(['message' => trans('msg.admin.Sub Admin :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function delete(Request $request) {
        $admin = Admin::find($request->admin_id);
        if (!$admin) {
            return response()->json(['error' => trans('msg.admin.Sub Admin Not Found')]);
        }

        $delete = $admin->delete();

        if ($delete) {
            return response()->json(['message' => trans('msg.admin.Sub Admin :status Successfully', ['status' => 'Deleted'])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }
}
