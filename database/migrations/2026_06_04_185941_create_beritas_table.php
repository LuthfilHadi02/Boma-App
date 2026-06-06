<?php
// FILE INI HANYA ADA DI AKMAL — Denis tidak punya
// Salin file ini ke: database/migrations/2026_06_04_185941_create_beritas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi_singkat');
            $table->longText('konten_lengkap');
            $table->string('foto');
            $table->date('tanggal_kegiatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};