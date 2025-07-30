@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; align-items:flex-start; padding:20px; margin-top:80px;">
        <div
            style="background:rgba(255,255,255,0.95);padding:30px;border-radius:10px;max-width:1200px;width:95%;text-align:center;">

            <h1 style="margin-bottom:20px;">📄 Daftar Petugas</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form Pencarian --}}
            <form action="{{ route('petugas.index') }}" method="GET" style="margin-bottom:15px; text-align:right;">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="🔍 Cari Nama / Jabatan / Akses / Kode"
                    style="padding:8px 12px; border:1px solid #ccc; border-radius:4px; width:280px;">
                <button type="submit"
                    style="padding:8px 12px; background:#28a745; color:white; border:none; border-radius:4px;">
                    Cari
                </button>
            </form>

            <div style="text-align:right; margin-bottom:15px;">
                <a href="{{ route('petugas.create') }}" style="
                            background-color: #28a745;
                            color: #fff;
                            font-weight: 500;
                            text-decoration: none;
                            padding: 10px 15px;
                            border-radius: 5px;
                            display:inline-flex;
                            align-items:center;
                            gap:6px;">
                    ➕ Tambah Petugas
                </a>
            </div>

            <div style="overflow-x:auto; display:flex; justify-content:center;">
                <table class="table table-bordered table-striped table-hover text-center"
                    style="background:white; width:90%; max-width:1100px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Hak Akses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($petugas as $p)
                            <tr>
                                <td>{{ $p->KodePetugas }}</td>
                                <td>{{ $p->Nama }}</td>
                                <td>{{ $p->Jabatan }}</td>
                                <td>{{ $p->HakAkses }}</td>
                                <td>
                                    <div style="display:flex; justify-content:center; gap:8px;">
                                        <a href="{{ route('petugas.edit', $p->KodePetugas) }}" style="
                                                            background-color: #ffc107;
                                                            color: #212529;
                                                            text-decoration:none;
                                                            padding:6px 12px;
                                                            border-radius:4px;
                                                            display:inline-flex;
                                                            align-items:center;
                                                            gap:4px;">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('petugas.destroy', $p->KodePetugas) }}" method="POST"
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
                        @empty
                            <tr>
                                <td colspan="5">📭 Tidak ada data petugas ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $petugas->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection