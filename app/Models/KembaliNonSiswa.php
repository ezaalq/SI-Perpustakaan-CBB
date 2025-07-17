<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KembaliNonSiswa extends Model
{
    protected $table = 'kembali_non_siswa';
    protected $primaryKey = 'NoKembaliNS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NoKembaliNS',
        'NoPinjamNS',
        'TglKembali',
        'KodePetugas',
        'Denda'
    ];

    public function pinjam()
    {
        return $this->belongsTo(PinjamHeaderNonSiswa::class, 'NoPinjamNS', 'NoPinjamNS');
    }
}
