<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $data = Admin::where('email', $request->email)->first();
            $userRole = $data->role;

            if ($userRole != 'super_admin') {
                $roles = Role::where('role', $userRole)->first();
                $permissions = explode(',', $roles->privileges);

                // Save userRole and permissions in the session
                session(['userRole' => $userRole, 'permissions' => $permissions]);
            } else {
                // Save only userRole in the session
                session(['userRole' => $userRole]);
            }

            return redirect()->route('dashboard');
        }

        return redirect()->route('/')->with(['error' => trans('msg.admin.Invalid credentials')]);
    }



    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('/');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
        ? back()->with('success', trans($status))
        : back()->withInput($request->only('email'))
                ->with(['error' => trans($status)]);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = Password::broker('admins')->reset(
            $request->only(
                'email', 'password', 'password_confirmation', 'token'
            ),

            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? redirect()->route('/')->with('success', trans($response))
                    : back()->withInput($request->only('email'))
                            ->with(['error' => trans($response)]);
    }
}


