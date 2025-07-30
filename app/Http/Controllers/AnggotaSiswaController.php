<?php

namespace App\Http\Controllers;

use App\Models\AnggotaSiswa;
use Illuminate\Http\Request;

class AnggotaSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaSiswa::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('NamaAnggota', 'like', "%$search%")
                    ->orWhere('NoInduk', 'like', "%$search%");
            });
        }

        $anggota = $query->latest('NoAnggotaS')->paginate(10)->withQueryString();
        $trashed = AnggotaSiswa::onlyTrashed()->paginate(5, ['*'], 'trash_page')->withQueryString();

        return view('anggota_siswa.index', compact('anggota', 'trashed'));
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
            'NoTelp' => 'nullable',
            'Hp' => 'nullable',
            'TglDaftar' => 'required|date',
            'NamaOrtu' => 'required',
            'AlamatOrtu' => 'required',
            'NoTelpOrtu' => 'nullable',
        ]);

        AnggotaSiswa::create($request->all());
        return redirect()->route('anggota-siswa.index')
            ->with('success', '✅ Anggota siswa berhasil ditambahkan.');
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
            ->with('success', '✅ Anggota siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = AnggotaSiswa::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota-siswa.index')
            ->with('success', '🗑️ Anggota siswa berhasil dihapus.');
    }

    public function restore($id)
    {
        $anggota = AnggotaSiswa::onlyTrashed()->findOrFail($id);
        $anggota->restore();

        return redirect()->route('anggota-siswa.index')
            ->with('success', '♻️ Anggota siswa berhasil dikembalikan.');
    }

    public function forceDelete($id)
    {
        $anggota = AnggotaSiswa::onlyTrashed()->findOrFail($id);
        $anggota->forceDelete();

        return redirect()->route('anggota-siswa.index')
            ->with('success', '❌ Data anggota siswa dihapus permanen.');
    }

    private function generateKode()
    {
        $last = AnggotaSiswa::withTrashed()->orderBy('NoAnggotaS', 'desc')->first();
        $number = $last ? intval(substr($last->NoAnggotaS, 2)) + 1 : 1;
        return 'AS' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
