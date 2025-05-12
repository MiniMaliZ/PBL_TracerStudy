<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    protected $primaryKey = 'nim'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    
    protected $fillable = [
        'nim',
        'nama_alumni', 
        'prodi', 
        'no_hp', 
        'email', 
        'tgl_lulus',
        'tahun_lulus',
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
        'email_atasan'
    ];
}