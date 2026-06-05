<?php
// FILE INI HANYA ADA DI AKMAL — Denis tidak punya
// Salin ke: database/migrations/2026_06_04_200912_add_link_to_beritas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('link')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};