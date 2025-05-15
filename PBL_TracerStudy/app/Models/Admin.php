<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin'; // Nama tabel
    protected $primaryKey = 'id_admin'; // Primary key

    public $timestamps = false; // Nonaktifkan timestamps jika tidak ada kolom created_at dan updated_at

    protected $fillable = [
        'username',
        'password',
        'nama',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    // Relasi ke tabel pertanyaan
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'created_by', 'id_admin');
    }
}