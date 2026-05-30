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
        Schema::table('riwayat_transaksis', function (Blueprint $table) {
            $table->enum('jenis_transaksi', ['Tersedia', 'Digunakan', 'Perbaikan', 'Kalibrasi', 'Dibawa Eksternal'])->default('Tersedia')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_transaksis', function (Blueprint $table) {
            $table->enum('jenis_transaksi', ['Penggunaan', 'Perbaikan', 'Kalibrasi', 'Dibawa Eksternal', 'Pengembalian'])->default('Penggunaan')->change();
        });
    }
};
