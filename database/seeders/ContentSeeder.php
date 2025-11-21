<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Isi Data Profil Empang Default
        DB::table('settings')->insert([
            ['key' => 'jam_buka', 'value' => '09.00 - 17.00 WIB'],
            ['key' => 'harga_tiket', 'value' => '50000'],
            ['key' => 'about_us', 'value' => 'Pemancingan EmpangMantap adalah tempat mancing keluarga terbaik dengan 34 lapak standar kompetisi. Air jernih,
            ikan sehat, dan fasilitas lengkap untuk kenyamanan Anda.'],
        ]);

        // Kita kosongkan galeri dulu, nanti upload dari admin
    }
}
