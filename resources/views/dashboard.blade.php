@extends('layouts.app')

@section('content')
    <div style="flex:1; display:flex; justify-content:center; padding:200px;">
        <div
            style="background:rgba(255,255,255,0.9);padding:30px;border-radius:10px;max-width:700px;width:90%;text-align:center; margin-top:100px;">
            <h1>📊 Dashboard</h1>
            <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>
            <p>Gunakan menu untuk mengakses fitur perpustakaan</p>
        </div>
    </div>
@endsection