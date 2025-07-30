<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaSiswa extends Model
{
    use SoftDeletes;

    protected $table = 'anggota_siswa';
    protected $primaryKey = 'NoAnggotaS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NoAnggotaS',
        'NoInduk',
        'NamaAnggota',
        'TTL',
        'Alamat',
        'KodePos',
        'NoTelp',
        'Hp',
        'TglDaftar',
        'NamaOrtu',
        'AlamatOrtu',
        'NoTelpOrtu'
    ];

    protected $dates = ['deleted_at'];

    public function pinjamHeader()
    {
        return $this->hasMany(PinjamHeaderSiswa::class, 'NoAnggotaS', 'NoAnggotaS');
    }
}
