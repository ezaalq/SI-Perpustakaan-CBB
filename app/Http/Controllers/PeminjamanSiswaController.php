<?php

namespace App\Http\Controllers;

use App\Models\PinjamHeaderSiswa;
use App\Models\PinjamDetailSiswa;
use App\Models\Buku;
use App\Models\AnggotaSiswa;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = PinjamHeaderSiswa::with('detail', 'anggota');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('NoPinjamS', 'like', "%$q%")
                ->orWhereHas('anggota', fn($q1) => $q1->where('NamaAnggota', 'like', "%$q%"));
        }

        $peminjaman = $query->latest('TglPinjam')->paginate(10)->withQueryString();

        return view('peminjaman_siswa.index', compact('peminjaman'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        $buku = Buku::where('JumEksemplar', '>', 0)->get();
        $anggota = AnggotaSiswa::all();
        $petugas = Petugas::all();

        return view('peminjaman_siswa.create', compact('kode', 'buku', 'anggota', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NoPinjamS' => 'required|unique:pinjam_header_siswa,NoPinjamS',
            'TglPinjam' => 'required|date',
            'TglKembali' => 'required|date|after_or_equal:TglPinjam',
            'NoAnggotaS' => 'required|exists:anggota_siswa,NoAnggotaS',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
            'detail' => 'required|array|min:1'
        ]);

        DB::transaction(function () use ($request) {
            $header = PinjamHeaderSiswa::create($request->only([
                'NoPinjamS',
                'TglPinjam',
                'TglKembali',
                'NoAnggotaS',
                'KodePetugas'
            ]));

            foreach ($request->detail as $row) {
                $buku = Buku::findOrFail($row['KodeBuku']);
                if ($row['Jml'] > $buku->JumEksemplar) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'detail' => "Jumlah pinjam untuk buku {$row['KodeBuku']} melebihi stok."
                    ]);
                }

                $buku->decrement('JumEksemplar', $row['Jml']);

                PinjamDetailSiswa::create([
                    'NoPinjamS' => $header->NoPinjamS,
                    'KodeBuku' => $row['KodeBuku'],
                    'Judul' => $row['Judul'],
                    'Penerbit' => $row['Penerbit'],
                    'ThnTerbit' => '',
                    'Jml' => $row['Jml'],
                ]);
            }
        });

        return redirect()->route('peminjaman-siswa.index')
            ->with('success', '✅ Peminjaman berhasil disimpan.');
    }

    public function edit($id)
    {
        $header = PinjamHeaderSiswa::with('detail')->findOrFail($id);
        $anggota = AnggotaSiswa::all();
        $petugas = Petugas::all();
        $buku = Buku::where('JumEksemplar', '>=', 0)->get();

        return view('peminjaman_siswa.edit', compact('header', 'anggota', 'petugas', 'buku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TglPinjam' => 'required|date',
            'TglKembali' => 'required|date|after_or_equal:TglPinjam',
            'NoAnggotaS' => 'required|exists:anggota_siswa,NoAnggotaS',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
            'detail' => 'required|array|min:1'
        ]);

        DB::transaction(function () use ($request, $id) {
            $header = PinjamHeaderSiswa::with('detail')->findOrFail($id);

            foreach ($header->detail as $d) {
                Buku::find($d->KodeBuku)?->increment('JumEksemplar', $d->Jml);
            }

            $header->update($request->only([
                'TglPinjam',
                'TglKembali',
                'NoAnggotaS',
                'KodePetugas'
            ]));

            PinjamDetailSiswa::where('NoPinjamS', $id)->delete();

            foreach ($request->detail as $row) {
                $buku = Buku::findOrFail($row['KodeBuku']);
                if ($row['Jml'] > $buku->JumEksemplar) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'detail' => "Jumlah pinjam untuk buku {$row['KodeBuku']} melebihi stok."
                    ]);
                }

                $buku->decrement('JumEksemplar', $row['Jml']);

                PinjamDetailSiswa::create([
                    'NoPinjamS' => $header->NoPinjamS,
                    'KodeBuku' => $row['KodeBuku'],
                    'Judul' => $row['Judul'],
                    'Penerbit' => $row['Penerbit'],
                    'ThnTerbit' => '',
                    'Jml' => $row['Jml'],
                ]);
            }
        });

        return redirect()->route('peminjaman-siswa.index')
            ->with('success', '✅ Peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $header = PinjamHeaderSiswa::with('detail')->findOrFail($id);

            foreach ($header->detail as $d) {
                Buku::find($d->KodeBuku)?->increment('JumEksemplar', $d->Jml);
            }

            PinjamDetailSiswa::where('NoPinjamS', $id)->delete();
            $header->delete(); // soft delete
        });

        return redirect()->route('peminjaman-siswa.index')
            ->with('success', '🗑️ Peminjaman berhasil dihapus.');
    }

    private function generateKode()
    {
        $last = PinjamHeaderSiswa::orderBy('NoPinjamS', 'desc')->first();
        $number = $last ? intval(substr($last->NoPinjamS, 2)) + 1 : 1;
        return 'PM' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
