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
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengguna_lulusan');
    }
};