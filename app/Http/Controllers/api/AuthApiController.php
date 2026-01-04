<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        // ADMIN LOGIN
        $admin = User::where('name', $request->name)
            ->where('is_admin', 1)
            ->first();

        if ($admin && Auth::guard('admin')->attempt($credentials)) {
            $token = $admin->createToken(
                'admin_token',
                ['admin']
            )->plainTextToken;

            return response()->json([
                'token' => $token,
                'role' => 'admin',
                'message' => 'Admin login success',
            ]);
        }

        // USER LOGIN
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken(
                'user_token',
                ['user']
            )->plainTextToken;

            return response()->json([
                'token' => $token,
                'role' => 'user',
                'message' => 'Login success',
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }


    public static function logout()
    {
        Auth::logout();
        Auth::guard('admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
