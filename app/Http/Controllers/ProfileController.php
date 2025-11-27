<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // show halaman profile
    public function index()
    {
        $user = Auth::user();
        return view('page.profile', compact('user'));
    }


    // show halaman edit profile
    public function edit()
    {
        $user = Auth::user();
        return view('page.profile_edit', compact('user'));
    }


    // update profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // update data dasar
        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;

        // upload foto jika ada
        if ($request->hasFile('gambar')) {

            // hapus foto lama (kalau ada)
            if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                Storage::disk('public')->delete($user->gambar);
            }

            // simpan foto baru
            $file = $request->file('gambar')->store('profiles', 'public');
            $user->gambar = $file;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
