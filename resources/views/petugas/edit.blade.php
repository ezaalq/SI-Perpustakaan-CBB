@extends('layouts.app')

@section('content')
<h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">✏️ Edit Petugas</h2>

@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('petugas.update', $petugas->KodePetugas) }}">
@csrf @method('PUT')

@foreach ([
'Nama', 'Jabatan', 'HakAkses'
] as $field)
<div class="mb-2">
<label>{{ $field }}</label>
<input name="{{ $field }}" value="{{ $petugas->$field }}" class="form-control">
</div>
@endforeach

<div class="mb-2">
<label>Password (kosongkan jika tidak diubah)</label>
<input name="Password" type="password" class="form-control">
</div>

<button class="btn btn-primary">Update</button>
</form>
@endsection
