<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: url('{{ asset("images/library.jpg") }}') center center / cover no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #228B22;
            color: white;
        }

        .navbar {
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
        }

        .brand-link img {
            height: 35px;
        }

        .brand-link h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .menu {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .menu>li {
            position: relative;
        }

        .menu>li>a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
        }

        .menu>li:hover .submenu {
            display: block;
        }

        .submenu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #2e8b57;
            list-style: none;
            padding: 0;
            margin: 0;
            z-index: 999;
            min-width: 150px;
        }

        .submenu li a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
        }

        .submenu li a:hover {
            background-color: #3cb371;
        }

        main {
            flex: 1;
        }

        .status-bar {
            background: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            padding: 5px;
        }
    </style>
</head>

<body>

    <header>
        <div class="navbar">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <h4>Perpustakaan Cendekia Bina Bangsa</h4>
            </a>

            <ul class="menu">
                <li>
                    <a href="#">File ▾</a>
                    <ul class="submenu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#"
                                    onclick="document.getElementById('logout-form').submit(); return false;">Logout</a>
                            </form>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">Database ▾</a>
                    <ul class="submenu">
                        <li><a href="{{ route('buku.index') }}">Buku</a></li>
                        <li><a href="{{ route('anggota-siswa.index') }}">Siswa</a></li>
                        <li><a href="{{ route('anggota-non-siswa.index') }}">Non Siswa</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">Transaksi ▾</a>
                    <ul class="submenu">
                        <li><a href="{{ route('peminjaman-siswa.index') }}">Peminjaman Siswa</a></li>
                        <li><a href="{{ route('pengembalian-siswa.index') }}">Pengembalian Siswa</a></li>
                        <li><a href="{{ route('peminjaman-non-siswa.index') }}">Peminjaman Non Siswa</a></li>
                        <li><a href="{{ route('pengembalian-non-siswa.index') }}">Pengembalian Non Siswa</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">Laporan ▾</a>
                    <ul class="submenu">
                        <li><a href="{{ route('laporan.buku') }}">Buku</a></li>
                        <li><a href="{{ route('laporan.anggota') }}">Anggota</a></li>
                        <li><a href="{{ route('laporan.denda') }}">Denda</a></li>
                        <li><a href="{{ route('laporan.peminjaman') }}">Peminjaman</a></li>
                        <li><a href="{{ route('laporan.pengembalian') }}">Pengembalian</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">Pengaturan ▾</a>
                    <ul class="submenu">
                        <li><a href="{{ route('petugas.index') }}">Petugas</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="status-bar">
        Status: Siap
    </footer>

</body>

</html>