<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            // Nullable agar lapangan lama tidak error — fallback 06:00/22:00 ada di BookingController
            $table->time('opening_time')->nullable()->after('gmaps_link');
            $table->time('closing_time')->nullable()->after('opening_time');
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn(['opening_time', 'closing_time']);
        });
    }
};