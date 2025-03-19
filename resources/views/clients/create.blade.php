@extends('layouts.app')

@section('content')
    <h1>Créer un nouveau client</h1>

    <!-- Affichage des messages de succès ou d'erreur -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required>
        </div>
        <div>
            <label for="type_document">Type de document :</label>
            <select name="type_document" id="type_document" required>
                <option value="Passeport" {{ old('type_document') == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                <option value="Carte nationale d'identité" {{ old('type_document') == 'Carte nationale d\'identité' ? 'selected' : '' }}>Carte nationale d'identité</option>
            </select>
        </div>
        <div>
            <label for="numero_document">Numéro de document :</label>
            <input type="text" name="numero_document" id="numero_document" value="{{ old('numero_document') }}" required>
        </div>
        <div>
            <label for="PNR">PNR :</label>
            <input type="text" name="PNR" id="PNR" value="{{ old('PNR') }}" required>
        </div>
        <div>
            <label for="type_voyage">Type de voyage :</label>
            <select name="type_voyage" id="type_voyage" required onchange="toggleReturnDate()">
                <option value="aller_simple" {{ old('type_voyage') == 'aller_simple' ? 'selected' : '' }}>Aller simple</option>
                <option value="aller_retour" {{ old('type_voyage') == 'aller_retour' ? 'selected' : '' }}>Aller-retour</option>
            </select>
        </div>
        <div>
            <label for="date_voyage_aller">Date de voyage aller :</label>
            <input type="date" name="date_voyage_aller" id="date_voyage_aller" value="{{ old('date_voyage_aller') }}" required>
        </div>
        <div>
            <label for="date_voyage_retour">Date de voyage retour :</label>
            <input type="date" name="date_voyage_retour" id="date_voyage_retour" value="{{ old('date_voyage_retour') }}">
        </div>
        <div>
            <label for="date_annulation">Date et heure d'annulation :</label>
            <input type="datetime-local" name="date_annulation" id="date_annulation" value="{{ old('date_annulation') }}">
        </div>
        <div>
            <label for="numero_client">Numéro de client :</label>
            <input type="text" name="numero_client" id="numero_client" value="{{ old('numero_client') }}" required>
        </div>
        <div>
            <label for="prix_billet">Prix du billet :</label>
            <input type="number" name="prix_billet" id="prix_billet" value="{{ old('prix_billet') }}" required>
        </div>
        <div>
            <label for="nom_agent">Nom de l'agent :</label>
            <input type="text" name="nom_agent" id="nom_agent" value="{{ old('nom_agent') }}" required>
        </div>
        <button type="submit">Créer</button>
    </form>

    <!-- Intégration du CSS -->
    <style>
        /* Style général du formulaire */
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style des labels */
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        /* Style des champs de formulaire */
        form input[type="text"],
        form input[type="number"],
        form input[type="date"],
        form input[type="datetime-local"],
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Style du bouton de soumission */
        form button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Style pour les champs désactivés */
        form input:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        /* Style pour les messages d'erreur */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }

        .alert ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    </style>

    <!-- Intégration du JavaScript -->
    <script>
        // Fonction pour griser/désactiver la date de retour si "Aller simple" est sélectionné
        function toggleReturnDate() {
            const typeVoyage = document.getElementById('type_voyage').value;
            const dateRetourInput = document.getElementById('date_voyage_retour');

            if (typeVoyage === 'aller_simple') {
                dateRetourInput.disabled = true;
                dateRetourInput.value = ''; // Effacer la valeur si le champ est désactivé
            } else {
                dateRetourInput.disabled = false;
            }
        }

        // Appeler la fonction au chargement de la page pour s'assurer que le champ est correctement désactivé
        document.addEventListener('DOMContentLoaded', toggleReturnDate);

        // Ajouter un écouteur d'événement pour réagir aux changements du type de voyage
        document.getElementById('type_voyage').addEventListener('change', toggleReturnDate);
    </script>
@endsection