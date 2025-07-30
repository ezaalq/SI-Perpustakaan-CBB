<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KembaliNonSiswa extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    public function pinjam()
    {
        return $this->belongsTo(PinjamHeaderNonSiswa::class, 'NoPinjamNS', 'NoPinjamNS');
    }
}
