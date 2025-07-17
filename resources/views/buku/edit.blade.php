@extends('layouts.form')

@section('content')
<h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">✏️ Edit Buku</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Oops! Ada yang salah:</strong>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('buku.update', $buku->KodeBuku) }}">
@csrf @method('PUT')


<div class="mb-2">
<label>KodeBuku</label>
<input name="KodeBuku" value="{{ $buku->KodeBuku }}" class="form-control" readonly>
</div>

@foreach ([
    'Judul', 'NoUDC', 'NoReg', 'Penerbit', 'Pengarang',
    'ThnTerbit', 'KotaTerbit', 'Bahasa', 'Edisi', 'Deskripsi', 'Isbn', 
    'JumEksemplar', 'SubyekUtama', 'SubyekTambahan'
] as $field)
<div class="mb-2">
<label>{{ $field }}</label>
<input 
    name="{{ $field }}" 
    value="{{ old($field, $buku->$field) }}" 
    class="form-control @error($field) is-invalid @enderror">

@error($field)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
</div>
@endforeach

<div class="mt-4 text-center">
            <button type="submit" class="btn btn-warning px-4">✏️ Ubah</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary px-4">🚪 Keluar</a>
        </div>
</div>
</div>
</form>
@endsection
