<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            background: url('{{ asset('images/library.jpg') }}') center center / cover no-repeat;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #228B22;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .header img {
            height: 30px;
            margin-right: 10px;
        }

        .header h4 {
            color: white;
            margin: 0;
            font-size: 1rem;
        }

        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-card h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #222;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-submit {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .alert {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <h4>Cendekia Bina Bangsa</h4>
    </div>

    <div class="login-container">
        <div class="login-card">
            <h2>LOGIN PETUGAS</h2>

            {{-- Notifikasi Error --}}
            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="KodePetugas">Kode Petugas</label>
                    <input type="text" name="KodePetugas" id="KodePetugas" value="{{ old('KodePetugas') }}" required
                        autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit" class="btn-submit">Masuk</button>
            </form>
        </div>
    </div>

</body>

</html>