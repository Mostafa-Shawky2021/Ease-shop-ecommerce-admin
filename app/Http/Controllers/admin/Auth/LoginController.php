<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function create()
    {

        return view('auth.login');
    }
    public function auth(Request $request)
    {
        $userCredential = [
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => 1,
        ];

        if (auth()->attempt($userCredential)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors('message', 'invalid email or password');
    }
}