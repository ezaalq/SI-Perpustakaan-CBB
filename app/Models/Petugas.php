<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
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

    // relasi
    public function pinjamHeaderSiswa()
    {
        return $this->hasMany(PinjamHeaderSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    public function pinjamHeaderNonSiswa()
    {
        return $this->hasMany(PinjamHeaderNonSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    // supaya Auth pakai kolom KodePetugas & Password
    public function getAuthIdentifierName()
    {
        return 'KodePetugas';
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }
}
