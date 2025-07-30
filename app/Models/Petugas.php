<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Petugas extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'petugas';
    protected $primaryKey = 'KodePetugas';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'KodePetugas',
        'Nama',
        'Jabatan',
        'HakAkses',
        'Username',
        'Password',
    ];

    protected $hidden = [
        'Password',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke peminjaman siswa
    public function pinjamHeaderSiswa()
    {
        return $this->hasMany(PinjamHeaderSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    // Relasi ke peminjaman non siswa
    public function pinjamHeaderNonSiswa()
    {
        return $this->hasMany(PinjamHeaderNonSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    // Override untuk Auth
    public function getAuthIdentifierName()
    {
        return 'KodePetugas';
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }
}
