@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; align-items:flex-start; padding:20px; margin-top:80px;">
        <div
            style="background:rgba(255,255,255,0.95);padding:30px;border-radius:10px;max-width:1200px;width:95%;text-align:center;">

            <h1 style="margin-bottom:20px;">📄 Laporan Peminjaman</h1>

            {{-- Filter Tanggal & Search --}}
            <form method="GET" class="mb-4 d-flex justify-content-center gap-2" style="flex-wrap:wrap; gap:10px;">
                <input type="date" name="from" value="{{ $from }}"
                    style="padding:5px; border:1px solid #ccc; border-radius:4px;">
                <input type="date" name="to" value="{{ $to }}"
                    style="padding:5px; border:1px solid #ccc; border-radius:4px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota"
                    style="padding:5px; border:1px solid #ccc; border-radius:4px; width:200px;">
                <button class="btn btn-primary" style="padding:6px 12px;">🔍 Filter</button>
                <a href="{{ route('laporan.peminjaman.pdf', ['from' => $from, 'to' => $to, 'search' => request('search')]) }}"
                    target="_blank" style="
                        background-color: #28a745;
                        color: #fff;
                        font-weight: 500;
                        text-decoration: none;
                        padding: 6px 12px;
                        border-radius: 5px;">
                    📄 Cetak PDF
                </a>
            </form>

            {{-- Siswa --}}
            <h3 style="margin-top:30px;">Siswa</h3>
            <div style="overflow-x:auto; display:flex; justify-content:center; margin-bottom:30px;">
                <table class="table table-bordered table-striped text-center"
                    style="background:white; width:90%; max-width:1000px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>No</th>
                            <th>No Pinjam</th>
                            <th>Nama Anggota</th>
                            <th>Tanggal Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->NoPinjamS }}</td>
                                <td>{{ $s->anggota->NamaAnggota ?? $s->NoAnggotaS }}</td>
                                <td>{{ $s->TglPinjam }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Non Siswa --}}
            <h3 style="margin-top:30px;">Non Siswa</h3>
            <div style="overflow-x:auto; display:flex; justify-content:center;">
                <table class="table table-bordered table-striped text-center"
                    style="background:white; width:90%; max-width:1000px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>No</th>
                            <th>No Pinjam</th>
                            <th>Nama Anggota</th>
                            <th>Tanggal Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($non as $n)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $n->NoPinjamNS }}</td>
                                <td>{{ $n->anggota->NamaAnggota ?? $n->NoAnggotaNS }}</td>
                                <td>{{ $n->TglPinjam }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div style="width:100%; display:flex; justify-content:flex-end; margin-top:50px;">
                <div style="text-align:right;">
                    <p>Mengetahui,</p>
                    <p style="margin-bottom:60px;">Kepala Perpustakaan</p>
                    <p style="text-decoration:underline; font-weight:bold;">(___________________)</p>
                </div>
            </div>
        </div>
    </div>
@endsection