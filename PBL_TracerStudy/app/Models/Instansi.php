<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi'; // Nama tabel
    protected $primaryKey = 'id_instansi'; // Primary key

    protected $fillable = [
        'nama_instansi',
        'jenis_instansi',
        'skala_instansi',
        'lokasi_instansi',
        'no_hp_instansi',
    ];
}
