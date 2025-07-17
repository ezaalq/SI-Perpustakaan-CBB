<?php

namespace App\Http\Controllers;

use App\Models\AnggotaSiswa;
use Illuminate\Http\Request;

class AnggotaSiswaController extends Controller
{
    public function index()
    {
        $anggota = AnggotaSiswa::all();
        return view('anggota_siswa.index', compact('anggota'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        return view('anggota_siswa.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $request->merge(['NoAnggotaS' => $request->NoAnggotaS]);

        $request->validate([
            'NoAnggotaS' => 'required|unique:anggota_siswa,NoAnggotaS',
            'NoInduk' => 'required',
            'NamaAnggota' => 'required',
            'TTL' => 'required|date',
            'Alamat' => 'required',
            'KodePos' => 'required',
            'NoTelp1' => 'nullable',
            'NoTelp2' => 'nullable',
            'TglDaftar' => 'required|date',
            'NamaOrtu' => 'required',
            'AlamatOrtu' => 'required',
            'NoTelpOrtu' => 'nullable',
        ]);

        AnggotaSiswa::create($request->all());
        return redirect()->route('anggota-siswa.index')
            ->with('success', 'Anggota siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $anggota = AnggotaSiswa::findOrFail($id);
        return view('anggota_siswa.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NoInduk' => 'required',
            'NamaAnggota' => 'required',
            'TTL' => 'required|date',
            'Alamat' => 'required',
            'KodePos' => 'required',
            'NoTelp' => 'nullable',
            'Hp' => 'nullable',
            'TglDaftar' => 'required|date',
            'NamaOrtu' => 'required',
            'AlamatOrtu' => 'required',
            'NoTelpOrtu' => 'nullable',
        ]);

        $anggota = AnggotaSiswa::findOrFail($id);
        $anggota->update($request->except('NoAnggotaS'));
        return redirect()->route('anggota-siswa.index')
            ->with('success', 'Anggota siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = AnggotaSiswa::findOrFail($id);
        $anggota->delete();
        return redirect()->route('anggota-siswa.index')
            ->with('success', 'Anggota siswa berhasil dihapus.');
    }

    private function generateKode()
    {
        $last = AnggotaSiswa::orderBy('NoAnggotaS', 'desc')->first();
        $number = $last ? intval(substr($last->NoAnggotaS, 2)) + 1 : 1;
        return 'AS' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
