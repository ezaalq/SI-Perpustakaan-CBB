@extends('layouts.wc')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        .welcome-wrapper {
            background: url('{{ asset('images/library.jpg') }}') center center / cover no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .welcome-header {
            background-color: #228B22;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .welcome-header img {
            height: 40px;
            margin-right: 10px;
        }

        .welcome-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .welcome-body {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
        }

        .welcome-content {
            color: white;
            max-width: 90%;
            padding: 20px;
        }

        .welcome-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            line-height: 1.3;
        }

        .welcome-content p {
            font-size: 1.3rem;
            margin-bottom: 30px;
        }

        .btn-login {
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            font-size: 1.1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background-color: #218838;
            color: white;
        }

        /* Tablet */
        @media (max-width: 992px) {
            .welcome-content h1 {
                font-size: 2.5rem;
                line-height: 1.4;
            }

            .welcome-content p {
                font-size: 1.1rem;
            }

            .btn-login {
                padding: 10px 25px;
                font-size: 1rem;
            }
        }

        /* HP */
        @media (max-width: 576px) {
            .welcome-header {
                flex-direction: column;
                text-align: center;
            }

            .welcome-header img {
                margin-bottom: 5px;
            }

            .welcome-content h1 {
                font-size: 1.8rem;
                line-height: 1.4;
            }

            .welcome-content p {
                font-size: 1rem;
            }

            .btn-login {
                padding: 8px 20px;
                font-size: 0.95rem;
            }
        }
    </style>

    <div class="welcome-wrapper">
        <div class="welcome-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h4>Cendikia Bina Bangsa</h4>
        </div>

        <div class="welcome-body">
            <div class="welcome-content">
                <h1>
                    Selamat Datang di Sistem Informasi <br>
                    Perpustakaan Cendikia Bina Bangsa
                </h1>
                <p>Silahkan login untuk mengakses sistem perpustakaan digital Cendikia Bina Bangsa.</p>
                <a href="{{ route('login') }}" class="btn-login">Login Sekarang</a>
            </div>
        </div>
    </div>
@endsection