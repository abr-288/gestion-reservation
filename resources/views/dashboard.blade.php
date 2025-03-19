@extends('layouts.app')

@section('styles')
<style>
    /* Styles généraux */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .container-fluid {
        max-width: 11400px;
        margin: 0 auto;
        padding: 0;
    }

    /* Media Query pour les écrans de 1200px et plus */
    @media (min-width: 1200px) {
        .container, .container-lg, .container-md, .container-sm, 
        .container-xl {
            max-width: 1140px;
        }
    }

    /* Sidebar */
    #sidebar {
        height: 100vh;
        background-color: #343a40;
        color: #fff;
        padding: 20px;
        position: fixed;
        width: 250px;
    }

    #sidebar .nav-link {
        color: #fff;
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    #sidebar .nav-link.active,
    #sidebar .nav-link:hover {
        background-color: #495057;
    }

    #sidebar .nav-link i {
        margin-right: 10px;
    }

    /* Main content */
    main {
        margin-left: 250px; /* Largeur de la sidebar */
        padding: 20px;
        background-color: #fff;
        min-height: 100vh;
    }

    /* Stats Cards */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1.5rem;
        margin: 10px 0;
    }

    .btn-light {
        background-color: #fff;
        border: none;
        border-radius: 5px;
        padding: 5px 15px;
        transition: background-color 0.3s;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
    }

    /* Graphiques */
    canvas {
        max-width: 100%;
        height: auto !important;
    }

    /* Tableau des réservations */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.875rem;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        #sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        main {
            margin-left: 0;
        }

        .row {
            flex-direction: column;
        }

        .col-md-4,
        .col-md-6 {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Tableau de Bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <i class="fas fa-users"></i> Clients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reservations.index') }}">
                            <i class="fas fa-calendar-alt"></i> Réservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="fas fa-user-cog"></i> Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <i class="fas fa-shield-alt"></i> Rôles
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de Bord</h1>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Clients</h5>
                            <p class="card-text">{{ $totalClients }} clients enregistrés</p>
                            <a href="{{ route('clients.index') }}" class="btn btn-light">Voir les clients</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Réservations</h5>
                            <p class="card-text">{{ $totalReservations }} réservations actives</p>
                            <a href="{{ route('reservations.index') }}" class="btn btn-light">Voir les réservations</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Utilisateurs</h5>
                            <p class="card-text">{{ $totalUsers }} utilisateurs enregistrés</p>
                            <a href="{{ route('users.index') }}" class="btn btn-light">Voir les utilisateurs</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques Interactifs -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Réservations par Mois
                        </div>
                        <div class="card-body">
                            <canvas id="reservationsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Clients par Mois
                        </div>
                        <div class="card-body">
                            <canvas id="clientsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dernières Réservations -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Dernières Réservations
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestReservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>{{ $reservation->client ? $reservation->client->nom . ' ' . $reservation->client->prenom : 'Inconnu' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $reservation->statut === 'confirmé' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($reservation->statut) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxReservations = document.getElementById('reservationsChart').getContext('2d');
        const ctxClients = document.getElementById('clientsChart').getContext('2d');

        const reservationsData = {
            labels: @json($reservationsByMonth->pluck('month')),
            datasets: [{
                label: 'Réservations par Mois',
                data: @json($reservationsByMonth->pluck('count')),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        };

        new Chart(ctxReservations, {
            type: 'line',
            data: reservationsData,
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Mois' } },
                    y: { beginAtZero: true, title: { display: true, text: 'Nombre de Réservations' } }
                }
            }
        });

        const clientsData = {
            labels: @json($clientsByMonth->pluck('month')),
            datasets: [{
                label: 'Clients par Mois',
                data: @json($clientsByMonth->pluck('count')),
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        };

        new Chart(ctxClients, {
            type: 'line',
            data: clientsData,
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Mois' } },
                    y: { beginAtZero: true, title: { display: true, text: 'Nombre de Clients' } }
                }
            }
        });
    });
</script>
@endsection