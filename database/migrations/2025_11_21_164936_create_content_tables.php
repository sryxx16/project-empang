<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel SETTINGS (Buat simpan teks 'Tentang Kami', 'Jam Buka', dll)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Kunci: 'about_us', 'jam_buka'
            $table->text('value')->nullable(); // Isi teksnya
            $table->timestamps();
        });

        // 2. Tabel GALLERIES (Buat simpan foto-foto)
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // Nama file foto
            $table->string('caption')->nullable(); // Judul foto (opsional)
            $table->timestamps();
        });

        // 3. Update Bookings (Sekalian aja biar gak kerja 2x nanti)
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('fishing_spot_id')->nullable()->change();
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->integer('registration_number')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('settings');
    }
};
