<h1 style="text-align:center; margin-bottom: 20px;">Laporan Anggota</h1>

<h3>Siswa</h3>
<table border="1" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:30px;">
    <thead style="background:#f0f0f0;">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>TTL</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa as $s)
            <tr>
                <td>{{ $s->NoAnggotaS }}</td>
                <td>{{ $s->NamaAnggota }}</td>
                <td>{{ $s->TTL }}</td>
                <td>{{ $s->Alamat }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Non Siswa</h3>
<table border="1" cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:50px;">
    <thead style="background:#f0f0f0;">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($non as $n)
            <tr>
                <td>{{ $n->NoAnggotaNS }}</td>
                <td>{{ $n->NamaAnggota }}</td>
                <td>{{ $n->Jabatan }}</td>
                <td>{{ $n->Alamat }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="width:100%; display:flex; justify-content:flex-end; margin-top:50px;">
    <div style="text-align:right;">
        <p>Mengetahui,</p>
        <p style="margin-bottom:60px;">Kepala Perpustakaan</p>
        <p style="text-decoration:underline; font-weight:bold;">(___________________)</p>
    </div>
</div>