<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bossiz - Connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #041302;
            margin: 0;
        }

        .login-container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-container img {
            width: 600px;
            margin-bottom: 2px;
        }

        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #343a40;
        }

        .login-container .btn {
            margin: 10px;
            padding: 10px 20px;
            font-size: 20px;
            border-radius: 5px;
        }

        .login-container .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .login-container .btn-secondary {
            background-color: #036608;
            border-color: #036608;
        }

        .login-container .btn-primary:hover,
        .login-container .btn-secondary:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo Bossiz -->
        <img src="{{ asset('images/logo-bossiz.png') }}" alt="Logo Bossiz">

        <!-- Titre -->
        <h1>Bienvenue sur Bossiz</h1>

        <!-- Options de connexion -->
        <div>
            @guest
                <!-- Lien de connexion -->
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </a>

                <!-- Lien d'inscription -->
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i> Inscription
                    </a>
                @endif
            @endguest

            @auth
                <!-- Lien vers le tableau de bord si l'utilisateur est connecté -->
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-tachometer-alt"></i> Tableau de Bord
                </a>
            @endauth
        </div>
    </div>

    <!-- Bootstrap JS et dépendances -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>