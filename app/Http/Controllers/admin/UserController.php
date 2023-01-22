<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::where('is_admin', '0')->get();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|min:3',
            'lname' => 'required|min:3',
            'email' => 'required|email|unique:users',
            // 'password' => 'required|confirm',
        ]);

        User::create([
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);

        return redirect()
            ->route('users.index')
            ->with(['message' => ['User Added Successfully', 'success']]);

    }
}