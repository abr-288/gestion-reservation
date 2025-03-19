<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('styles')
<style>
    /* Styles personnalisés pour la page de connexion */
    body {
        background-color: #f0f4f8; /* Fond clair */
        font-family: 'Arial', sans-serif;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .card-header {
        background-color: #007bff; /* Bleu Bossiz */
        color: white;
        text-align: center;
        font-size: 1.5rem;
        padding: 20px;
        border-radius: 15px 15px 0 0;
    }

    .card-body {
        padding: 30px;
        background-color: #ffffff;
        border-radius: 0 0 15px 15px;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #007bff; /* Bleu Bossiz */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff; /* Bleu Bossiz */
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        width: 100%;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Bleu foncé au survol */
    }

    .btn-link {
        color: #007bff; /* Bleu Bossiz */
        text-decoration: none;
        font-size: 14px;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .create-account {
        text-align: center;
        margin-top: 20px;
    }

    .create-account a {
        color: #007bff; /* Bleu Bossiz */
        text-decoration: none;
        font-weight: bold;
    }

    .create-account a:hover {
        text-decoration: underline;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        color: #333;
    }

    .invalid-feedback {
        color: #dc3545; /* Rouge pour les erreurs */
        font-size: 14px;
    }

    .form-check-label {
        color: #555;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Connexion') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Champ Email -->
                    <div class="form-group">
                        <label for="email">{{ __('Adresse Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="form-group">
                        <label for="password">{{ __('Mot de passe') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Case à cocher "Se souvenir de moi" -->
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Se souvenir de moi') }}
                            </label>
                        </div>
                    </div>

                    <!-- Bouton de connexion -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Connexion') }}
                        </button>
                    </div>

                    <!-- Lien "Mot de passe oublié" -->
                    <div class="form-group text-center">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    </div>
                </form>

                <!-- Bouton "Créer un compte" -->
                <div class="create-account">
                    <p>Vous n'avez pas de compte ? <a href="{{ route('register') }}">{{ __('Créer un compte') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection