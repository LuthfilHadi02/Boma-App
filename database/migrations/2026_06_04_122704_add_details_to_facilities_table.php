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
        Schema::table('facilities', function (Blueprint $table) {
            // 🟢 Suntik kolom penampung Fasilitas (Disimpan pake format JSON / Teks Tunggal)
            $table->text('amenities')->nullable()->after('description');
            
            // 🟢 Suntik kolom Link Google Maps / Alamat Tambahan Lapangan jika spesifik
            $table->text('gmaps_link')->nullable()->after('amenities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn(['amenities', 'gmaps_link']);
        });
    }
};