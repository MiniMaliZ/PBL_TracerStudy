<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengguna_lulusan', function (Blueprint $table) {
            $table->id('id_pengguna_lulusan');
            $table->string('nama_pl', 100);
            $table->string('instansi', 100);
            $table->string('jabatan', 100);
            $table->string('email', 100);
            $table->string('nama_alumni', 100);
            $table->string('nim', 20); // FK ke alumni
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengguna_lulusan');
    }
};