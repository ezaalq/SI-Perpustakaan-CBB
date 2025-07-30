<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PinjamHeaderNonSiswa extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

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
