@extends('layouts.form')

@section('content')
    <h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">✏️ Edit Anggota Non Siswa</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('anggota-non-siswa.update', $anggota->NoAnggotaNS) }}">
        @csrf @method('PUT')

        <div class="mb-2">
            <label>NoAnggotaNS</label>
            <input name="NoAnggotaNS" value="{{ $anggota->NoAnggotaNS }}" class="form-control" readonly>
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
                    value="{{ old($field, $anggota->$field) }}" 
                    class="form-control">
            </div>
        @endforeach

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-warning px-4">✏️ Ubah</button>
            <a href="{{ route('anggota-non-siswa.index') }}" class="btn btn-secondary px-4">🚪 Keluar</a>
        </div>
    </form>
@endsection
