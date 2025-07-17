<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'KodeBuku';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'KodeBuku',
        'NoUDC',
        'NoReg',
        'Judul',
        'Penerbit',
        'Pengarang',
        'ThnTerbit',
        'KotaTerbit',
        'Bahasa',
        'Edisi',
        'Deskripsi',
        'Isbn',
        'JumEksemplar',
        'SubyekUtama',
        'SubyekTambahan'
    ];

    public function pinjamDetailSiswa()
    {
        return $this->hasMany(PinjamDetailSiswa::class, 'KodeBuku', 'KodeBuku');
    }

    public function pinjamDetailNonSiswa()
    {
        return $this->hasMany(PinjamDetailNonSiswa::class, 'KodeBuku', 'KodeBuku');
    }
}
