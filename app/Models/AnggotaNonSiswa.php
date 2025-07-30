<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaNonSiswa extends Model
{
    use SoftDeletes;

    protected $table = 'anggota_non_siswa';
    protected $primaryKey = 'NoAnggotaNS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NoAnggotaNS',
        'NIP',
        'NamaAnggota',
        'Jabatan',
        'TTL',
        'Alamat',
        'KodePos',
        'NoTelp',
        'Hp',
        'TglDaftar'
    ];

    protected $dates = ['deleted_at'];

    public function pinjamHeader()
    {
        return $this->hasMany(PinjamHeaderNonSiswa::class, 'NoAnggotaNS', 'NoAnggotaNS');
    }
}
