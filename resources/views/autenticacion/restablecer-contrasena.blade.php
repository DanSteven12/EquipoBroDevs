@extends('layouts.app-master')

@section('content')
    <style>
        :root {
            --primary-dark: #0A2647;
            --primary-light: #FFC107;
            --hover-color: #144272;
            --background: #F5F5F5;
            --text-main: #333333;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            margin: 0;
        }

        .reset-container {
            max-width: 450px;
            margin: clamp(2rem, 10vh, 5rem) auto;
            padding: clamp(1.5rem, 4vw, 2.5rem);
            background-color: var(--white);
            border: 4px solid var(--primary-dark);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .campo {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            font-size: 1rem;
        }

        input {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: var(--white);
            font-size: 1rem;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(10, 38, 71, 0.1);
        }

        .error-message {
            color: #d82c0d;
            font-size: 0.875rem;
            margin-top: 5px;
            font-weight: 500;
        }

        button {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background-color: #eab000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }
    </style>

    <div class="reset-container">
        <h2>Nueva contraseña</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request()->query('token') }}">

            <div class="campo">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" value="{{ request()->query('email') }}" required readonly>
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="campo">
                <label for="password">Nueva contraseña</label>
                <input type="password" name="password" required>
                @error('password') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="campo">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit">Restablecer contraseña</button>
        </form>
    </div>
@endsection