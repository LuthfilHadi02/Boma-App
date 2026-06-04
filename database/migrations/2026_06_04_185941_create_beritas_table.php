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
    Schema::create('beritas', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('slug')->unique(); // Buat URL: boma.test/berita/juara-2-dan-juara-3
        $table->text('deskripsi_singkat'); // Buat teks di kartu home
        $table->longText('konten_lengkap'); // Isi berita pas diklik "Read More"
        $table->string('foto');
        $table->date('tanggal_kegiatan');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
