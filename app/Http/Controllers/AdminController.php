<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishingSpot;
use App\Models\Menu;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Cek apakah yang login benar-benar Admin?
        // (Sederhana dulu, nanti kita perketat pakai Middleware)
        if (auth()->user()->email !== 'admin@empang.com') {
            abort(403, 'ANDA BUKAN JURAGAN EMPANG!');
        }

        // Ambil data ringkas untuk Widget Statistik (Sesuai PDF Point 7)
        $totalLapak = FishingSpot::count();
        $totalMenu = Menu::count();
        $totalUser = User::where('role', '!=', 'admin')->count(); // Asumsi ada kolom role atau cek email

        return view('admin.dashboard', compact('totalLapak', 'totalMenu', 'totalUser'));
    }
}
