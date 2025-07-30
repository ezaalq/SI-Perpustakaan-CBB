<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PinjamDetailNonSiswa extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    public function header()
    {
        return $this->belongsTo(PinjamHeaderNonSiswa::class, 'NoPinjamNS', 'NoPinjamNS');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'KodeBuku', 'KodeBuku');
    }
}
