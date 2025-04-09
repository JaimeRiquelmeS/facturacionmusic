<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MusicFac - Sistema de Facturación') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Estilos personalizados -->
    <style>
        body {
            background: #f8f9fa;
            font-family: 'figtree', sans-serif;
        }

        .navbar-brand {
            font-family: 'Pacifico', cursive;
            font-size: 1.8rem;
        }

        .navbar {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            position: relative;
            padding: 8px 15px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffffff;
        }

        .navbar-dark .navbar-nav .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }

        .navbar-dark .navbar-nav .nav-link.active:before {
            content: '♪';
            position: absolute;
            left: 0;
            font-size: 12px;
        }

        .navbar-dark .navbar-nav .nav-link.active:after {
            content: '♫';
            position: absolute;
            right: 0;
            font-size: 12px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            box-shadow: 0 4px 10px rgba(37, 117, 252, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5c0fb3 0%, #1e68e8 100%);
            box-shadow: 0 6px 15px rgba(37, 117, 252, 0.4);
        }

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
        }

        /* Iconos musicales para elementos de lista */
        table tbody tr td:first-child:before {
            content: '♪';
            color: #6a11cb;
            margin-right: 5px;
            opacity: 0.7;
        }

        /* Footer estilizado */
        footer {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        /* Animación musical para botones */
        .btn:active {
            animation: pulse 0.3s ease;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }

        /* Animación de fondo para dashboard */
        .dashboard-bg {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-music me-2"></i>MusicFac
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-chart-line me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                                <i class="fas fa-users me-1"></i>Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                                <i class="fas fa-guitar me-1"></i>Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('facturas.*') ? 'active' : '' }}" href="{{ route('facturas.index') }}">
                                <i class="fas fa-file-invoice-dollar me-1"></i>Facturas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <div class="container py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-0">
                            <i class="fas fa-music me-2"></i>MusicFac - Sistema de Facturación para Músicos &copy; {{ date('Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
