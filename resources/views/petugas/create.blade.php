@extends('layouts.form')

@section('content')
<h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">➕ Tambah Petugas</h2>

@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('petugas.store') }}">
@csrf

@foreach ([
'KodePetugas', 'Nama', 'Jabatan', 'HakAkses', 'Password'
] as $field)
<div class="mb-2">
<label>{{ $field }}</label>
<input name="{{ $field }}" type="{{ $field == 'Password' ? 'password' : 'text' }}" class="form-control">
</div>
@endforeach

<button class="btn btn-primary">Simpan</button>
</form>
@endsection
