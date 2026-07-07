<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
        public function showLogin()
        {
            return view('admins.auth.login');
        }

        public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->intended(route('admin.index'));
            }

            return back()->withInput();
        }

        public function index()
        {
            return redirect()->route('admin.attendance.index');
        }

        public function logout()
        {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login');
        }
}
