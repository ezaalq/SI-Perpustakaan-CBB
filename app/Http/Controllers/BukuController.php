<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        return view('buku.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $request->merge(['KodeBuku' => $request->KodeBuku]);

        $request->validate([
            'KodeBuku' => 'required|unique:buku,KodeBuku',
            'Judul' => 'required',
            'Pengarang' => 'required',
            'Penerbit' => 'required',
            'ThnTerbit' => 'nullable|integer|min:1500|max:' . date('Y'),
            'JumEksemplar' => 'required|integer|min:1',
            'NoUDC' => 'nullable',
            'NoReg' => 'nullable',
            'KotaTerbit' => 'nullable',
            'Bahasa' => 'nullable',
            'Edisi' => 'nullable',
            'Deskripsi' => 'nullable',
            'Isbn' => 'nullable',
            'SubyekUtama' => 'nullable',
            'SubyekTambahan' => 'nullable',
        ]);

        Buku::create($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Judul' => 'required',
            'Pengarang' => 'required',
            'Penerbit' => 'required',
            'ThnTerbit' => 'nullable|integer|min:1500|max:' . date('Y'),
            'JumEksemplar' => 'required|integer|min:1',
            'NoUDC' => 'nullable',
            'NoReg' => 'nullable',
            'KotaTerbit' => 'nullable',
            'Bahasa' => 'nullable',
            'Edisi' => 'nullable',
            'Deskripsi' => 'nullable',
            'Isbn' => 'nullable',
            'SubyekUtama' => 'nullable',
            'SubyekTambahan' => 'nullable',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->except('KodeBuku'));

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function generateKode()
    {
        $last = Buku::orderBy('KodeBuku', 'desc')->first();
        $number = $last ? intval(substr($last->KodeBuku, 1)) + 1 : 1;
        return 'B' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
