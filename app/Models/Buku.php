<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    public function pinjamDetailSiswa()
    {
        return $this->hasMany(PinjamDetailSiswa::class, 'KodeBuku', 'KodeBuku');
    }

    public function pinjamDetailNonSiswa()
    {
        return $this->hasMany(PinjamDetailNonSiswa::class, 'KodeBuku', 'KodeBuku');
    }
}
