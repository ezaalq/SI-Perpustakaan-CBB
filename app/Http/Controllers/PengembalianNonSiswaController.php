<?php

namespace App\Http\Controllers;

use App\Models\KembaliNonSiswa;
use App\Models\PinjamHeaderNonSiswa;
use App\Models\Petugas;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianNonSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = KembaliNonSiswa::with(['pinjam.anggota', 'pinjam.detail']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('NoKembaliNS', 'like', "%$q%")
                ->orWhereHas('pinjam.anggota', function ($sub) use ($q) {
                    $sub->where('NamaAnggota', 'like', "%$q%");
                });
        }

        $pengembalian = $query->orderBy('TglKembali', 'desc')->paginate(10)->withQueryString();

        return view('pengembalian_non_siswa.index', compact('pengembalian'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        $pinjaman = PinjamHeaderNonSiswa::with('detail')->get();
        $petugas = Petugas::all();

        return view('pengembalian_non_siswa.create', compact('kode', 'pinjaman', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NoKembaliNS' => 'required|unique:kembali_non_siswa,NoKembaliNS',
            'NoPinjamNS' => 'required|exists:pinjam_header_non_siswa,NoPinjamNS',
            'TglKembali' => 'required|date',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
        ]);

        DB::transaction(function () use ($request) {
            $denda = $this->hitungDenda($request->NoPinjamNS, $request->TglKembali);

            KembaliNonSiswa::create([
                'NoKembaliNS' => $request->NoKembaliNS,
                'NoPinjamNS' => $request->NoPinjamNS,
                'TglKembali' => $request->TglKembali,
                'KodePetugas' => $request->KodePetugas,
                'Denda' => $denda,
            ]);

            // Tambahkan kembali stok buku
            $pinjam = PinjamHeaderNonSiswa::with('detail')->findOrFail($request->NoPinjamNS);
            foreach ($pinjam->detail as $item) {
                Buku::where('KodeBuku', $item->KodeBuku)->increment('JumEksemplar', $item->Jml);
            }
        });

        return redirect()->route('pengembalian-non-siswa.index')
            ->with('success', '✅ Pengembalian Non Siswa berhasil disimpan.');
    }

    public function edit($id)
    {
        $kembali = KembaliNonSiswa::findOrFail($id);
        $pinjaman = PinjamHeaderNonSiswa::with('detail')->get();
        $petugas = Petugas::all();

        return view('pengembalian_non_siswa.edit', compact('kembali', 'pinjaman', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NoPinjamNS' => 'required|exists:pinjam_header_non_siswa,NoPinjamNS',
            'TglKembali' => 'required|date',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
        ]);

        DB::transaction(function () use ($request, $id) {
            $kembali = KembaliNonSiswa::findOrFail($id);

            $denda = $this->hitungDenda($request->NoPinjamNS, $request->TglKembali);

            $kembali->update([
                'NoPinjamNS' => $request->NoPinjamNS,
                'TglKembali' => $request->TglKembali,
                'KodePetugas' => $request->KodePetugas,
                'Denda' => $denda,
            ]);
        });

        return redirect()->route('pengembalian-non-siswa.index')
            ->with('success', '✅ Pengembalian Non Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        KembaliNonSiswa::where('NoKembaliNS', $id)->delete(); // soft delete

        return redirect()->route('pengembalian-non-siswa.index')
            ->with('success', '🗑️ Pengembalian Non Siswa berhasil dihapus.');
    }

    /**
     * Hitung Denda
     */
    private function hitungDenda($NoPinjamNS, $TglKembali)
    {
        $pinjam = PinjamHeaderNonSiswa::with('detail')->findOrFail($NoPinjamNS);
        $jatuhTempo = Carbon::parse($pinjam->TglKembali);
        $tglKembali = Carbon::parse($TglKembali);
        $selisihHari = $tglKembali->diffInDays($jatuhTempo, false);

        if ($selisihHari >= 0)
            return 0;

        $jumlahBuku = $pinjam->detail->sum('Jml');
        return abs($selisihHari) * $jumlahBuku * 1000;
    }

    /**
     * Generate NoKembaliNS
     */
    private function generateKode()
    {
        $last = KembaliNonSiswa::orderBy('NoKembaliNS', 'desc')->first();
        $number = $last ? intval(substr($last->NoKembaliNS, 3)) + 1 : 1;
        return 'KBN' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * API: Peminjaman detail untuk AJAX
     */
    public function getPeminjaman($no)
    {
        $pinjam = PinjamHeaderNonSiswa::findOrFail($no);
        return response()->json([
            'TglPinjam' => $pinjam->TglPinjam,
            'TglKembali' => $pinjam->TglKembali
        ]);
    }
}
