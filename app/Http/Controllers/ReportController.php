<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil tanggal dari request, kalau gak ada pakai hari ini
        $date = $request->input('date') ?? now()->format('Y-m-d');

        // 2. Ambil semua booking di tanggal itu
        $bookings = Booking::whereDate('booking_date', $date)
            ->orderBy('session', 'asc') // Urutkan Pagi -> Siang -> Malam
            ->orderBy('registration_number', 'asc') // Urutkan nomor antrian
            ->get();

        // 3. Kirim data ke React
        return Inertia::render('Admin/Report', [
            'bookings' => $bookings,
            'selectedDate' => $date
        ]);
    }

    // Fungsi buat update lapak nanti
    public function updateLapak(Request $request, $id)
    {
        $request->validate(['fishing_spot_id' => 'required|numeric']);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'fishing_spot_id' => $request->fishing_spot_id
        ]);

        return redirect()->back()->with('success', 'Lapak berhasil disimpan!');
    }
}
