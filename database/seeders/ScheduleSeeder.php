<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Data 1: Masih kosong, bisa daftar (Tanggal 5 Mei)
        Schedule::create([
            'title' => 'Sparing Futsal vs HIMARPL',
            'date' => '2026-05-05', 
            'time' => '19:00 - 21:00',
            'location' => 'Triditi Futsal Corner',
            'current_quota' => 15,
            'max_quota' => 20
        ]);

        // Data 2: Udah Penuh (Tanggal 10 Mei)
        Schedule::create([
            'title' => 'Latihan Rutin Basket',
            'date' => '2026-05-10', 
            'time' => '15:00 - 18:00',
            'location' => 'Rabbani Basket Indoor',
            'current_quota' => 20, // Sengaja dipenuhin
            'max_quota' => 20
        ]);
    }
}