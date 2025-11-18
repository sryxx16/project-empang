<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // MENAMPILKAN DAFTAR MENU
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    // MENYIMPAN MENU BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'public/menus'
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'category' => 'minuman', // Default
            'is_available' => true
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    // UPDATE / EDIT MENU
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            // Upload gambar baru
            $menu->image = $request->file('image')->store('menus', 'public');
        }

        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_available' => $request->has('is_available') // Checkbox handling
        ]);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    // HAPUS MENU
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        // Hapus gambarnya juga biar hemat storage
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();

        return redirect()->back()->with('success', 'Menu dihapus!');
    }
}
