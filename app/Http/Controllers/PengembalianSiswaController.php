<?php

namespace App\Http\Controllers;

use App\Models\KembaliSiswa;
use App\Models\PinjamHeaderSiswa;
use App\Models\PinjamDetailSiswa;
use App\Models\Petugas;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianSiswaController extends Controller
{
    public function index()
    {
        $pengembalian = KembaliSiswa::with(['pinjam', 'pinjam.detail'])->get();
        return view('pengembalian_siswa.index', compact('pengembalian'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        $pinjaman = PinjamHeaderSiswa::with('detail')->get();
        $petugas = Petugas::all();

        return view('pengembalian_siswa.create', compact('kode', 'pinjaman', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NoKembaliS' => 'required|unique:kembali_siswa,NoKembaliS',
            'NoPinjamS' => 'required|exists:pinjam_header_siswa,NoPinjamS',
            'TglKembali' => 'required|date',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
        ]);

        DB::transaction(function () use ($request) {

            $denda = $this->hitungDenda($request->NoPinjamS, $request->TglKembali);

            KembaliSiswa::create([
                'NoKembaliS' => $request->NoKembaliS,
                'NoPinjamS' => $request->NoPinjamS,
                'TglKembali' => $request->TglKembali,
                'KodePetugas' => $request->KodePetugas,
                'Denda' => $denda,
            ]);

            // Update stok buku kembali
            $details = PinjamDetailSiswa::where('NoPinjamS', $request->NoPinjamS)->get();

            foreach ($details as $detail) {
                $buku = Buku::find($detail->KodeBuku);
                if ($buku) {
                    $buku->JumEksemplar += $detail->Jml;
                    $buku->save();
                }
            }
        });

        return redirect()->route('pengembalian-siswa.index')
            ->with('success', '✅ Pengembalian berhasil disimpan & stok buku diperbarui.');
    }

    public function edit($id)
    {
        $kembali = KembaliSiswa::findOrFail($id);
        $pinjaman = PinjamHeaderSiswa::with('detail')->get();
        $petugas = Petugas::all();

        return view('pengembalian_siswa.edit', compact('kembali', 'pinjaman', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NoPinjamS' => 'required|exists:pinjam_header_siswa,NoPinjamS',
            'TglKembali' => 'required|date',
            'KodePetugas' => 'required|exists:petugas,KodePetugas',
        ]);

        $kembali = KembaliSiswa::findOrFail($id);

        DB::transaction(function () use ($kembali, $request) {

            $denda = $this->hitungDenda($request->NoPinjamS, $request->TglKembali);

            $kembali->update([
                'NoPinjamS' => $request->NoPinjamS,
                'TglKembali' => $request->TglKembali,
                'KodePetugas' => $request->KodePetugas,
                'Denda' => $denda,
            ]);
        });

        return redirect()->route('pengembalian-siswa.index')
            ->with('success', '✅ Pengembalian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        KembaliSiswa::where('NoKembaliS', $id)->delete();

        return redirect()->route('pengembalian-siswa.index')
            ->with('success', '🗑️ Pengembalian berhasil dihapus.');
    }

    /**
     * Hitung Denda
     */
    private function hitungDenda($NoPinjamS, $TglKembali)
    {
        $pinjam = PinjamHeaderSiswa::with('detail')->findOrFail($NoPinjamS);

        $jatuhTempo = Carbon::parse($pinjam->TglKembali);
        $tglKembali = Carbon::parse($TglKembali);

        $selisihHari = $tglKembali->diffInDays($jatuhTempo, false); // negatif jika telat

        if ($selisihHari >= 0)
            return 0; // tidak telat

        $jumlahBuku = $pinjam->detail->sum('Jml');

        return abs($selisihHari) * $jumlahBuku * 1000;
    }

    /**
     * Generate NoKembaliS
     */
    private function generateKode()
    {
        $last = KembaliSiswa::orderBy('NoKembaliS', 'desc')->first();
        $number = $last ? intval(substr($last->NoKembaliS, 2)) + 1 : 1;
        return 'KB' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * API: Peminjaman detail untuk AJAX
     */
    public function getPeminjaman($no)
    {
        $pinjam = PinjamHeaderSiswa::with('detail')->findOrFail($no);
        return response()->json([
            'TglPinjam' => $pinjam->TglPinjam,
            'TglKembali' => $pinjam->TglKembali
        ]);
    }
}
