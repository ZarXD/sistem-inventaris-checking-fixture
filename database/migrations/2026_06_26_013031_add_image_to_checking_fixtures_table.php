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
        Schema::table('checking_fixtures', function (Blueprint $table) {
            $table->string('image')->nullable()->after('status_ketersediaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checking_fixtures', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
