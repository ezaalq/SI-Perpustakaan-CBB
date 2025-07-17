<?php

namespace App\Http\Controllers;

use App\Models\AnggotaNonSiswa;
use Illuminate\Http\Request;

class AnggotaNonSiswaController extends Controller
{
    public function index()
    {
        $anggota = AnggotaNonSiswa::all();
        return view('anggota_non_siswa.index', compact('anggota'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        return view('anggota_non_siswa.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $request->merge(['NoAnggotaNS' => $request->NoAnggotaNS]);

        $request->validate([
            'NoAnggotaNS' => 'required|unique:anggota_non_siswa,NoAnggotaNS',
            'NIP' => 'required',
            'NamaAnggota' => 'required',
            'Jabatan' => 'required',
            'TTL' => 'required|date',
            'Alamat' => 'required',
            'KodePos' => 'required',
            'NoTelp' => 'nullable',
            'Hp' => 'nullable',
            'TglDaftar' => 'required|date',
        ]);

        AnggotaNonSiswa::create($request->all());
        return redirect()->route('anggota-non-siswa.index')
            ->with('success', 'Anggota Non Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $anggota = AnggotaNonSiswa::findOrFail($id);
        return view('anggota_non_siswa.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NIP' => 'required',
            'NamaAnggota' => 'required',
            'Jabatan' => 'required',
            'TTL' => 'required|date',
            'Alamat' => 'required',
            'KodePos' => 'required',
            'NoTelp1' => 'nullable',
            'NoTelp2' => 'nullable',
            'TglDaftar' => 'required|date',
        ]);

        $anggota = AnggotaNonSiswa::findOrFail($id);
        $anggota->update($request->except('NoAnggotaNS'));

        return redirect()->route('anggota-non-siswa.index')
            ->with('success', 'Anggota Non Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = AnggotaNonSiswa::findOrFail($id);
        $anggota->delete();
        return redirect()->route('anggota-non-siswa.index')
            ->with('success', 'Anggota Non Siswa berhasil dihapus.');
    }

    private function generateKode()
    {
        $last = AnggotaNonSiswa::orderBy('NoAnggotaNS', 'desc')->first();
        $number = $last ? intval(substr($last->NoAnggotaNS, 2)) + 1 : 1;
        return 'AN' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
