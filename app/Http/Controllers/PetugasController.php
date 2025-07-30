<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = Petugas::query();

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Nama', 'like', '%' . $request->search . '%')
                    ->orWhere('KodePetugas', 'like', '%' . $request->search . '%');
            });
        }

        $petugas = $query->latest('KodePetugas')->paginate(10)->withQueryString();
        $trashed = Petugas::onlyTrashed()->paginate(5, ['*'], 'trash_page')->withQueryString();

        return view('petugas.index', compact('petugas', 'trashed'));
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
        $data['Password'] = bcrypt($data['Password']);
        Petugas::create($data);

        return redirect()->route('petugas.index')
            ->with('success', '✅ Petugas berhasil ditambahkan.');
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
            ->with('success', '✏️ Petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.index')
            ->with('success', '🗑️ Petugas berhasil dihapus.');
    }

    public function restore($id)
    {
        $petugas = Petugas::onlyTrashed()->findOrFail($id);
        $petugas->restore();

        return redirect()->route('petugas.index')
            ->with('success', '♻️ Petugas berhasil dikembalikan.');
    }

    public function forceDelete($id)
    {
        $petugas = Petugas::onlyTrashed()->findOrFail($id);
        $petugas->forceDelete();

        return redirect()->route('petugas.index')
            ->with('success', '❌ Data petugas dihapus permanen.');
    }
}
