<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Form' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: url('{{ asset("images/library.jpg") }}') center center / cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 30px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            max-width: 800px;
            width: 90%;
            margin-bottom: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            justify-content: center;
        }

        .header img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .header-text {
            text-align: center;
        }

        .header-text h2 {
            color: #28a745;
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .header-text p {
            color: #1abc9c;
            margin: 0;
            font-size: 0.85rem;
        }

        .form-label {
            color: #28a745;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-control {
            border-color: #28a745;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .btn {
            min-width: 80px;
            font-size: 0.9rem;
        }
    </style>

</head>

<body>

    <div class="form-container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <div class="header-text">
                <h2>PERPUSTAKAAN Cendekia Bina Bangsa</h2>
                <p>Jl. Soekarno, Maluku, Ambon</p>
            </div>
        </div>

        @yield('content')
    </div>

</body>

</html>