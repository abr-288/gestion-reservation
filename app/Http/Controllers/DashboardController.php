<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reservation;
use App\Models\User; // N'oublie pas d'ajouter le modèle User
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer les statistiques des clients, réservations et utilisateurs
        $totalClients = Client::count(); // Nombre total de clients
        $totalReservations = Reservation::count(); // Nombre total de réservations
        $totalUsers = User::count(); // Nombre total d'utilisateurs

        // Récupérer les réservations et clients par mois
        $reservationsByMonth = Reservation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $clientsByMonth = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Récupérer les dernières réservations
        $latestReservations = Reservation::latest()->take(5)->get();

        // Passer les données à la vue
        return view('dashboard', compact(
            'totalClients',
            'totalReservations',
            'totalUsers', // Ajouter totalUsers ici
            'reservationsByMonth',
            'clientsByMonth',
            'latestReservations'
        ));
    }
}
