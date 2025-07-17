<h1 style="text-align:center">Laporan Denda</h1>
<p>Periode: {{ $from }} - {{ $to }}</p>

<h3>Siswa</h3>
<table border="1" cellpadding="3" cellspacing="0" width="100%">
    <tr>
        <th>No</th>
        <th>No Kembali</th>
        <th>No Pinjam</th>
        <th>Nama Anggota</th>
        <th>Tanggal</th>
        <th>Denda</th>
    </tr>
    @foreach($siswa as $s)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->NoKembaliS }}</td>
            <td>{{ $s->NoPinjamS }}</td>
            <td>{{ $s->pinjam->anggota->NamaAnggota ?? '-' }}</td>
            <td>{{ $s->TglKembali }}</td>
            <td>{{ $s->Denda }}</td>
        </tr>
    @endforeach
</table>

<h3>Non Siswa</h3>
<table border="1" cellpadding="3" cellspacing="0" width="100%">
    <tr>
        <th>No</th>
        <th>No Kembali</th>
        <th>No Pinjam</th>
        <th>Nama Anggota</th>
        <th>Tanggal</th>
        <th>Denda</th>
    </tr>
    @foreach($non as $n)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $n->NoKembaliNS }}</td>
            <td>{{ $n->NoPinjamNS }}</td>
            <td>{{ $n->pinjam->anggota->NamaAnggota ?? '-' }}</td>
            <td>{{ $n->TglKembali }}</td>
            <td>{{ $n->Denda }}</td>
        </tr>
    @endforeach
</table>
<div style="width:100%; display:flex; justify-content:flex-end; margin-top:50px;">
    <div style="text-align:right;">
        <p>Mengetahui,</p>
        <p style="margin-bottom:60px;">Kepala Perpustakaan</p>
        <p style="text-decoration:underline; font-weight:bold;">(___________________)</p>
    </div>
</div>