<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni'; // Nama tabel
    protected $primaryKey = 'nim'; // Primary key
    public $incrementing = false; // Karena primary key bukan auto-increment
    public $timestamps = false; // Nonaktifkan timestamps

    protected $fillable = [
        'nim',
        'nama_alumni',
        'prodi',
        'no_hp',
        'email',
        'tahun_masuk',
        'tgl_lulus',
        'tanggal_kerja_pertama',
        'masa_tunggu',
        'tanggal_mulai_instansi',
        'kategori_profesi',
        'profesi',
        'id_pengguna_lulusan', // Foreign key ke tabel pengguna_lulusan
        'id_instansi', // Foreign key ke tabel instansi
    ];

    /**
     * Relasi ke tabel pengguna_lulusan
     * Satu alumni memiliki satu pengguna lulusan
     */
    public function penggunaLulusan()
    {
        return $this->belongsTo(PenggunaLulusan::class, 'id_pengguna_lulusan', 'id_pengguna_lulusan');
    }

    public function instansi()
    {
        return $this->belongsTo(PenggunaLulusan::class, 'id_instansi', 'id_instansi');
    }
}