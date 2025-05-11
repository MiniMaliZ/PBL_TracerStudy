<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumni', function (Blueprint $table) {
            $table->string('nim', 20)->primary(); // Primary key
            $table->string('nama_alumni', 100); // Nama alumni
            $table->string('prodi', 100); // Program studi
            $table->string('no_hp', 20)->nullable(); // Nomor HP alumni
            $table->string('email', 100)->nullable(); // Email alumni
            $table->year('tahun_masuk')->nullable(); // Tahun masuk
            $table->date('tgl_lulus'); // Tanggal lulus
            $table->date('tanggal_kerja_pertama')->nullable(); // Tanggal kerja pertama
            $table->date('tanggal_mulai_instansi')->nullable(); // Tanggal kerja pertama
            $table->integer('masa_tunggu')->nullable(); // Masa tunggu kerja
            $table->enum('kategori_profesi', ['Infokom','Non Infokom'])->nullable(); // Kategori profesi
            $table->string('profesi', 100)->nullable(); // Profesi
            $table->unsignedBigInteger('id_pengguna_lulusan')->nullable(); // Foreign key ke pengguna_lulusan

            // Relasi ke tabel pengguna_lulusan
            $table->foreign('id_pengguna_lulusan')
                ->references('id_pengguna_lulusan')
                ->on('pengguna_lulusan')
                ->onDelete('set null'); // Jika pengguna_lulusan dihapus, set null
        });
    }

    public function down(): void {
        Schema::dropIfExists('alumni');
    }
};