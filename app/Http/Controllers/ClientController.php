<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client; // Modèle Client
use App\Models\Reservation; // Modèle Reservation
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients.
     */
    public function index()
    {
        // Récupère tous les clients avec leurs réservations
        $clients = Client::with('reservations')->get();

        // Retourne la vue avec les clients
        return view('clients.index', compact('clients'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau client.
     */
    public function create()
    {
        // Retourne la vue pour créer un nouveau client
        return view('clients.create');
    }

    /**
     * Enregistre un nouveau client dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'type_document' => 'required|string|max:255',
            'numero_document' => 'required|string|max:255|unique:clients,numero_document',
            'PNR' => 'required|string|max:255|unique:clients,PNR',
            'type_voyage' => 'required|string|max:255',
            'date_voyage_aller' => 'required|date',
            'date_voyage_retour' => 'nullable|date',
            'date_annulation' => 'nullable|date',
            'numero_client' => 'required|string|max:255|unique:clients,numero_client',
            'prix_billet' => 'required|numeric',
            'nom_agent' => 'required|string|max:255',
        ]);

        try {
            // Créer le client avec les données validées
            Client::create($request->all());

            // Rediriger vers la liste des clients avec un message de succès
            return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');

        } catch (QueryException $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la création du client: ' . $e->getMessage());

            // Vérification si l'erreur est due à une violation de contrainte d'unicité
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = 'Une valeur unique (PNR, numéro de document ou numéro client) est déjà utilisée.';
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => $errorMessage]);
            }

            // Gestion d'autres types d'erreurs de base de données
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur s\'est produite lors de la création du client.']);
        }
    }

    /**
     * Affiche les détails d'un client spécifique.
     */
    public function show(string $id)
    {
        // Récupère le client par son ID avec les réservations associées
        $client = Client::with('reservations')->findOrFail($id);

        // Retourne la vue avec les détails du client
        return view('clients.show', compact('client'));
    }

    /**
     * Affiche le formulaire pour modifier un client.
     */
    public function edit(string $id)
    {
        // Récupère le client par son ID
        $client = Client::findOrFail($id);

        // Retourne la vue pour éditer le client
        return view('clients.edit', compact('client'));
    }

    /**
     * Met à jour un client dans la base de données.
     */
    public function update(Request $request, string $id)
    {
        // Valide les données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'type_document' => 'required|in:Passeport,Carte nationale d\'identité',
            'numero_document' => 'required|string|max:255|unique:clients,numero_document,' . $id,
            'PNR' => 'required|string|max:255|unique:clients,PNR,' . $id,
            'type_voyage' => 'required|in:aller_simple,aller_retour',
            'date_voyage_aller' => 'required|date',
            'date_voyage_retour' => 'nullable|date',
            'date_annulation' => 'nullable|date',
            'numero_client' => 'required|string|max:255|unique:clients,numero_client,' . $id,
            'prix_billet' => 'required|numeric',
            'nom_agent' => 'required|string|max:255',
        ]);

        try {
            // Récupère le client par son ID
            $client = Client::findOrFail($id);

            // Met à jour les données du client
            $client->update($request->all());

            // Redirige vers la liste des clients avec un message de succès
            return redirect()->route('clients.index')
                             ->with('success', 'Client mis à jour avec succès.');

        } catch (QueryException $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la mise à jour du client: ' . $e->getMessage());

            // Vérification si l'erreur est due à une violation de contrainte d'unicité
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = 'Une valeur unique (PNR, numéro de document ou numéro client) est déjà utilisée.';
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => $errorMessage]);
            }

            // Gestion d'autres types d'erreurs de base de données
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur s\'est produite lors de la mise à jour du client.']);
        }
    }

    /**
     * Supprime un client de la base de données.
     */
    public function destroy(string $id)
    {
        try {
            // Récupère le client par son ID
            $client = Client::findOrFail($id);

            // Supprime le client
            $client->delete();

            // Redirige vers la liste des clients avec un message de succès
            return redirect()->route('clients.index')
                             ->with('success', 'Client supprimé avec succès.');

        } catch (\Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la suppression du client: ' . $e->getMessage());

            // Redirige avec un message d'erreur
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur s\'est produite lors de la suppression du client.']);
        }
    }

    /**
     * Réserve un client après sa création.
     */
    public function reserve(Request $request, $id)
    {
        try {
            // Récupérer le client à réserver
            $client = Client::findOrFail($id);

            // Vérifier si une réservation existe déjà pour ce client
            if ($client->reservations()->where('statut', 'en attente')->exists()) {
                return redirect()->back()
                                 ->withErrors(['error' => 'Ce client a déjà une réservation en attente.']);
            }

            // Créer une nouvelle réservation
            Reservation::create([
                'client_id' => $client->id,
                'statut' => 'en attente', // Statut par défaut
            ]);

            // Rediriger vers la liste des réservations avec un message de succès
            return redirect()->route('reservations.index')
                             ->with('success', 'Réservation effectuée pour ce client.');

        } catch (\Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la réservation du client: ' . $e->getMessage());

            // Rediriger avec un message d'erreur
            return redirect()->back()
                             ->withErrors(['error' => 'Une erreur s\'est produite lors de la réservation du client.']);
        }
    }
}