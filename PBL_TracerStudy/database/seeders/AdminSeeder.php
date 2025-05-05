<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'username' => 'admin1',
                'password' => Hash::make('password123'), // Gunakan Hash untuk mengenkripsi password
                'nama' => 'Admin Satu',
            ],
            [
                'username' => 'admin2',
                'password' => Hash::make('password123'),
                'nama' => 'Admin Dua',
            ],
        ]);
    }
}