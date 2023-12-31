<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class ManageRoles extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Roles');
        $data['roles']               = Role::where('role', '!=', 'super_admin')->orderBy('created_at', 'desc')->get();
        
        return view('admin.roles.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Roles');
        $data['url']                 = route('role.list');
        $data['title']               = trans('msg.admin.Add Role');
        
        return view('admin.roles.add', $data);
    }

    public function add(Request $request) {

        $allowedPrivilege = implode(',', $request->privilege);
        $data = [
            'role' => str_replace(' ', '_', strtolower($request->role)),
            'privileges' => $allowedPrivilege,
            'status' => 'active'
        ];

        $addRole = Role::create($data);
        if ($addRole) {
            return redirect()->route('role.list')->with('success', trans('msg.admin.Role Added successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Unable to add Role, Please try again').'.');
        }
        
        
    }

    public function editForm($id) {
        $code = Role::find($id);
        $explode = explode(',',$code->privileges);
    
        if ($code) {
            $data['previous_title']  = trans('msg.admin.Manage Roles');
            $data['url']             = route('role.list');
            $data['title']           = trans('msg.admin.Edit Role');
            $data['code']            = $code;
            $data['selectedPrivileges']      = $explode;
            $data['allPrivileges']           = ['1' => trans('msg.admin.Users'), '2' => trans('msg.admin.Sub Admins'), '3' => trans('msg.admin.Roles'), '4' => trans('msg.admin.Promo Codes'), 
            '5' => trans('msg.admin.Markups'), '6' => trans('msg.admin.Send Notification'), '7' => trans('msg.admin.Embassy'), '8' => trans('msg.admin.Visa Packages'), '9' => trans('msg.admin.Visa Types'), '10' => trans('msg.admin.Notifications'), 
            '11' => trans('msg.admin.Cancellation Policies')];

            return view('admin.roles.edit', $data);
        } else {
            return back()->with('error', trans('msg.admin.Role Not Found'));
        }
    }

    public function edit(Request $request) {
        
        $id = $request->id;
        $role = Role::find($id);
    
        if (!$role) {
            return redirect()->back()->with('error', trans('msg.admin.Role not found'));
        }
        
        $data = [
                'role' => $request->role ? $request->role : $role->role,
                'privileges' => $request->privilege ? implode(',',$request->privilege) : $role->privileges,
                'status' => $request->status ? $request->status : $role->status
            ];
    
        $update = Role::where('id',$id)->update($data);

        if ($update) {
            return redirect()->route('role.list')->with('success', trans('msg.admin.Role updated successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Unable to update Role, Please try again').'.');
        }
            
    }

    public function changeStatus(Request $request) {
        $code = Role::find($request->role_id);

        if (!$code) {
            return response()->json(['error' => trans('msg.admin.Role Not Found')]);
        }

        $code->status = $request->status;
        $update = $code->save();

        if ($update) {
            $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
            return response()->json(['message' => trans('msg.admin.Promo Code :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function delete(Request $request) {
        $code = Role::find($request->role_id);
        if (!$code) {
            return response()->json(['error' => trans('msg.admin.Promo Code Not Found')]);
        }

        $delete = $code->delete();

        if ($delete) {
            return response()->json(['message' => trans('msg.admin.Promo Code :status Successfully', ['status' => 'Deleted'])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }
}
