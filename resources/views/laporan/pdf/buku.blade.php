<h1 style="text-align:center">Laporan Buku</h1>

<table border="1" cellpadding="3" cellspacing="0" width="100%">
    <tr>
        <th>Kode</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Penerbit</th>
        <th>Tahun</th>
        <th>Jumlah</th>
    </tr>
    @foreach($buku as $b)
        <tr>
            <td>{{ $b->KodeBuku }}</td>
            <td>{{ $b->Judul }}</td>
            <td>{{ $b->Pengarang }}</td>
            <td>{{ $b->Penerbit }}</td>
            <td>{{ $b->ThnTerbit }}</td>
            <td>{{ $b->JumEksemplar }}</td>
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