<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengguna_lulusan', function (Blueprint $table) {
            $table->id('id_pengguna_lulusan');
            $table->string('nama_atasan', 100)->nullable(); // Nama atasan
            $table->string('jabatan_atasan', 100)->nullable(); // Jabatan atasan
            $table->string('email_atasan', 100)->nullable(); // Email atasan
            $table->string('nama_instansi', 100)->nullable(); // Nama instansi
            $table->enum('jenis_instansi', ['Pendidikan Tinggi', 'Instansi Pemerintah', 'BUMN', 'Perusahaan Swasta'])->nullable(); // Jenis instansi
            $table->enum('skala_instansi', ['Local', 'National', 'International'])->nullable(); // Skala instansi
            $table->string('lokasi_instansi', 100)->nullable(); // Lokasi instansi
            $table->string('no_hp_instansi', 20)->nullable(); // No HP instansi
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengguna_lulusan');
    }
};