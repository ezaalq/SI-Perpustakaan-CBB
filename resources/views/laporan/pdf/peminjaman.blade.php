<h1>Laporan Peminjaman</h1>
<p>Periode: {{ $from }} - {{ $to }}</p>

<h3>Siswa</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
    <tr>
        <th>No</th>
        <th>Pinjam</th>
        <th>Anggota</th>
        <th>Tanggal</th>
    </tr>
    @foreach($siswa as $s)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->NoPinjamS }}</td>
            <td>{{ $s->NoAnggotaS }}</td>
            <td>{{ $s->TglPinjam }}</td>
        </tr>
    @endforeach
</table>

<h3>Non Siswa</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
    <tr>
        <th>No</th>
        <th>Pinjam</th>
        <th>Anggota</th>
        <th>Tanggal</th>
    </tr>
    @foreach($non as $n)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $n->NoPinjamNS }}</td>
            <td>{{ $n->NoAnggotaNS }}</td>
            <td>{{ $n->TglPinjam }}</td>
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