<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Judul', 'like', '%' . $request->search . '%')
                    ->orWhere('Pengarang', 'like', '%' . $request->search . '%')
                    ->orWhere('KodeBuku', 'like', '%' . $request->search . '%');
            });
        }

        $buku = $query->latest('KodeBuku')->paginate(10)->withQueryString();
        $trashed = Buku::onlyTrashed()->paginate(5, ['*'], 'trash_page')->withQueryString();

        return view('buku.index', compact('buku', 'trashed'));
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
        return redirect()->route('buku.index')->with('success', '✅ Buku berhasil ditambahkan.');
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

        return redirect()->route('buku.index')->with('success', '✏️ Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', '🗑️ Buku berhasil dihapus (soft delete).');
    }

    public function restore($id)
    {
        $buku = Buku::onlyTrashed()->findOrFail($id);
        $buku->restore();

        return redirect()->route('buku.index')->with('success', '♻️ Buku berhasil dikembalikan.');
    }

    public function forceDelete($id)
    {
        $buku = Buku::onlyTrashed()->findOrFail($id);
        $buku->forceDelete();

        return redirect()->route('buku.index')->with('success', '❌ Buku dihapus permanen.');
    }

    private function generateKode()
    {
        $last = Buku::withTrashed()->orderBy('KodeBuku', 'desc')->first();
        $number = $last ? intval(substr($last->KodeBuku, 1)) + 1 : 1;
        return 'B' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
