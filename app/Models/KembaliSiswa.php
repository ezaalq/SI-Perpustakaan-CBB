<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KembaliSiswa extends Model
{
    protected $table = 'kembali_siswa';
    protected $primaryKey = 'NoKembaliS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NoKembaliS',
        'NoPinjamS',
        'TglKembali',
        'KodePetugas',
        'Denda'
    ];

    public function pinjam()
    {
        return $this->belongsTo(PinjamHeaderSiswa::class, 'NoPinjamS', 'NoPinjamS');
    }
}
