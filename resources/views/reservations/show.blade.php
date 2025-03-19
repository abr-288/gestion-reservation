@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Détails de la Réservation</h1>

        <div class="reservation-details">
            <!-- Informations du Client -->
            <h2 class="mb-3">
                <i class="fas fa-user"></i> Informations du Client
            </h2>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-id-card"></i> Nom :</strong> {{ $reservation->client->nom }}</p>
                            <p><strong><i class="fas fa-id-card"></i> Prénom :</strong> {{ $reservation->client->prenom }}</p>
                            <p><strong><i class="fas fa-file-alt"></i> Type de Document :</strong> {{ $reservation->client->type_document }}</p>
                            <p><strong><i class="fas fa-hashtag"></i> Numéro de Document :</strong> {{ $reservation->client->numero_document }}</p>
                            <p><strong><i class="fas fa-ticket-alt"></i> PNR :</strong> {{ $reservation->client->PNR }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-plane"></i> Type de Voyage :</strong> {{ $reservation->client->type_voyage }}</p>
                            <p><strong><i class="fas fa-calendar-alt"></i> Date de Voyage Aller :</strong> {{ $reservation->client->date_voyage_aller }}</p>
                            <p><strong><i class="fas fa-calendar-alt"></i> Date de Voyage Retour :</strong> {{ $reservation->client->date_voyage_retour }}</p>
                            <p><strong><i class="fas fa-calendar-times"></i> Date d'Annulation :</strong> {{ $reservation->client->date_annulation }}</p>
                            <p><strong><i class="fas fa-user-tag"></i> Numéro de Client :</strong> {{ $reservation->client->numero_client }}</p>
                            <p><strong><i class="fas fa-money-bill-wave"></i> Prix du Billet :</strong> {{ $reservation->client->prix_billet }}</p>
                            <p><strong><i class="fas fa-user-tie"></i> Nom de l'Agent :</strong> {{ $reservation->client->nom_agent }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de la Réservation -->
            <h2 class="mb-3">
                <i class="fas fa-calendar-check"></i> Informations de la Réservation
            </h2>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag"></i> ID Réservation :</strong> {{ $reservation->id }}</p>
                            <p><strong><i class="fas fa-info-circle"></i> Statut :</strong>
                                <span class="badge 
                                    @if($reservation->statut === 'confirmé') badge-success 
                                    @elseif($reservation->statut === 'en attente') badge-warning 
                                    @elseif($reservation->statut === 'annulé') badge-danger 
                                    @else badge-secondary 
                                    @endif">
                                    {{ $reservation->statut }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar-plus"></i> Date de Création :</strong> {{ $reservation->created_at }}</p>
                            <p><strong><i class="fas fa-calendar-edit"></i> Dernière Mise à Jour :</strong> {{ $reservation->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton pour retourner à la liste des réservations -->
            <div class="text-center">
                <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>
@endsection