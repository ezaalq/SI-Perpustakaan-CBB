<?php

namespace App\Http\Controllers;

use App\Models\PinjamHeaderSiswa;
use App\Models\KembaliSiswa;
use App\Models\PinjamHeaderNonSiswa;
use App\Models\KembaliNonSiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $siswa = \App\Models\PinjamHeaderSiswa::whereBetween('TglPinjam', [$from, $to])->get();
        $non = \App\Models\PinjamHeaderNonSiswa::whereBetween('TglPinjam', [$from, $to])->get();

        return view('laporan.peminjaman', compact('from', 'to', 'siswa', 'non'));
    }


    public function pengembalian(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $siswa = \App\Models\KembaliSiswa::whereBetween('TglKembali', [$from, $to])->get();
        $non = \App\Models\KembaliNonSiswa::whereBetween('TglKembali', [$from, $to])->get();

        return view('laporan.pengembalian', compact('from', 'to', 'siswa', 'non'));
    }
    public function buku()
    {
        $buku = \App\Models\Buku::all();
        return view('laporan.buku', compact('buku'));
    }
    public function anggota()
    {
        $siswa = \App\Models\AnggotaSiswa::all();
        $non = \App\Models\AnggotaNonSiswa::all();

        return view('laporan.anggota', compact('siswa', 'non'));
    }
    public function denda(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $siswa = \App\Models\KembaliSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])
            ->get();

        $non = \App\Models\KembaliNonSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])
            ->get();

        return view('laporan.denda', compact('from', 'to', 'siswa', 'non'));
    }
    public function peminjamanPdf(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $siswa = \App\Models\PinjamHeaderSiswa::whereBetween('TglPinjam', [$from, $to])->get();
        $non = \App\Models\PinjamHeaderNonSiswa::whereBetween('TglPinjam', [$from, $to])->get();

        $pdf = Pdf::loadView('laporan.pdf.peminjaman', compact('from', 'to', 'siswa', 'non'));
        return $pdf->download("laporan_peminjaman_{$from}_to_{$to}.pdf");
    }
    public function pengembalianPdf(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $siswa = \App\Models\KembaliSiswa::whereBetween('TglKembali', [$from, $to])->get();
        $non = \App\Models\KembaliNonSiswa::whereBetween('TglKembali', [$from, $to])->get();

        $pdf = Pdf::loadView('laporan.pdf.pengembalian', compact('from', 'to', 'siswa', 'non'));
        return $pdf->download("laporan_pengembalian_{$from}_to_{$to}.pdf");
    }
    public function bukuPdf()
    {
        $buku = \App\Models\Buku::all();
        $pdf = Pdf::loadView('laporan.pdf.buku', compact('buku'));
        return $pdf->download("laporan_buku.pdf");
    }
    public function anggotaPdf()
    {
        $siswa = \App\Models\AnggotaSiswa::all();
        $non = \App\Models\AnggotaNonSiswa::all();

        $pdf = Pdf::loadView('laporan.pdf.anggota', compact('siswa', 'non'));
        return $pdf->download("laporan_anggota.pdf");
    }
    public function dendaPdf(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $siswa = \App\Models\KembaliSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])->get();

        $non = \App\Models\KembaliNonSiswa::with(['pinjam.anggota'])
            ->where('Denda', '>', 0)
            ->whereBetween('TglKembali', [$from, $to])->get();

        $pdf = Pdf::loadView('laporan.pdf.denda', compact('from', 'to', 'siswa', 'non'));
        return $pdf->download("laporan_denda_{$from}_to_{$to}.pdf");
    }

}
