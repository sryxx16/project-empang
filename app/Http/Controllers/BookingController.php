<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input (Wajib diisi)
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'session' => 'required|in:pagi,siang,malam',
        ]);

        // 2. Generate Nomor Urut Pendaftaran Otomatis
        // Kita hitung, hari ini sesi ini sudah ada berapa orang?
        $jumlahPendaftar = Booking::where('booking_date', $request->date)
                        ->where('session', $request->session)
                        ->count();

        // Nomor urut = jumlah yang ada + 1
        $nomorUrut = $jumlahPendaftar + 1;

        // 3. Simpan ke Database
        Booking::create([
            'customer_name' => $request->customer_name,
            'booking_date' => $request->date,
            'session' => $request->session,
            'registration_number' => $nomorUrut,
            'status' => 'pending', // Status awal
            // user_id & fishing_spot_id otomatis NULL (sesuai database baru kita)
        ]);

        // 4. Kirim Pesan Sukses kembali ke Halaman Depan
        return redirect()->back()->with('success', "Pendaftaran Berhasil! Nomor Urut Anda: #$nomorUrut. Harap datang ke lokasi untuk kocokan lapak.");
    }
}
