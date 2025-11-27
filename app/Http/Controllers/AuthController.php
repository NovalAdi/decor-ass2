<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        //check admin
        $admin = User::where('name', $request->only('name'))->first();
        if ($admin && $admin->is_admin == 1) {
            $credentials = $request->only('name', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('admin.produk.index');
            }
            return back()->withErrors([
                'name' => $admin->name,
            ])->onlyInput('name');
        }

        //normal user login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'name' => 'asddf',
        ])->onlyInput('name');
    }

    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public static function logout()
    {
        Auth::logout();
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
