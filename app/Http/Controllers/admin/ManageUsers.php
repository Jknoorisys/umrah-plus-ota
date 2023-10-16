<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUsers extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Users');
        $data['users']               = User::all();
        
        return view('admin.user.list', $data);
    }

    public function changeStatus(Request $request) {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => trans('msg.admin.User Not Found')]);
        }

        $user->status = $request->status;
        $update = $user->save();

        if ($update) {
            $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
            return response()->json(['message' => trans('msg.admin.User :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
        
    }

    public function delete(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['error' => trans('msg.admin.User Not Found')]);
        }

        $delete = $user->delete();

        if ($delete) {
            return response()->json(['message' => trans('msg.admin.User deleted successfully')]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }
}
