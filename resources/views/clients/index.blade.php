@extends('layouts.app')

@section('content')
    <div class="container-fluid custom-container">
        <h1 class="my-4 text-center text-primary">Liste des Clients</h1>

        <!-- Lien pour créer un nouveau client -->
        <a href="{{ route('clients.create') }}" class="btn btn-primary mb-4">
            <i class="fas fa-plus"></i> Créer un nouveau client
        </a>

        <!-- Tableau pour afficher la liste des clients -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover custom-table">
                <thead class="thead-custom">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th class="d-none d-md-table-cell">Type de Document</th>
                        <th class="d-none d-md-table-cell">Numéro de Document</th>
                        <th>PNR</th>
                        <th class="d-none d-md-table-cell">Type de Voyage</th>
                        <th class="d-none d-md-table-cell">Date Voyage Aller</th>
                        <th class="d-none d-md-table-cell">Date Voyage Retour</th>
                        <th class="d-none d-md-table-cell">Date d'Annulation</th>
                        <th>Numéro de Client</th>
                        <th class="d-none d-md-table-cell">Prix du Billet</th>
                        <th class="d-none d-md-table-cell">Nom de l'Agent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->prenom }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->type_document }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->numero_document }}</td>
                            <td>{{ $client->PNR }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->type_voyage }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->date_voyage_aller }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->date_voyage_retour }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->date_annulation }}</td>
                            <td>{{ $client->numero_client }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->prix_billet }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->nom_agent }}</td>
                            <td class="action-buttons">
                                <!-- Lien pour modifier le client -->
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Formulaire pour supprimer le client -->
                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <!-- Formulaire pour réserver le client -->
                                <form action="{{ route('clients.reserve', $client->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Réserver">
                                        <i class="fas fa-calendar-check"></i>
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
            font-size: 12px;
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