<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaLulusan extends Model
{
    use HasFactory;

    protected $table = 'pengguna_lulusan'; // Nama tabel
    protected $primaryKey = 'id_pengguna_lulusan'; // Primary key
    public $timestamps = false; // Nonaktifkan timestamps

    protected $fillable = [
        'nama_atasan',
        'jabatan_atasan',
        'email_atasan',
        'nama_instansi',
        'jenis_instansi',
        'skala_instansi',
        'lokasi_instansi',
        'no_hp_instansi',
    ];

    /**
     * Relasi ke tabel alumni
     * Satu pengguna lulusan dapat memiliki banyak alumni
     */
    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'id_pengguna_lulusan', 'id_pengguna_lulusan');
    }
}