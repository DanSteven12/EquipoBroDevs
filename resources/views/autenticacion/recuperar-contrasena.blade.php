@extends('layouts.app-master')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #0A2647;
            --primary-light: #FFC107;
            --hover-color: #144272;
            --background: #F5F5F5;
            --text-main: #333333;
            --danger-red: #ef4444;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            margin: 0;
        }

        .recover-container {
            max-width: min(500px, 90%);
            margin: clamp(2rem, 10vh, 5rem) auto;
            padding: clamp(1.5rem, 4vw, 2.5rem);
            background-color: var(--white);
            border: 4px solid var(--primary-dark);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .recover-container h2 {
            text-align: center;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .recover-container form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            font-size: 1rem;
        }

        .recover-container form input[type="email"] {
            width: 100%;
            padding: 0.875rem;
            margin-bottom: 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--white);
            box-sizing: border-box;
            transition: all 0.3s;
        }

        .recover-container form input:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(10, 38, 71, 0.1);
        }

        .recover-container .error-message {
            color: var(--danger-red);
            font-size: 0.875rem;
            margin-top: -1rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            border: 1px solid #badbcc;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 500;
        }

        .recover-container button {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .recover-container button:hover {
            background-color: #eab000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        .recover-container button:active {
            transform: translateY(0);
        }

        /* Espaciado responsivo */
        .recover-spacing {
            height: 2rem;
        }

        @media (max-width: 400px) {
            .recover-container h2 {
                flex-direction: column;
                gap: 0.3rem;
            }

            .alert-success {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
        }
    </style>

    <div class="recover-spacing"></div>
    <div class="recover-container">
        <h2><i class="fas fa-unlock-alt"></i>Recuperar Contraseña</h2>

        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit">Enviar enlace</button>
        </form>
    </div>
    <div class="recover-spacing"></div>
@endsection