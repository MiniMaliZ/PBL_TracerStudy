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
        'tahun_lulus',
        'tgl_lulus',
        'tanggal_kerja_pertama',
        'masa_tunggu',
        'tanggal_mulai_instansi',
        'jenis_instansi',
        'nama_instansi',
        'skala_instansi',
        'lokasi_instansi',
        'kategori_profesi',
        'profesi',
        'nama_atasan',
        'jabatan_atasan',
        'no_hp_atasan',
        'email_atasan',
    ];
}