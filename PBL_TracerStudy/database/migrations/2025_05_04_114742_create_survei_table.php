<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('survei', function (Blueprint $table) {
            $table->id('id_survei');
            $table->string('nama_survei', 100);
            $table->enum('jenis', ['tracer', 'pengguna_lulusan']);
            $table->year('tahun');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void {
        Schema::dropIfExists('survei');
    }
};