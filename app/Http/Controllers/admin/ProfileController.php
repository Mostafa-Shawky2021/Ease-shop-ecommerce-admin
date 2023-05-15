<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
    //
    public function show()
    {
        $admin = User::find(auth()->user()->id);
        return view('profile.show', compact('admin'));
    }
    public function edit()
    {
        $admin = User::find(auth()->user()->id);
        return view('profile.edit', compact('admin'));
    }
}