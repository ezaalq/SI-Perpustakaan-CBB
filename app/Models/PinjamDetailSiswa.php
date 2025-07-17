<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinjamDetailSiswa extends Model
{
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

    public function header()
    {
        return $this->belongsTo(PinjamHeaderSiswa::class, 'NoPinjamS', 'NoPinjamS');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'KodeBuku', 'KodeBuku');
    }
}
