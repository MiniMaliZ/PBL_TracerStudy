<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumni', function (Blueprint $table) {
            $table->string('nim', 20)->primary();
            $table->string('nama_alumni', 100);
            $table->string('prodi', 100);
            $table->string('no_hp', 20);
            $table->string('email', 100);
            $table->year('tahun_masuk');
            $table->date('tgl_lulus');
            $table->year('tahun_lulus');
            $table->date('tanggal_kerja_pertama')->nullable();
            $table->integer('masa_tunggu')->nullable(); // bulan
            $table->date('tanggal_mulai_instansi')->nullable();
            $table->string('jenis_instansi', 100)->nullable();
            $table->string('nama_instansi', 100)->nullable();
            $table->enum('skala_instansi', ['local', 'national', 'international'])->nullable();
            $table->string('lokasi_instansi', 100)->nullable();
            $table->string('kategori_profesi', 100)->nullable();
            $table->string('profesi', 100)->nullable();
            $table->string('nama_atasan', 100)->nullable();
            $table->string('jabatan_atasan', 100)->nullable();
            $table->string('no_hp_atasan', 20)->nullable();
            $table->string('email_atasan', 100)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alumni');
    }
};