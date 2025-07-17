@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; align-items:flex-start; padding:20px; margin-top:80px;">
        <div
            style="background:rgba(255,255,255,0.95);padding:30px;border-radius:10px;max-width:1200px;width:95%;text-align:center;">

            <h1 style="margin-bottom:20px;">📄 Daftar Pengembalian Siswa</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div style="text-align:right; margin-bottom:15px;">
                <a href="{{ route('pengembalian-siswa.create') }}" style="
                        background-color: #28a745;
                        color: #fff;
                        font-weight: 500;
                        text-decoration: none;
                        padding: 10px 15px;
                        border-radius: 5px;
                        display:inline-flex;
                        align-items:center;
                        gap:6px;">
                    ➕ Tambah Pengembalian
                </a>
            </div>

            <div style="overflow-x:auto; display:flex; justify-content:center;">
                <table class="table table-bordered table-striped table-hover text-center"
                    style="background:white; width:90%; max-width:1100px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>No Kembali</th>
                            <th>No Pinjam</th>
                            <th>No Anggota</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $p)
                            <tr>
                                <td>{{ $p->NoKembaliS }}</td>
                                <td>{{ $p->NoPinjamS }}</td>
                                <td>{{ $p->pinjam->NoAnggotaS }}</td>
                                <td>{{ $p->pinjam->TglPinjam }}</td>
                                <td>{{ $p->TglKembali }}</td>
                                <td>{{ $p->Denda }}</td>
                                <td>
                                    <div style="display:flex; justify-content:center; gap:8px;">
                                        <a href="{{ route('pengembalian-siswa.edit', $p->NoKembaliS) }}" style="
                                                    background-color: #ffc107;
                                                    color: #212529;
                                                    text-decoration:none;
                                                    padding:6px 12px;
                                                    border-radius:4px;
                                                    display:inline-flex;
                                                    align-items:center;
                                                    gap:4px;">
                                            ✏️ Ubah
                                        </a>
                                        <form action="{{ route('pengembalian-siswa.destroy', $p->NoKembaliS) }}" method="POST"
                                            onsubmit="return confirm('Hapus?')" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="
                                                        background-color: #dc3545;
                                                        color: #fff;
                                                        border:none;
                                                        padding:6px 12px;
                                                        border-radius:4px;
                                                        cursor:pointer;
                                                        display:inline-flex;
                                                        align-items:center;
                                                        gap:4px;">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection