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
        Schema::create('riwayat_tansaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cf_id')->constrained('checking_fixtures')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_transaksi', ['Penggunaan', 'Perbaikan', 'Kalibrasi', 'Dibawa Eksternal', 'Pengembalian'])->default('Penggunaan');
            $table->dateTime('tanggal_transaksi')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_tansaksis');
    }
};
