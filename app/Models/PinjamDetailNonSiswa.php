<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinjamDetailNonSiswa extends Model
{
    protected $table = 'pinjam_detail_non_siswa';
    public $timestamps = false;

    protected $fillable = [
        'NoPinjamNS',
        'KodeBuku',
        'Judul',
        'Penerbit',
        'ThnTerbit',
        'Jml'
    ];

    public function header()
    {
        return $this->belongsTo(PinjamHeaderNonSiswa::class, 'NoPinjamNS', 'NoPinjamNS');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'KodeBuku', 'KodeBuku');
    }
}
