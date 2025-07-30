@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; align-items:flex-start; padding:20px; margin-top:80px;">
        <div
            style="background:rgba(255,255,255,0.95);padding:30px;border-radius:10px;max-width:1100px;width:95%;text-align:center;">

            <h1 style="margin-bottom:20px;">📚 Daftar Buku</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form Pencarian --}}
            <form action="{{ route('buku.index') }}" method="GET" style="margin-bottom:15px; text-align:right;">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="🔍 Cari judul atau pengarang..."
                    style="padding:8px 12px; border:1px solid #ccc; border-radius:4px; width:250px;">
                <button type="submit"
                    style="padding:8px 12px; background:#28a745; color:white; border:none; border-radius:4px;">
                    Cari
                </button>
            </form>

            <div style="text-align:right; margin-bottom:15px;">
                <a href="{{ route('buku.create') }}" style="
                        background-color: #28a745;
                        color: #fff;
                        font-weight: 500;
                        text-decoration: none;
                        padding: 10px 15px;
                        border-radius: 5px;
                        display:inline-flex;
                        align-items:center;
                        gap:6px;">
                    ➕ Tambah Buku
                </a>
            </div>

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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($buku as $b)
                            <tr>
                                <td>{{ $b->KodeBuku }}</td>
                                <td>{{ $b->Judul }}</td>
                                <td>{{ $b->Pengarang }}</td>
                                <td>{{ $b->Penerbit }}</td>
                                <td>{{ $b->ThnTerbit }}</td>
                                <td>{{ $b->JumEksemplar }}</td>
                                <td>
                                    <div style="display:flex; justify-content:center; gap:8px;">
                                        <a href="{{ route('buku.edit', $b->KodeBuku) }}" style="
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
                                        <form action="{{ route('buku.destroy', $b->KodeBuku) }}" method="POST"
                                            onsubmit="return confirm('Hapus buku ini?')" style="display:inline-block;">
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
                                <td colspan="7">📭 Tidak ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $buku->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection