<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Siapa yang booking?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Lapak mana yang dibooking?
            $table->foreignId('fishing_spot_id')->constrained()->onDelete('cascade');

            $table->date('booking_date'); // Tanggal booking
            $table->enum('session', ['Pagi', 'Siang', 'Malam']); // Sesi mancing
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status booking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};