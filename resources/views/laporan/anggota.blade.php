@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; align-items:flex-start; padding:20px; margin-top:80px;">
        <div
            style="background:rgba(255,255,255,0.95);padding:30px;border-radius:10px;max-width:1200px;width:95%;text-align:center;">

            <h1 style="margin-bottom:20px;">📄 Laporan Anggota</h1>

            {{-- Tombol Cetak PDF --}}
            <div style="text-align:right; margin-bottom:20px;">
                <a href="{{ route('laporan.anggota.pdf') }}" target="_blank" style="
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
            <form method="GET" action="{{ route('laporan.anggota') }}" style="margin-bottom:30px;">
                <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                    <input type="text" name="search_siswa" placeholder="Cari Siswa..." value="{{ request('search_siswa') }}"
                        style="padding:10px; width:250px; border-radius:5px; border:1px solid #ccc;">
                    <input type="text" name="search_non" placeholder="Cari Non Siswa..." value="{{ request('search_non') }}"
                        style="padding:10px; width:250px; border-radius:5px; border:1px solid #ccc;">
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

            {{-- Tabel Siswa --}}
            <h3 style="margin:20px 0;">👨‍🎓 Siswa</h3>
            <div style="overflow-x:auto; display:flex; justify-content:center;">
                <table class="table table-bordered table-striped table-hover text-center"
                    style="background:white; width:90%; max-width:1000px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>TTL</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                            <tr>
                                <td>{{ $s->NoAnggotaS }}</td>
                                <td>{{ $s->NamaAnggota }}</td>
                                <td>{{ $s->TTL }}</td>
                                <td>{{ $s->Alamat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Tidak ada data siswa ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tabel Non Siswa --}}
            <h3 style="margin:40px 0 20px;">👨‍💼 Non Siswa</h3>
            <div style="overflow-x:auto; display:flex; justify-content:center;">
                <table class="table table-bordered table-striped table-hover text-center"
                    style="background:white; width:90%; max-width:1000px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($non as $n)
                            <tr>
                                <td>{{ $n->NoAnggotaNS }}</td>
                                <td>{{ $n->NamaAnggota }}</td>
                                <td>{{ $n->Jabatan }}</td>
                                <td>{{ $n->Alamat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Tidak ada data non-siswa ditemukan.</td>
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