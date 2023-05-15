<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    public function update(StoreProfileRequest $request)
    {
        $validatedInputs = $request->safe()->except('current_password');
        $validatedInputs['password'] = Hash::make($request->input('password'));

        $admin = auth()->user()->update($validatedInputs);
        return redirect()->route('profile.show')
            ->with(['message' => ['success', 'تم التحديث بنجاح']]);
    }
}