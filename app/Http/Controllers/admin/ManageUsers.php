<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\NotificationHistory;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;

class ManageUsers extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Users');
        $data['users']               = User::with('userAddress')->orderBy('created_at', 'desc')->get();
        
        return view('admin.user.list', $data);
    }

    public function view($id) {
        $user = User::find($id);

        if ($user) {
            $user->userAddress;
            $data['previous_title']  = trans('msg.admin.Manage Users');
            $data['url']             = route('user.list');
            $data['title']           = trans('msg.admin.User Details');
            $data['user']            = $user;
            // $data['visa_enquiries']  = $user->visaEnquiries()->where('user_id', '=', $id)->orderBy('created_at', 'desc')->get();
            
            return view('admin.user.details', $data);
        } else {
            return response()->json(['error' => trans('msg.admin.User Not Found')]);
        }
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

    public function delete(Request $request) {
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

    public function sendNotificationForm() {
        
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Send Notification');
        $data['roles']               = Role::where([['status', 'active'], ['role', '!=', 'super_admin']])->get();
        return view('admin.user.send_notification', $data);
    }

    public function sendNotification(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
            'message' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('assets/uploads/notification-photos/'), $imageName);
            $image_url = 'assets/uploads/notification-photos/'. $imageName;
        }

        $admin = auth()->guard('admin')->user();

        $data = [
            'title' => $request->title,
            'message' => $request->message,
            'image' => $image_url ?? '',
            'type' => $request->type,
            'profile' => $admin->photo ?? '',
        ];

        $users = [];
        if ($validatedData['type'] === 'user') {
            $users = User::where('status', 'active')->get();
        }else{
            $users = Admin::where([['role', $request->type], ['status', '=', 'active']])->get();
        }

        // if ($validatedData['type'] === 'admin') {
        //     $users = Admin::where([['role', 'admin'], ['status', '=', 'active']])->get();
        // } elseif ($validatedData['type'] === 'user') {
        //     $users = User::where('status', 'active')->get();
        // }

        foreach ($users as $user) {
            $user->notify(new SendNotification($data));
        }

        $insert = NotificationHistory::create($data);

        if ($insert) {
            return redirect()->back()->with('success', trans('msg.admin.Notification sent successfully'));
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Unable to send notification, Please try again...'));
        }
        
    }
}
