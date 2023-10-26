<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('username', $validated['username'])->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'username' => ['The credentials you entered are incorrect.']
        //     ]);
        // }

        if (!auth()->attempt($request->only(['username', 'password']))) {
            throw ValidationException::withMessages([
                'username' => ['The credentials you entered are incorrect.']
            ]);
        }

        return response()->json([
            'message' => "Login Successful"
        ]);
    }

    public function logout(Request $request)
    {
        auth('web')->logout();

        return response()->json([
            'message' => "Logout Successful"
        ]);
    }
}
