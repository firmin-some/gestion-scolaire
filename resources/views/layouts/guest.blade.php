<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>EcolePrime — {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Vite (Tailwind + JS) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background: #f4f6f9;
                font-family: 'Figtree', sans-serif;
            }
            .login-wrapper {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 24px;
            }
            .login-card {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 4px 24px rgba(0,0,0,0.10);
                padding: 36px 32px;
                width: 100%;
                max-width: 460px;
            }
            .login-logo {
                text-align: center;
                margin-bottom: 24px;
                font-size: 28px;
                font-weight: 700;
                color: #1a1a2e;
            }
            .login-logo span {
                color: #f0c040;
            }
            .nav-tabs .nav-link {
                color: #6c757d;
                font-weight: 500;
            }
            .nav-tabs .nav-link.active {
                color: #1a1a2e;
                font-weight: 700;
                border-bottom: 2px solid #f0c040;
            }
            .btn-login-gestionnaire {
                background: #1a1a2e;
                color: #fff;
                border: none;
                width: 100%;
                padding: 10px;
                border-radius: 8px;
                font-weight: 600;
            }
            .btn-login-gestionnaire:hover {
                background: #f0c040;
                color: #000;
            }
            .btn-login-enseignant {
                background: #f0c040;
                color: #000;
                border: none;
                width: 100%;
                padding: 10px;
                border-radius: 8px;
                font-weight: 600;
            }
            .btn-login-enseignant:hover {
                background: #1a1a2e;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="login-wrapper">

            {{-- Logo --}}
            <div class="login-logo mb-3">
                🏫 Ecole<span>Prime</span>
            </div>

            {{-- Carte de connexion --}}
            <div class="login-card">
                {{ $slot }}
            </div>

        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>