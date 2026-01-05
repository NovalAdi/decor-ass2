<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileApiController extends Controller
{
    // GET /api/profile
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Auth::user()
        ]);
    }

    // PUT /api/profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $user = $request->user();

        // update data dasar
        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;

        // upload foto
        if ($request->hasFile('gambar')) {

            // hapus foto lama
            if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                Storage::disk('public')->delete($user->gambar);
            }

            // simpan foto baru
            $path = $request->file('gambar')->store('profiles', 'public');
            $user->gambar = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }
}
