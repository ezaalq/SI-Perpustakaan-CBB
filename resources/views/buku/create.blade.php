@extends('layouts.form')

@section('content')
    <h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#000; margin-bottom:20px;">
        ➕ Tambah Buku
    </h2>

    <form method="POST" action="{{ route('buku.store') }}">
        @csrf

        <div class="row justify-content-center">
            <div class="mb-2">
                <label>KodeBuku</label>
                <input name="KodeBuku" value="{{ $kode }}" class="form-control form-control-lg" readonly>
            </div>

            @foreach ([
                    'NoUDC',
                    'NoReg',
                    'Judul',
                    'Penerbit',
                    'Pengarang',
                    'ThnTerbit',
                    'KotaTerbit',
                    'Bahasa',
                    'Edisi',
                    'Deskripsi',
                    'Isbn',
                    'JumEksemplar',
                    'SubyekUtama',
                    'SubyekTambahan'
                ] as $field)
                            <div class="mb-3">
                                <label style="font-weight:600; color:#28a745;">{{ $field }}</label>
                                <input name="{{ $field }}" class="form-control form-control-lg">
                            </div>
            @endforeach

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success px-4">💾 Simpan</button>
                        <a href="{{ route('buku.index') }}" class="btn btn-secondary px-4">🚪 Keluar</a>
                    </div>
            </div>
        </form>
@endsection
