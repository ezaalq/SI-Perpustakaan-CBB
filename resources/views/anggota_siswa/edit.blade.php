@extends('layouts.form')

@section('content')
    <h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">
        ✏️ Edit Anggota Siswa
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('anggota-siswa.update', $anggota->NoAnggotaS) }}">
        @csrf @method('PUT')

        <div class="mb-2">
            <label>NoAnggotaS</label>
            <input name="NoAnggotaS" value="{{ $anggota->NoAnggotaS }}" class="form-control" readonly>
        </div>

        @foreach ([
            'NoInduk', 'NamaAnggota', 'TTL', 'Alamat', 'KodePos',
            'NoTelp', 'Hp', 'TglDaftar', 'NamaOrtu', 'AlamatOrtu', 'NoTelpOrtu'
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
            <a href="{{ route('anggota-siswa.index') }}" class="btn btn-secondary px-4">🚪 Keluar</a>
        </div>
    </form>
@endsection
