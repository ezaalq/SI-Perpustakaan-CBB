<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KembaliSiswa extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    public function pinjam()
    {
        return $this->belongsTo(PinjamHeaderSiswa::class, 'NoPinjamS', 'NoPinjamS');
    }
}
