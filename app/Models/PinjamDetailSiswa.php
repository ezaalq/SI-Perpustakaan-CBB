<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PinjamDetailSiswa extends Model
{
    use SoftDeletes;

    protected $table = 'pinjam_detail_siswa';
    public $timestamps = false;

    protected $fillable = [
        'NoPinjamS',
        'KodeBuku',
        'Judul',
        'Penerbit',
        'ThnTerbit',
        'Jml'
    ];

    protected $dates = ['deleted_at'];

    public function header()
    {
        return $this->belongsTo(PinjamHeaderSiswa::class, 'NoPinjamS', 'NoPinjamS');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'KodeBuku', 'KodeBuku');
    }
}
