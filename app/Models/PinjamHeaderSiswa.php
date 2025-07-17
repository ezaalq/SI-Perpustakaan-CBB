<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinjamHeaderSiswa extends Model
{
    protected $table = 'pinjam_header_siswa';
    protected $primaryKey = 'NoPinjamS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NoPinjamS',
        'TglPinjam',
        'TglKembali',
        'NoAnggotaS',
        'KodePetugas'
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaSiswa::class, 'NoAnggotaS', 'NoAnggotaS');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'KodePetugas', 'KodePetugas');
    }

    public function detail()
    {
        return $this->hasMany(PinjamDetailSiswa::class, 'NoPinjamS', 'NoPinjamS');
    }

    public function pengembalian()
    {
        return $this->hasOne(KembaliSiswa::class, 'NoPinjamS', 'NoPinjamS');
    }
}
