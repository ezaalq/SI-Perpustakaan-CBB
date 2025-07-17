@extends('layouts.form')

@section('content')
    <h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">➕ Tambah Anggota Non Siswa</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('anggota-non-siswa.store') }}">
        @csrf

        <div class="mb-2">
            <label>NoAnggotaNS</label>
            <input name="NoAnggotaNS" value="{{ $kode }}" class="form-control" readonly>
        </div>

        @foreach ([
            'NIP', 'NamaAnggota', 'Jabatan', 'TTL', 'Alamat', 'KodePos',
            'NoTelp', 'Hp', 'TglDaftar'
        ] as $field)
            <div class="mb-2">
                <label>{{ $field }}</label>
                <input 
                    name="{{ $field }}" 
                    type="{{ in_array($field, ['TTL', 'TglDaftar']) ? 'date' : 'text' }}" 
                    class="form-control">
            </div>
        @endforeach

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-success px-4">💾 Simpan</button>
            <a href="{{ route('anggota-non-siswa.index') }}" class="btn btn-secondary px-4">🚪 Keluar</a>
        </div>
    </form>
@endsection
