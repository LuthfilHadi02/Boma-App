<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Token dari Midtrans — dipakai untuk buka popup bayar di frontend
            $table->string('snap_token')->nullable()->after('status');
            // ID order yang kita kirim ke Midtrans, format: BOMA-{booking_id}-{timestamp}
            $table->string('midtrans_order_id')->nullable()->after('snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_order_id']);
        });
    }
};