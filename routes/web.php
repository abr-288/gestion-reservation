<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ressources pour les entités principales
Route::resource('clients', ClientController::class);
Route::resource('reservations', ReservationController::class);
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

// Routes spécifiques aux réservations
Route::post('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');

// Route pour réserver un client
Route::post('/clients/{client}/reserve', [ClientController::class, 'reserve'])->name('clients.reserve');

// Route pour afficher la liste des réservations
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
});
// Route pour afficher le profil de l'utilisateur connecté


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::resource('users', UserController::class);
// Route pour afficher le formulaire de modification
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// Route pour mettre à jour le profil
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
// Route de test
Route::get('/test', function () {
    return 'Test route is working!';
});
// Routes protégées par authentification
// routes/web.php

// Routes pour la réinitialisation du mot de passe
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/clients/{client}/reserve', [ClientController::class, 'reserve'])->name('clients.reserve');
// Route pour réserver un client
Route::post('/clients/{client}/reserve', [ReservationController::class, 'reserve'])->name('clients.reserve');

// Routes pour les clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
Route::post('/clients/{client}/reserve', [ClientController::class, 'reserve'])->name('clients.reserve');