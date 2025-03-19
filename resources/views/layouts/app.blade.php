<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des Réservations</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Styles pour le tableau */
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            background-color: #fff;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #343a40;
            color: #fff;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        /* Styles pour les badges */
        .badge {
            padding: 0.5em 0.75em;
            font-size: 0.875em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            border-radius: 0.25rem;
        }
        .badge-success {
            background-color: #28a745;
            color: #fff;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        /* Styles pour les boutons */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        /* Styles pour les petits écrans */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 14px;
            }
            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/bossiz.png') }}" alt="Logo Bossiz" width="150" height="auto" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Liens pour les utilisateurs non connectés -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                        </li>
                    @endif
                @endguest

                <!-- Liens pour les utilisateurs connectés -->
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reservations.index') }}">Réservations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">Rôles</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                        </form>
                    </li>
                    <div class="d-flex justify-content-between">
                                <!-- Photo de profil de l'utilisateur connecté -->
                        <div class="d-flex align-items-center">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Photo de Profil" class="rounded-circle" width="50" height="50">
                            <span class="ms-2">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
        
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">© 2023 Bossiz. Tous droits réservés.</span>
        </div>
    </footer>

    <!-- Bootstrap JS et dépendances -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Scripts personnalisés -->
    <script>
        // Confirmation avant suppression
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
                    e.preventDefault();
                }
            });
        });

        // Confirmation avant confirmation de réservation
        document.querySelectorAll('.confirm-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                if (!confirm('Êtes-vous sûr de vouloir confirmer cette réservation ?')) {
                    e.preventDefault();
                }
            });
        });

        // Animation pour les boutons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseenter', function () {
                this.style.transform = 'scale(1.05)';
            });
            button.addEventListener('mouseleave', function () {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>