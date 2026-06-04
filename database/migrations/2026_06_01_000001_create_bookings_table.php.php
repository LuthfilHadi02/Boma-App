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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // 1. Mengunci Mahasiswa/User yang memesan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // 2. Mengunci Lapangan Spesifik yang disewa (Gua ganti dari mitra_id ke facility_id biar jelas lapangannya)
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            
            // 3. Data Waktu & Durasi Main Nyata (Biar ga hardcode!)
            $table->date('booking_date'); // Tanggal main (Contoh: 2026-06-05)
            $table->string('start_time'); // Jam mulai main (Contoh: "14:00")
            $table->integer('jumlah_sesi'); // Berapa jam/sesi durasi mainnya (Mengikuti nama kolom Luthfil)
            $table->integer('total_price'); // Menyimpan nominal total harga sewa riil
            
            // 4. Status Booking
            $table->string('status')->default('pending'); // pending (belum bayar), paid (lunas), cancelled (batal)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};