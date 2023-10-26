<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The credentials you entered are incorrect.']
            ]);
        }

        $token = $user->createToken('blog')->plainTextToken;

        return response()->json([
            'message' => "Login successful",
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        // Revoking/deleting access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => "Logout Successful"
        ]);
    }
}
