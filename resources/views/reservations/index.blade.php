@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Liste des Réservations</h1>

        <!-- Lien pour créer une nouvelle réservation -->
        <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-4">
            <i class="fas fa-plus"></i> Créer une nouvelle réservation
        </a>

        <!-- Tableau pour afficher la liste des réservations -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom du Client</th>
                        <th>Prénom du Client</th>
                        <th class="d-none d-md-table-cell">Type de Document</th>
                        <th class="d-none d-md-table-cell">Numéro de Document</th>
                        <th class="d-none d-md-table-cell">Type de Voyage</th>
                        <th class="d-none d-md-table-cell">Date de Voyage Aller</th>
                        <th class="d-none d-md-table-cell">Date d'Annulation</th>
                        <th>Numéro de Client</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->client ? $reservation->client->nom : 'N/A' }}</td>
                            <td>{{ $reservation->client ? $reservation->client->prenom : 'N/A' }}</td>
                            <td class="d-none d-md-table-cell">{{ $reservation->client ? $reservation->client->type_document : 'N/A' }}</td>
                            <td class="d-none d-md-table-cell">{{ $reservation->client ? $reservation->client->numero_document : 'N/A' }}</td>
                            <td class="d-none d-md-table-cell">{{ $reservation->client ? $reservation->client->type_voyage : 'N/A' }}</td>
                            <td class="d-none d-md-table-cell">{{ $reservation->client ? $reservation->client->date_voyage_aller : 'N/A' }}</td>
                            <td class="d-none d-md-table-cell">{{ $reservation->client ? $reservation->client->date_annulation : 'N/A' }}</td>
                            <td>{{ $reservation->client ? $reservation->client->numero_client : 'N/A' }}</td>
                            <td>
                                <span class="badge 
                                    @if($reservation->statut === 'confirmé') badge-success 
                                    @elseif($reservation->statut === 'en attente') badge-warning 
                                    @elseif($reservation->statut === 'annulé') badge-danger 
                                    @else badge-secondary 
                                    @endif">
                                    {{ $reservation->statut }}
                                </span>
                            </td>
                            <td class="action-buttons">
                                <!-- Lien pour afficher les détails de la réservation -->
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-info btn-sm" title="Détails">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Lien pour modifier la réservation -->
                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Formulaire pour supprimer la réservation -->
                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <!-- Formulaire pour confirmer la réservation -->
                                <form action="{{ route('reservations.confirm', $reservation->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Confirmer">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Styles pour le tableau */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.8px;
        }

        .table thead th {
            background-color: #343a40;
            color: #ffffff;
            text-transform: uppercase;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Boutons d'action */
        .action-buttons {
            display: flex;
            flex-direction: row;
            gap: 5px;
            justify-content: center;
        }

        /* Styles pour les petits écrans */
        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-sm {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>

    <script>
        /* JavaScript pour confirmer la suppression */
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll(".btn-danger");
            deleteButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    if (!confirm("Êtes-vous sûr de vouloir supprimer cette réservation ?")) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection