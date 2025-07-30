<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan | Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: url('{{ asset("images/library.jpg") }}') center center / cover no-repeat fixed, #f9f9f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #2e8b57;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            position: sticky;
            top: 0;
        }

        .navbar {
            max-width: 1200px;
            margin: auto;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
        }

        .brand-link img {
            height: 36px;
        }

        .brand-link h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .menu {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .menu li {
            position: relative;
        }

        .menu li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            font-weight: 500;
            display: block;
        }

        .menu li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .submenu {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: #3cb371;
            border-radius: 4px;
            min-width: 160px;
            z-index: 1001;
        }

        .submenu li a {
            padding: 10px 15px;
            font-size: 14px;
            color: white;
            text-decoration: none;
            display: block;
        }

        .submenu li a:hover {
            background-color: #2e8b57;
        }

        .menu li:hover .submenu {
            display: block;
        }

        main {
            flex: 1;
            padding-bottom: 60px;
        }

        .status-bar {
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 8px 0;
            text-align: center;
            font-size: 13px;
            position: relative;
            z-index: 999;
        }

        /* Laravel Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .page-item .page-link {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: white;
            color: #228B22;
            text-decoration: none;
            font-size: 14px;
        }

        .page-item.active .page-link {
            background-color: #228B22;
            color: white;
            border-color: #228B22;
        }

        .page-link:hover {
            background-color: #e0f5e9;
            color: #1c6b1c;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .menu {
                flex-direction: column;
                width: 100%;
                gap: 0;
            }

            .menu li {
                width: 100%;
            }

            .menu li a {
                padding: 12px 16px;
                width: 100%;
                text-align: left;
            }

            .submenu {
                position: static;
                width: 100%;
                border-radius: 0;
            }

            .submenu li a {
                padding: 10px 20px;
            }
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