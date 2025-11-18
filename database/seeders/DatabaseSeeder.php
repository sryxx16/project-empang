<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FishingSpot;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::create([
            'name' => 'Juragan Empang',
            'email' => 'admin@empang.com',
            'password' => bcrypt('password'), // Passwordnya: password
            'role' => 'admin', // Kita anggap nanti ada logika role
        ]);

        // 2. Bikin 1 Akun User Biasa untuk ngetes
        User::create([
            'name' => 'Budi Pemancing',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // 3. Generate 34 Lapak Mancing Otomatis
        // Sesuai instruksi PDF halaman 1 poin 3
        for ($i = 1; $i <= 34; $i++) {
            FishingSpot::create([
                'name' => 'Lapak ' . $i,
                'status' => 'available'
            ]);
        }
    }
}
