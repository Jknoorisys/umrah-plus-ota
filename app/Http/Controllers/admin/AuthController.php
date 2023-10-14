<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
            return redirect()->intended('dashboard');
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
        ? back()->with('success', __($status))
        : back()->withInput($request->only('email'))
                ->with(['error' => __($status)]);
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
                    ? redirect()->route('/')->with('success', __($response))
                    : back()->withInput($request->only('email'))
                            ->with(['error' => __($response)]);
    }
}


