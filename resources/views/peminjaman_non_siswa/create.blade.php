@extends('layouts.form')

@section('content')
    <h2 style="text-align:center; font-size:1.4rem; font-weight:600; color:#00000; margin-bottom:20px;">➕ Tambah Peminjaman
        Non Siswa</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peminjaman-non-siswa.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-2">
                    <label>No Pinjam</label>
                    <input name="NoPinjamNS" class="form-control" value="{{ $kode }}" readonly>
                </div>
                <div class="mb-2">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="TglPinjam" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="TglKembali" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-2">
                    <label>No Anggota Non Siswa</label>
                    <select name="NoAnggotaNS" class="form-control" required>
                        @foreach ($anggota as $a)
                            <option value="{{ $a->NoAnggotaNS }}">{{ $a->NoAnggotaNS }} - {{ $a->NamaAnggota }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label>Kode Petugas</label>
                    <select name="KodePetugas" class="form-control" required>
                        @foreach ($petugas as $p)
                            <option value="{{ $p->KodePetugas }}">{{ $p->KodePetugas }} - {{ $p->Nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <hr>

        <table class="table table-bordered" id="detailTable">
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
            <tbody>
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

        <button type="button" class="btn btn-success" onclick="addRow()">Tambah</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('peminjaman-non-siswa.index') }}" class="btn btn-secondary">Keluar</a>
    </form>

    <script>
        let rowIdx = 1;

        function addRow() {
            const tbody = document.querySelector('#detailTable tbody');
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