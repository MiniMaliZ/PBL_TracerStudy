<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class); // Tambahkan AdminSeeder
        $this->call(PertanyaanSeeder::class); // Pastikan PertanyaanSeeder juga dipanggil
        // $this->call(AlumniSeeder::class); // Tambahkan AlumniSeeder
    }
}