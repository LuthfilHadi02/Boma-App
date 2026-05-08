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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->date('date');    
            $table->string('time');  
            $table->string('location'); 
            $table->integer('current_quota')->default(0); // Berapa yg udah daftar
            $table->integer('max_quota')->default(20);    // Maksimal kuota
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
