@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; align-items:flex-start; padding:20px; margin-top:80px;">
        <div
            style="background:rgba(255,255,255,0.95);padding:30px;border-radius:10px;max-width:1200px;width:95%;text-align:center;">

            <h1 style="margin-bottom:20px;">📄 Laporan Buku</h1>

            {{-- Tombol Cetak PDF --}}
            <div style="text-align:right; margin-bottom:20px;">
                <a href="{{ route('laporan.buku.pdf') }}" target="_blank" style="
                        background-color: #28a745;
                        color: #fff;
                        font-weight: 500;
                        text-decoration: none;
                        padding: 10px 15px;
                        border-radius: 5px;
                        display:inline-flex;
                        align-items:center;
                        gap:6px;">
                    📄 Cetak PDF
                </a>
            </div>

            {{-- Form Searching --}}
            <form method="GET" action="{{ route('laporan.buku') }}" style="margin-bottom:30px;">
                <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                    <input type="text" name="search" placeholder="Cari buku..." value="{{ request('search') }}"
                        style="padding:10px; width:300px; border-radius:5px; border:1px solid #ccc;">
                    <button type="submit" style="
                            background-color:#007bff;
                            color:white;
                            border:none;
                            padding:10px 15px;
                            border-radius:5px;
                            cursor:pointer;">
                        🔍 Cari
                    </button>
                </div>
            </form>

            {{-- Tabel Buku --}}
            <div style="overflow-x:auto; display:flex; justify-content:center;">
                <table class="table table-bordered table-striped table-hover text-center"
                    style="background:white; width:90%; max-width:1000px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buku as $b)
                            <tr>
                                <td>{{ $b->KodeBuku }}</td>
                                <td>{{ $b->Judul }}</td>
                                <td>{{ $b->Pengarang }}</td>
                                <td>{{ $b->Penerbit }}</td>
                                <td>{{ $b->ThnTerbit }}</td>
                                <td>{{ $b->JumEksemplar }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Tidak ada data buku ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tanda Tangan --}}
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