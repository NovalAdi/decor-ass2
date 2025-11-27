<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    // LIST ALAMAT
    public function index()
    {
        $addresses = Alamat::where('user_id', Auth::id())->get();
        return view('page.alamat', compact('addresses'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('page.tambah_alamat');
    }

    // SIMPAN ALAMAT BARU
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        Alamat::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('alamat.index')->with('success', 'Alamat berhasil ditambahkan!');
    }

    // FORM EDIT
    public function edit($id)
    {
        $address = Alamat::where('user_id', Auth::id())->findOrFail($id);

        return view('page.edit_alamat', compact('address'));
    }

    // UPDATE ALAMAT
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $address = Alamat::where('user_id', Auth::id())->findOrFail($id);

        $address->update([
            'judul' => $request->judul,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('alamat.index')->with('success', 'Alamat berhasil diperbarui!');
    }

    // DELETE ALAMAT
    public function destroy($id)
    {
        $address = Alamat::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return redirect()->route('alamat.index')->with('success', 'Alamat berhasil dihapus!');
    }
}
