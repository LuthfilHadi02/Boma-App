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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('brand_name'); // Nama Bisnis/Klub [cite: 62]
            $table->string('address'); // Alamat Lapangan [cite: 62]
            $table->string('bank_name'); // Nama Bank untuk KYC [cite: 80, 81]
            $table->string('bank_account_number'); // No Rekening [cite: 80, 81]
            $table->string('bank_account_name'); // Nama di Rekening (harus match) 
            $table->string('identity_document'); // Path file KTP/Izin Usaha 
            $table->enum('status', ['Pending_Verification', 'Approved', 'Suspended'])
                ->default('Pending_Verification'); // [cite: 81, 84]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
