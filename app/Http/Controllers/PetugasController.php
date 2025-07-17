<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all();
        return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'KodePetugas' => 'required|unique:petugas,KodePetugas',
            'Nama' => 'required',
            'Jabatan' => 'required',
            'HakAkses' => 'required',
            'Password' => 'required',
        ]);

        $data = $request->all();
        $data['Password'] = bcrypt($data['Password']); // hash password
        Petugas::create($data);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama' => 'required',
            'Jabatan' => 'required',
            'HakAkses' => 'required',
            'Password' => 'nullable',
        ]);

        $petugas = Petugas::findOrFail($id);
        $data = $request->all();

        if (!empty($data['Password'])) {
            $data['Password'] = bcrypt($data['Password']);
        } else {
            unset($data['Password']);
        }

        $petugas->update($data);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();
        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil dihapus.');
    }
}
