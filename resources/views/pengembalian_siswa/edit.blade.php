@extends('layouts.form')

@section('content')
    <h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">✏️ Edit Pengembalian
        Siswa</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pengembalian-siswa.update', $kembali->NoKembaliS) }}">
        @csrf @method('PUT')

        <div class="mb-2">
            <label>No Kembali</label>
            <input name="NoKembaliS" class="form-control" value="{{ $kembali->NoKembaliS }}" readonly>
        </div>

        <div class="mb-2">
            <label>No Pinjam</label>
            <select name="NoPinjamS" id="NoPinjamS" class="form-control" required>
                <option value="">-- Pilih No Pinjam --</option>
                @foreach ($pinjaman as $pj)
                    <option value="{{ $pj->NoPinjamS }}" {{ $pj->NoPinjamS == $kembali->NoPinjamS ? 'selected' : '' }}>
                        {{ $pj->NoPinjamS }} - {{ $pj->NoAnggotaS }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>Tanggal Pinjam</label>
            <input type="text" id="TglPinjam" class="form-control" readonly>
        </div>

        <div class="mb-2">
            <label>Jatuh Tempo</label>
            <input type="text" id="TglJatuhTempo" class="form-control" readonly>
        </div>

        <div class="mb-2">
            <label>Tanggal Dikembalikan</label>
            <input type="date" name="TglKembali" class="form-control" value="{{ $kembali->TglKembali }}" required>
        </div>

        <div class="mb-2">
            <label>Kode Petugas</label>
            <select name="KodePetugas" class="form-control" required>
                @foreach ($petugas as $p)
                    <option value="{{ $p->KodePetugas }}" {{ $p->KodePetugas == $kembali->KodePetugas ? 'selected' : '' }}>
                        {{ $p->KodePetugas }} - {{ $p->Nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('pengembalian-siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pinjamSelect = document.getElementById('NoPinjamS');
            const tglPinjamInput = document.getElementById('TglPinjam');
            const jatuhTempoInput = document.getElementById('TglJatuhTempo');

            function loadPinjaman(noPinjam) {
                if (!noPinjam) {
                    tglPinjamInput.value = '';
                    jatuhTempoInput.value = '';
                    return;
                }

                fetch('/api/peminjaman/' + noPinjam)
                    .then(res => res.json())
                    .then(data => {
                        tglPinjamInput.value = data.TglPinjam;
                        jatuhTempoInput.value = data.TglKembali;
                    })
                    .catch(err => console.error(err));
            }

            pinjamSelect.addEventListener('change', function () {
                loadPinjaman(this.value);
            });

            // load saat halaman pertama kali (karena sudah ada value NoPinjamS)
            if (pinjamSelect.value) {
                loadPinjaman(pinjamSelect.value);
            }
        });
    </script>
@endsection