<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterForm;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {

        $credential = $request->validate([
            'email' => 'required',
            'password' => 'required'

        ]);

        if (Auth()->attempt($credential)) {
            $user = Auth()->user();
            return response([
                'message' => 'Login successfully',
                'user' => $user,
                'token' => Auth()->user()->createToken('app_token')->plainTextToken,
            ]);
        }
        return response(['message' => 'invalid email or password'], 403);
    }

    public function store(RegisterForm $request)
    {

        if ($request->validated()) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            $userToken = $user->createToken('app_token')->plainTextToken;
            return response([
                'message' => 'user created successfully',
                'user' => $user,
                'token' => $userToken,
            ]);
        }
    }

}