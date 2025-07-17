@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; align-items:flex-start; padding:20px; margin-top:80px;">
        <div
            style="background:rgba(255,255,255,0.95);padding:30px;border-radius:10px;max-width:1100px;width:95%;text-align:center;">

            <h1 style="margin-bottom:20px;">📄 Daftar Anggota Non Siswa</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div style="text-align:right; margin-bottom:15px;">
                <a href="{{ route('anggota-non-siswa.create') }}" style="
                        background-color: #28a745;
                        color: #fff;
                        font-weight: 500;
                        text-decoration: none;
                        padding: 10px 15px;
                        border-radius: 5px;
                        display:inline-flex;
                        align-items:center;
                        gap:6px;">
                    ➕ Tambah Anggota
                </a>
            </div>

            <div style="overflow-x:auto; display:flex; justify-content:center;">
                <table class="table table-bordered table-striped table-hover text-center"
                    style="background:white; width:90%; max-width:1000px;">
                    <thead style="background:#28a745; color:white;">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Jabatan</th>
                            <th>TTL</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggota as $a)
                            <tr>
                                <td>{{ $a->NoAnggotaNS }}</td>
                                <td>{{ $a->NamaAnggota }}</td>
                                <td>{{ $a->NIP }}</td>
                                <td>{{ $a->Jabatan }}</td>
                                <td>{{ $a->TTL }}</td>
                                <td>{{ $a->Alamat }}</td>
                                <td>
                                    <div style="display:flex; justify-content:center; gap:8px;">
                                        <a href="{{ route('anggota-non-siswa.edit', $a->NoAnggotaNS) }}" style="
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
                                        <form action="{{ route('anggota-non-siswa.destroy', $a->NoAnggotaNS) }}" method="POST"
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