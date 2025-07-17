<?php

namespace App\Http\Controllers;

use App\Models\PinjamHeaderNonSiswa;
use App\Models\PinjamDetailNonSiswa;
use App\Models\Buku;
use App\Models\AnggotaNonSiswa;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanNonSiswaController extends Controller
{
    public function index()
    {
        $peminjaman = PinjamHeaderNonSiswa::with('detail')->get();
        return view('peminjaman_non_siswa.index', compact('peminjaman'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        $buku = Buku::where('JumEksemplar', '>', 0)->get();
        $anggota = AnggotaNonSiswa::all();
        $petugas = Petugas::all();

        return view('peminjaman_non_siswa.create', compact('kode', 'buku', 'anggota', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NoPinjamNS' => 'required|unique:pinjam_header_non_siswa,NoPinjamNS',
            'TglPinjam' => 'required|date',
            'TglKembali' => 'required|date|after_or_equal:TglPinjam',
            'NoAnggotaNS' => 'required|exists:anggota_non_siswa,NoAnggotaNS',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
            'detail' => 'required|array|min:1'
        ]);

        DB::transaction(function () use ($request) {
            $header = PinjamHeaderNonSiswa::create($request->only([
                'NoPinjamNS',
                'TglPinjam',
                'TglKembali',
                'NoAnggotaNS',
                'KodePetugas'
            ]));

            foreach ($request->detail as $row) {
                $buku = Buku::find($row['KodeBuku']);
                if (!$buku || $row['Jml'] > $buku->JumEksemplar) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'detail' => "Jumlah pinjam buku {$row['KodeBuku']} melebihi stok."
                    ]);
                }
                $buku->decrement('JumEksemplar', $row['Jml']);

                PinjamDetailNonSiswa::create([
                    'NoPinjamNS' => $header->NoPinjamNS,
                    'KodeBuku' => $row['KodeBuku'],
                    'Judul' => $row['Judul'],
                    'Penerbit' => $row['Penerbit'],
                    'ThnTerbit' => '',
                    'Jml' => $row['Jml'],
                ]);
            }
        });

        return redirect()->route('peminjaman-non-siswa.index')->with('success', 'Peminjaman Non Siswa berhasil disimpan.');
    }

    public function edit($id)
    {
        $header = PinjamHeaderNonSiswa::with('detail')->findOrFail($id);
        $buku = Buku::where('JumEksemplar', '>', 0)->get();
        $anggota = AnggotaNonSiswa::all();
        $petugas = Petugas::all();

        return view('peminjaman_non_siswa.edit', compact('header', 'buku', 'anggota', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TglPinjam' => 'required|date',
            'TglKembali' => 'required|date|after_or_equal:TglPinjam',
            'NoAnggotaNS' => 'required|exists:anggota_non_siswa,NoAnggotaNS',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
            'detail' => 'required|array|min:1'
        ]);

        DB::transaction(function () use ($request, $id) {
            $header = PinjamHeaderNonSiswa::findOrFail($id);
            $header->update($request->only(['TglPinjam', 'TglKembali', 'NoAnggotaNS', 'KodePetugas']));

            // kembalikan stok
            foreach ($header->detail as $d) {
                $buku = Buku::find($d->KodeBuku);
                $buku->increment('JumEksemplar', $d->Jml);
            }

            PinjamDetailNonSiswa::where('NoPinjamNS', $id)->delete();

            foreach ($request->detail as $row) {
                $buku = Buku::find($row['KodeBuku']);
                if (!$buku || $row['Jml'] > $buku->JumEksemplar) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'detail' => "Jumlah pinjam buku {$row['KodeBuku']} melebihi stok."
                    ]);
                }
                $buku->decrement('JumEksemplar', $row['Jml']);

                PinjamDetailNonSiswa::create([
                    'NoPinjamNS' => $header->NoPinjamNS,
                    'KodeBuku' => $row['KodeBuku'],
                    'Judul' => $row['Judul'],
                    'Penerbit' => $row['Penerbit'],
                    'ThnTerbit' => '',
                    'Jml' => $row['Jml'],
                ]);
            }
        });

        return redirect()->route('peminjaman-non-siswa.index')->with('success', 'Peminjaman Non Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $header = PinjamHeaderNonSiswa::with('detail')->findOrFail($id);
            foreach ($header->detail as $d) {
                Buku::find($d->KodeBuku)->increment('JumEksemplar', $d->Jml);
            }
            PinjamDetailNonSiswa::where('NoPinjamNS', $id)->delete();
            $header->delete();
        });

        return redirect()->route('peminjaman-non-siswa.index')->with('success', 'Peminjaman Non Siswa berhasil dihapus.');
    }

    private function generateKode()
    {
        $last = PinjamHeaderNonSiswa::orderBy('NoPinjamNS', 'desc')->first();
        $number = $last ? intval(substr($last->NoPinjamNS, 4)) + 1 : 1;
        return 'PMNS' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
