<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Client;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Affiche la liste des réservations.
     */
    public function index()
    {
        // Récupère toutes les réservations avec les clients associés
        $reservations = Reservation::with('client')->get();

        // Retourne la vue avec les réservations
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Affiche le formulaire de création d'une réservation.
     */
    public function create(Request $request)
{
    // Récupérer tous les clients
    $clients = Client::all();

    // Si aucun client n'existe, rediriger vers la création d'un client
    if ($clients->isEmpty()) {
        return redirect()->route('clients.create')
                         ->with('warning', 'Aucun client trouvé. Veuillez d\'abord créer un client.');
    }

    // Récupérer le client sélectionné (si client_id est présent)
    $client = null;
    if ($request->has('client_id')) {
        $client = Client::find($request->client_id);
    }

    // Retourner la vue avec les clients et le client sélectionné
    return view('reservations.create', compact('clients', 'client'));
}

    /**
     * Enregistre une nouvelle réservation dans la base de données.
     */
    public function store(Request $request)
    {
        // Valide les données du formulaire
        $request->validate([
            'client_id' => 'required|exists:clients,id', // Vérifie que le client existe
            'statut' => 'required|string|in:en attente,confirmé,annulé', // Valide que le statut est une chaîne et parmi les valeurs autorisées
        ]);

        try {
            // Crée la réservation
            Reservation::create($request->only(['client_id', 'statut']));

            // Redirige vers la liste des réservations avec un message de succès
            return redirect()->route('reservations.index')
                             ->with('success', 'Réservation créée avec succès.');

        } catch (\Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la création de la réservation: ' . $e->getMessage());

            // Redirige avec un message d'erreur
            return redirect()->back()
                             ->withInput()
                             ->withErrors(['error' => 'Une erreur s\'est produite lors de la création de la réservation.']);
        }
    }

    /**
     * Affiche les détails d'une réservation spécifique.
     */
    public function show(string $id)
    {
        // Récupère la réservation par son ID avec les données du client
        $reservation = Reservation::with('client')->findOrFail($id);

        // Retourne la vue avec les détails de la réservation
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Affiche le formulaire pour modifier une réservation.
     */
    public function edit(string $id)
    {
        // Récupère la réservation par son ID
        $reservation = Reservation::findOrFail($id);

        // Récupère tous les clients pour le formulaire de modification
        $clients = Client::all();

        // Retourne la vue pour modifier la réservation
        return view('reservations.edit', compact('reservation', 'clients'));
    }

    /**
     * Met à jour une réservation dans la base de données.
     */
    public function update(Request $request, string $id)
    {
        // Valide les données du formulaire
        $request->validate([
            'client_id' => 'required|exists:clients,id', // Vérifie que le client existe
            'statut' => 'required|string|in:en attente,confirmé,annulé', // Valide que le statut est une chaîne et parmi les valeurs autorisées
        ]);

        try {
            // Récupère la réservation par son ID
            $reservation = Reservation::findOrFail($id);

            // Met à jour la réservation
            $reservation->update($request->only(['client_id', 'statut']));

            // Redirige vers la liste des réservations avec un message de succès
            return redirect()->route('reservations.index')
                             ->with('success', 'Réservation mise à jour avec succès.');

        } catch (\Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la mise à jour de la réservation: ' . $e->getMessage());

            // Redirige avec un message d'erreur
            return redirect()->back()
                             ->withInput()
                             ->withErrors(['error' => 'Une erreur s\'est produite lors de la mise à jour de la réservation.']);
        }
    }

    /**
     * Supprime une réservation de la base de données.
     */
    public function destroy(string $id)
    {
        try {
            // Récupère la réservation par son ID
            $reservation = Reservation::findOrFail($id);

            // Supprime la réservation
            $reservation->delete();

            // Redirige vers la liste des réservations avec un message de succès
            return redirect()->route('reservations.index')
                             ->with('success', 'Réservation supprimée avec succès.');

        } catch (\Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la suppression de la réservation: ' . $e->getMessage());

            // Redirige avec un message d'erreur
            return redirect()->back()
                             ->withErrors(['error' => 'Une erreur s\'est produite lors de la suppression de la réservation.']);
        }
    }

    /**
     * Réserve un client après sa création.
     */
    /**
 * Réserve un client après sa création.
 */
/**
 * Réserve un client après sa création.
 */
public function reserve(Request $request, $id)
{
    try {
        // Récupère le client à réserver
        $client = Client::findOrFail($id);

        // Vérifie si une réservation existe déjà pour ce client
        if ($client->reservations()->where('statut', 'en attente')->exists()) {
            return redirect()->back()
                             ->withErrors(['error' => 'Ce client a déjà une réservation en attente.']);
        }

        // Crée une nouvelle réservation
        Reservation::create([
            'client_id' => $client->id,
            'statut' => 'en attente', // Statut par défaut
        ]);

        // Redirige vers la liste des réservations avec un message de succès
        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation effectuée pour ce client.');

    } catch (\Exception $e) {
        // Log de l'erreur pour le débogage
        Log::error('Erreur lors de la réservation du client: ' . $e->getMessage());

        // Redirige avec un message d'erreur
        return redirect()->back()
                         ->withErrors(['error' => 'Une erreur s\'est produite lors de la réservation du client.']);
    }
}
    /**
     * Confirme une réservation.
     */
    public function confirm(Reservation $reservation)
    {
        try {
            // Met à jour le statut de la réservation
            $reservation->update(['statut' => 'confirmé']);

            // Redirige vers la liste des réservations avec un message de succès
            return redirect()->route('reservations.index')
                             ->with('success', 'Réservation confirmée avec succès.');

        } catch (\Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error('Erreur lors de la confirmation de la réservation: ' . $e->getMessage());

            // Redirige avec un message d'erreur
            return redirect()->back()
                             ->withErrors(['error' => 'Une erreur s\'est produite lors de la confirmation de la réservation.']);
        }
    }
}