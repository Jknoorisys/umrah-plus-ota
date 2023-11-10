<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CancellationPolicy;
use Illuminate\Http\Request;

class ManageCancellationPolicy extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Cancellation Policies');
        $data['policies']            = CancellationPolicy::get();
        
        return view('admin.cancellation-policy.list', $data);
    }

    public function editForm($id) {
        $policy = CancellationPolicy::find($id);
    
        if ($policy) {
            $data['previous_title']  = trans('msg.admin.Manage Cancellation Policies');
            $data['url']             = route('cancellation-policy.list');
            $data['title']           = trans('msg.admin.Edit Cancellation Policy');
            $data['policy']          = $policy;
           
            return view('admin.cancellation-policy.edit', $data);
        } else {
            return response()->json(['error' => trans('msg.admin.Cancellation Policy Not Found')]);
        }
    }

    public function edit(Request $request) {
        return $request->all();exit;
        
        $id = $request->id;
        $role = CancellationPolicy::find($id);
    
        if (!$role) {
            return redirect()->back()->with('error', trans('msg.admin.Role not found'));
        }
        
        $data = [
                'role' => $request->role ? $request->role : $role->role,
                'privileges' => $request->privilege ? implode(',',$request->privilege) : $role->privileges,
                'status' => $request->status ? $request->status : $role->status
            ];
    
        $update = CancellationPolicy::where('id',$id)->update($data);

        if ($update) {
            return redirect()->route('role.list')->with('success', trans('msg.admin.Role updated successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Unable to update Role, Please try again').'.');
        }
            
    }
}
