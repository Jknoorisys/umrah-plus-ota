<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
        
        return redirect()->route('/')->with(['error' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('/');
    }
}


