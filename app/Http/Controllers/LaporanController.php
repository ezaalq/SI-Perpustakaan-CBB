<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Buku;
use App\Models\AnggotaSiswa;
use App\Models\AnggotaNonSiswa;
use App\Models\PinjamHeaderSiswa;
use App\Models\PinjamHeaderNonSiswa;
use App\Models\KembaliSiswa;
use App\Models\KembaliNonSiswa;

class LaporanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();
        $search = $request->search;

        $siswa = PinjamHeaderSiswa::with(['anggota'])
            ->whereBetween('TglPinjam', [$from, $to])
            ->whereHas('anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })
            ->whereNull('deleted_at')
            ->paginate(10)
            ->withQueryString();

        $non = PinjamHeaderNonSiswa::with(['anggota'])
            ->whereBetween('TglPinjam', [$from, $to])
            ->whereHas('anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })
            ->whereNull('deleted_at')
            ->paginate(10, ['*'], 'non_page')
            ->withQueryString();

        return view('laporan.peminjaman', compact('from', 'to', 'search', 'siswa', 'non'));
    }

    public function pengembalian(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();
        $search = $request->search;

        $siswa = KembaliSiswa::with(['pinjam.anggota'])
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })
            ->whereNull('deleted_at')
            ->paginate(10)
            ->withQueryString();

        $non = KembaliNonSiswa::with(['pinjam.anggota'])
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })
            ->whereNull('deleted_at')
            ->paginate(10, ['*'], 'non_page')
            ->withQueryString();

        return view('laporan.pengembalian', compact('from', 'to', 'search', 'siswa', 'non'));
    }

    public function buku()
    {
        $buku = Buku::whereNull('deleted_at')->latest('KodeBuku')->paginate(10);
        return view('laporan.buku', compact('buku'));
    }

    public function anggota(Request $request)
    {
        $search = $request->search;

        $siswa = AnggotaSiswa::whereNull('deleted_at')
            ->when($search, fn($q) => $q->where('NamaAnggota', 'like', "%$search%"))
            ->latest('NoAnggotaS')->paginate(10);

        $non = AnggotaNonSiswa::whereNull('deleted_at')
            ->when($search, fn($q) => $q->where('NamaAnggota', 'like', "%$search%"))
            ->latest('NoAnggotaNS')->paginate(10, ['*'], 'non_page');

        return view('laporan.anggota', compact('search', 'siswa', 'non'));
    }

    public function denda(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();
        $search = $request->search;

        $siswa = KembaliSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })
            ->whereNull('deleted_at')
            ->paginate(10)
            ->withQueryString();

        $non = KembaliNonSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })
            ->whereNull('deleted_at')
            ->paginate(10, ['*'], 'non_page')
            ->withQueryString();

        return view('laporan.denda', compact('from', 'to', 'search', 'siswa', 'non'));
    }

    // ==================== PDF ====================

    public function peminjamanPdf(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();
        $search = $request->search;

        $siswa = PinjamHeaderSiswa::with(['anggota'])
            ->whereBetween('TglPinjam', [$from, $to])
            ->whereHas('anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })->whereNull('deleted_at')->get();

        $non = PinjamHeaderNonSiswa::with(['anggota'])
            ->whereBetween('TglPinjam', [$from, $to])
            ->whereHas('anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })->whereNull('deleted_at')->get();

        $pdf = Pdf::loadView('laporan.pdf.peminjaman', compact('from', 'to', 'search', 'siswa', 'non'));
        return $pdf->download("laporan_peminjaman_{$from}_to_{$to}.pdf");
    }

    public function pengembalianPdf(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();
        $search = $request->search;

        $siswa = KembaliSiswa::with(['pinjam.anggota'])
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })->whereNull('deleted_at')->get();

        $non = KembaliNonSiswa::with(['pinjam.anggota'])
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })->whereNull('deleted_at')->get();

        $pdf = Pdf::loadView('laporan.pdf.pengembalian', compact('from', 'to', 'search', 'siswa', 'non'));
        return $pdf->download("laporan_pengembalian_{$from}_to_{$to}.pdf");
    }

    public function bukuPdf()
    {
        $buku = Buku::whereNull('deleted_at')->get();
        $pdf = Pdf::loadView('laporan.pdf.buku', compact('buku'));
        return $pdf->download("laporan_buku.pdf");
    }

    public function anggotaPdf(Request $request)
    {
        $search = $request->search;

        $siswa = AnggotaSiswa::whereNull('deleted_at')
            ->when($search, fn($q) => $q->where('NamaAnggota', 'like', "%$search%"))
            ->get();

        $non = AnggotaNonSiswa::whereNull('deleted_at')
            ->when($search, fn($q) => $q->where('NamaAnggota', 'like', "%$search%"))
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.anggota', compact('siswa', 'non', 'search'));
        return $pdf->download("laporan_anggota.pdf");
    }

    public function dendaPdf(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();
        $search = $request->search;

        $siswa = KembaliSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })->whereNull('deleted_at')->get();

        $non = KembaliNonSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])
            ->whereHas('pinjam.anggota', function ($q) use ($search) {
                if ($search)
                    $q->where('NamaAnggota', 'like', "%$search%");
            })->whereNull('deleted_at')->get();

        $pdf = Pdf::loadView('laporan.pdf.denda', compact('from', 'to', 'search', 'siswa', 'non'));
        return $pdf->download("laporan_denda_{$from}_to_{$to}.pdf");
    }
}
