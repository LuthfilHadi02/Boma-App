<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('refunds', function (Blueprint $table) {
        $table->id();
        // Menghubungkan langsung ke tabel payments bawaan lu, bro!
        $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
        $table->text('reason'); // Alasan user minta refund
        $table->integer('amount'); // Jumlah dana yang dikembalikan
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('admin_note')->nullable(); // Catatan admin jika ditolak
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('refunds');
}
};
