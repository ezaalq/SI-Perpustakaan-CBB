<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinjamHeaderNonSiswa extends Model
{
    protected $table = 'pinjam_header_non_siswa';
    protected $primaryKey = 'NoPinjamNS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NoPinjamNS',
        'TglPinjam',
        'TglKembali',
        'NoAnggotaNS',
        'KodePetugas'
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaNonSiswa::class, 'NoAnggotaNS', 'NoAnggotaNS');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'KodePetugas', 'KodePetugas');
    }

    public function detail()
    {
        return $this->hasMany(PinjamDetailNonSiswa::class, 'NoPinjamNS', 'NoPinjamNS');
    }

    public function pengembalian()
    {
        return $this->hasOne(KembaliNonSiswa::class, 'NoPinjamNS', 'NoPinjamNS');
    }
}
