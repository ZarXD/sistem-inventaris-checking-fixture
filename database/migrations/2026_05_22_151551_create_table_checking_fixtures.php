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
        Schema::create('checking_fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('part_number', 50)->unique();
            $table->string('customer', 50);
            $table->string('nama_cf', 100);
            $table->enum('status_ketersediaan', ['Tersedia', 'Digunakan', 'Perbaikan', 'Kalibrasi', 'Dibawa Eksternal'])->default('Tersedia');
            $table->foreignId('lokasi_rak_id')->constrained('lokasi_raks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checking_fixtures');
    }
};
