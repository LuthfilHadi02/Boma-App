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
        Schema::create('schedule_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // 🔒 LOCK UTAMA: Kombinasi jadwal dan user harus unik biar gak bisa spam klik!
            $table->unique(['schedule_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_user');
    }
};
