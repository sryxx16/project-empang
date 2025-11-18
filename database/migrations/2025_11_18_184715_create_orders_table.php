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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Siapa admin/kasir yang melayani?
            $table->foreignId('user_id')->constrained();

            $table->integer('total_price')->default(0); // Total bayar
            $table->string('customer_name')->nullable(); // Nama pembeli (opsional)
            $table->enum('status', ['pending', 'completed'])->default('completed');

            // Tips: Idealnya ada tabel 'order_items' terpisah untuk detailnya,
            // tapi untuk awal kita simpan detail pesanan sebagai JSON biar simpel & sesuai instruksi 4 tabel.
            $table->json('order_items')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
