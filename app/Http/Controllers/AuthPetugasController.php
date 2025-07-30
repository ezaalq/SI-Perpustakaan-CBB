<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;

class AuthPetugasController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'KodePetugas' => 'required',
            'password' => 'required',
        ]);

        $petugas = Petugas::where('KodePetugas', $credentials['KodePetugas'])->first();

        if (!$petugas || $petugas->deleted_at !== null) {
            return back()->withErrors(['KodePetugas' => 'Petugas tidak ditemukan atau telah dihapus.']);
        }

        if (Auth::guard('petugas')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['KodePetugas' => 'Kode Petugas atau Password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('petugas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
