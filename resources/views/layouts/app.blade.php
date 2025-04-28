<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Gestion Clients</title>

    <!-- Fonts -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/js/app.js'])
    @yield('head')

    <style>
        /* Variables */
        :root {
            --primary: #008caa;      /* Bleu IoTIZ */
            --secondary: #00aead;    /* Turquoise IoTIZ */
            --success: #95c11f;      /* Vert IoTIZ */
            --danger: #e83943;       /* Rouge IoTIZ */
            --warning: #f9ae00;      /* Jaune IoTIZ */
            --info: #00b4ce;        /* Cyan IoTIZ */
            --light: #f8fafc;       /* Fond clair */
            --dark: #0f172a;        /* Texte foncé */
            --border: #e2e8f0;      /* Bordures */
        }

        /* Base */
        body {
            font-family: 'Archivo Narrow', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation */
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 0.75rem 0;
        }

        .navbar-brand,
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
        }

        /* Boutons */
        .btn-primary,
        .btn[type="submit"],
        .btn-export,
        .navbar a[href*="create"],
        .navbar-nav .nav-item a[href*="create"] {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover,
        .btn[type="submit"]:hover,
        .btn-export:hover,
        .navbar a[href*="create"]:hover {
            background-color: #007a94 !important;
            border-color: #007a94 !important;
            transform: translateY(-1px);
        }

        .navbar a[href*="create"] {
            margin-left: 1rem;
            text-decoration: none;
        }

        /* Menu latéral */
        .sidebar .nav-link {
            color: var(--dark) !important;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover {
            color: var(--primary) !important;
            background-color: rgba(0, 140, 170, 0.1);
        }

        .sidebar .nav-link.active {
            color: white !important;
            background-color: var(--primary) !important;
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 0.5rem;
        }

        .dropdown-item {
            color: var(--dark);
            padding: 0.625rem 1rem;
            border-radius: 4px;
        }

        .dropdown-item:hover {
            color: var(--primary);
            background-color: rgba(0, 140, 170, 0.1);
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: var(--light);
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.25rem;
        }

        /* Alertes */
        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 10px;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .alert-success {
            border-left-color: var(--success);
            background-color: rgba(149, 193, 31, 0.1);
        }

        .alert-danger {
            border-left-color: var(--danger);
            background-color: rgba(232, 57, 67, 0.1);
        }

        /* Formulaires */
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 140, 170, 0.25);
        }

        /* Layout */
        .container {
            max-width: 1400px;
            padding: 0 1.5rem;
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        /* Barre de progression */
        .progress {
            height: 3px;
            z-index: 9999;
        }

        .progress-bar {
            background-color: var(--primary);
        }

        /* Footer */
        .footer {
            background: white;
            box-shadow: 0 -1px 3px rgba(0,0,0,0.05);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .footer a.text-muted,
        .footer span.text-muted {
            color: var(--dark) !important;
            text-decoration: none;
        }

        .footer a.text-muted:hover {
            color: var(--primary) !important;
            transition: color 0.2s;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="progress fixed-top" style="height: 3px;">
    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>


@if(session('success'))
    <div class="alert alert-success fade-in">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger fade-in">
        <i class="fas fa-exclamation-circle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-users me-2"></i>Gestion Clients
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <i class="fas fa-list me-1"></i>Clients
                        </a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Connexion
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </button>
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="main-content">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <span class="text-muted">© {{ date('Y') }} Gestion Clients</span>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <a href="#" class="text-muted me-3">
                    <i class="fas fa-question-circle"></i> Aide
                </a>
                <a href="#" class="text-muted">
                    <i class="fas fa-shield-alt"></i> Confidentialité
                </a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
