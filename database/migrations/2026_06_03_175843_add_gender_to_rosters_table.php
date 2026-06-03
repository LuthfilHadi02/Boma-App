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
    Schema::table('rosters', function (Blueprint $table) {
        // Menambahkan kolom gender setelah team_category
        // Dikasih default 'putra' biar data yang lama gak ikutan error
        $table->string('gender')->default('putra')->after('team_category');
    });
}

public function down(): void
{
    Schema::table('rosters', function (Blueprint $table) {
        $table->dropColumn('gender');
    });
}
};
