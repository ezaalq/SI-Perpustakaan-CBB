@extends('layouts.form')

@section('content')
    <h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">➕ Tambah Peminjaman
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

    <form method="POST" action="{{ route('peminjaman-siswa.store') }}">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">No Pinjam</label>
                <input name="NoPinjamS" class="form-control" value="{{ $kode }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">No Anggota Siswa</label>
                <select name="NoAnggotaS" class="form-control" required>
                    @foreach ($anggota as $a)
                        <option value="{{ $a->NoAnggotaS }}">{{ $a->NoAnggotaS }} - {{ $a->NamaAnggota }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="TglPinjam" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kode Petugas</label>
                <select name="KodePetugas" class="form-control" required>
                    @foreach ($petugas as $p)
                        <option value="{{ $p->KodePetugas }}">{{ $p->KodePetugas }} - {{ $p->Nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="TglKembali" class="form-control" required>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="detailTableBody">
                    <tr>
                        <td>
                            <select name="detail[0][KodeBuku]" class="form-control kode-buku">
                                <option value="">Pilih Buku</option>
                                @foreach ($buku as $b)
                                    <option value="{{ $b->KodeBuku }}">{{ $b->KodeBuku }} - {{ $b->Judul }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input name="detail[0][Judul]" class="form-control" readonly></td>
                        <td><input name="detail[0][Pengarang]" class="form-control" readonly></td>
                        <td><input name="detail[0][Penerbit]" class="form-control" readonly></td>
                        <td><input name="detail[0][Jml]" type="number" class="form-control jumlah" min="1"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-3">
            <button type="button" class="btn btn-success px-4" onclick="addRow()">Tambah</button>
            <button type="submit" class="btn btn-primary px-4">Simpan</button>
            <a href="{{ route('peminjaman-siswa.index') }}" class="btn btn-secondary px-4">Keluar</a>
        </div>

    </form>

    <script>
        let rowIdx = 1;

        function addRow() {
            const tbody = document.getElementById('detailTableBody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select name="detail[${rowIdx}][KodeBuku]" class="form-control kode-buku">
                        <option value="">Pilih Buku</option>
                        @foreach ($buku as $b)
                            <option value="{{ $b->KodeBuku }}">{{ $b->KodeBuku }} - {{ $b->Judul }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input name="detail[${rowIdx}][Judul]" class="form-control" readonly></td>
                <td><input name="detail[${rowIdx}][Pengarang]" class="form-control" readonly></td>
                <td><input name="detail[${rowIdx}][Penerbit]" class="form-control" readonly></td>
                <td><input name="detail[${rowIdx}][Jml]" type="number" class="form-control jumlah" min="1"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>`;
            tbody.appendChild(newRow);
            rowIdx++;
            initKodeBuku();
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
        }

        function initKodeBuku() {
            document.querySelectorAll('.kode-buku').forEach(select => {
                select.onchange = () => {
                    const kode = select.value;
                    const row = select.closest('tr');

                    if (!kode) {
                        row.querySelector('[name$="[Judul]"]').value = '';
                        row.querySelector('[name$="[Pengarang]"]').value = '';
                        row.querySelector('[name$="[Penerbit]"]').value = '';
                        row.querySelector('[name$="[Jml]"]').value = '';
                        row.querySelector('[name$="[Jml]"]').removeAttribute('max');
                        return;
                    }

                    fetch('/api/buku/' + kode)
                        .then(res => res.json())
                        .then(data => {
                            row.querySelector('[name$="[Judul]"]').value = data.Judul;
                            row.querySelector('[name$="[Pengarang]"]').value = data.Pengarang;
                            row.querySelector('[name$="[Penerbit]"]').value = data.Penerbit;

                            const jumlahInput = row.querySelector('[name$="[Jml]"]');
                            jumlahInput.value = '';
                            jumlahInput.setAttribute('max', data.JumEksemplar);
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Gagal mengambil data buku');
                        });
                };
            });
        }

        initKodeBuku();

        document.addEventListener('input', e => {
            if (e.target.matches('[name$="[Jml]"]')) {
                const row = e.target.closest('tr');
                const max = parseInt(e.target.getAttribute('max')) || 1;
                let val = parseInt(e.target.value);

                if (val > max) e.target.value = max;
                if (val < 1) e.target.value = 1;
            }
        });
    </script>
@endsection